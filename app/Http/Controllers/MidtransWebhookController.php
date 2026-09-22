<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Integrations\NetworkController;
use App\Http\Controllers\Integrations\WhatsappController;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class MidtransWebhookController extends Controller
{
    /**
     * Handle incoming notification webhook from Midtrans.
     */
    public function handleNotification(Request $request)
    {
        $payload = $request->all();
        Log::info('Midtrans Webhook Received:', $payload);

        $orderId = $request->input('order_id');
        $statusCode = $request->input('status_code');
        $grossAmount = $request->input('gross_amount');
        $signatureKey = $request->input('signature_key');
        $serverKey = config('services.midtrans.server_key');

        // Validasi keamanan: Verifikasi SHA-512 Signature Key dari Midtrans
        if ($serverKey) {
            $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);
            if ($signatureKey !== $expectedSignature) {
                Log::warning('Midtrans Webhook: Invalid signature', [
                    'order_id' => $orderId,
                    'provided' => $signatureKey,
                    'expected' => $expectedSignature,
                ]);
                return response()->json(['message' => 'Invalid signature key'], 403);
            }
        }

        // Cari tagihan terkait berdasarkan invoice_number
        $invoice = Invoice::where('invoice_number', $orderId)->first();
        if (!$invoice) {
            Log::warning('Midtrans Webhook: Invoice not found for order_id ' . $orderId);
            return response()->json(['message' => 'Invoice not found'], 404);
        }

        $transactionStatus = $request->input('transaction_status');
        $fraudStatus = $request->input('fraud_status');

        // Jika transaksi berhasil (settlement atau capture accept)
        if ($transactionStatus === 'settlement' || ($transactionStatus === 'capture' && $fraudStatus === 'accept')) {
            $invoice->update([
                'status'         => 'paid',
                'paid_at'        => now(),
                'payment_method' => 'midtrans',
            ]);

            Log::info("Midtrans Webhook: Invoice #{$invoice->invoice_number} successfully marked as PAID.");

            // Otomatisasi Router MikroTik: Aktifkan kembali layanan / un-isolate PPPoE pelanggan
            if ($invoice->subscription) {
                try {
                    $networkController = app(NetworkController::class);
                    $networkController->enableCustomer($invoice->subscription);
                    Log::info("Midtrans Webhook: Perintah aktivasi router MikroTik dieksekusi untuk Subscription #{$invoice->subscription->id}.");
                } catch (Throwable $e) {
                    // Fail-safe jika router fisik offline/timeout agar sistem tidak crash & tagihan tetap lunas
                    Log::error("Midtrans Webhook: Router MikroTik offline / gagal dihubungi saat aktivasi Subscription #{$invoice->subscription->id}: " . $e->getMessage());
                }
            }

            // Otomatisasi WhatsApp Gateway: Kirim notifikasi pembayaran lunas ke nomor HP pelanggan
            if ($invoice->subscription && $invoice->subscription->customer) {
                try {
                    $customer = $invoice->subscription->customer;
                    $customerName = $customer->user?->name ?? $customer->lead?->name ?? 'Pelanggan';
                    $customerPhone = $customer->phone_number ?? $customer->user?->phone_number ?? $customer->lead?->phone ?? null;

                    if ($customerPhone) {
                        WhatsappController::sendPaymentSuccess(
                            $customerName,
                            $customerPhone,
                            $invoice->invoice_number,
                            $invoice->amount
                        );
                        Log::info("Midtrans Webhook: Notifikasi WhatsApp lunas dipicu ke {$customerPhone} ({$customerName})");
                    } else {
                        Log::warning("Midtrans Webhook: Nomor WhatsApp tidak ditemukan untuk Invoice #{$invoice->invoice_number}");
                    }
                } catch (Throwable $e) {
                    // Fail-safe jika bot Node.js / PM2 offline
                    Log::error("Midtrans Webhook: Gagal mengirim WhatsApp notifikasi: " . $e->getMessage());
                }
            }
        } elseif ($transactionStatus === 'pending') {
            // Transaksi sedang menunggu pembayaran (misal: VA / Indomaret dibuat)
            Log::info("Midtrans Webhook: Invoice #{$invoice->invoice_number} is PENDING.");
        } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            // Transaksi dibatalkan / gagal / kedaluwarsa
            Log::info("Midtrans Webhook: Invoice #{$invoice->invoice_number} is {$transactionStatus}.");
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Notification processed successfully',
        ], 200);
    }
}
