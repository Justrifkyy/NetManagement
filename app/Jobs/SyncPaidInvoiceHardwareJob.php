<?php

namespace App\Jobs;

use App\Models\Invoice;
use App\Services\NetworkService;
use App\Services\WhatsappService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class SyncPaidInvoiceHardwareJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Invoice $invoice;

    /**
     * Jumlah percobaan ulang job jika terjadi timeout
     */
    public int $tries = 3;

    /**
     * Waktu jeda sebelum percobaan ulang (dalam detik)
     */
    public array $backoff = [10, 30, 60];

    /**
     * Create a new job instance.
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Execute the job.
     * Menjalankan komunikasi soket ke RouterOS MikroTik dan Gateway WhatsApp
     * secara asinkron di background queue agar tidak memblokir respon HTTP webhook.
     */
    public function handle(NetworkService $networkService): void
    {
        $invoice = $this->invoice->fresh(['subscription.customer.user', 'subscription.customer.lead']);

        if (!$invoice) {
            Log::warning("SyncPaidInvoiceHardwareJob: Invoice #{$this->invoice->id} tidak ditemukan.");
            return;
        }

        Log::info("SyncPaidInvoiceHardwareJob: Memulai sinkronisasi perangkat keras untuk Invoice #{$invoice->invoice_number}");

        // 1. Aktivasi / Un-isolate PPPoE di Router MikroTik
        if ($invoice->subscription) {
            try {
                $networkService->enableCustomer($invoice->subscription);
                Log::info("SyncPaidInvoiceHardwareJob: Layanan PPPoE diaktifkan di MikroTik untuk Subscription #{$invoice->subscription->id}.");
            } catch (Throwable $e) {
                Log::error("SyncPaidInvoiceHardwareJob: Gagal mengaktifkan router MikroTik untuk Subscription #{$invoice->subscription->id}: " . $e->getMessage());
            }
        }

        // 2. Kirim Notifikasi Pelunasan via WhatsApp Gateway
        if ($invoice->subscription && $invoice->subscription->customer) {
            try {
                $customer = $invoice->subscription->customer;
                $customerName = $customer->user?->name ?? $customer->lead?->name ?? 'Pelanggan';
                $customerPhone = $customer->phone_number ?? $customer->user?->phone_number ?? $customer->lead?->phone ?? null;

                if ($customerPhone) {
                    WhatsappService::sendPaymentSuccess(
                        $customerName,
                        $customerPhone,
                        $invoice->invoice_number,
                        $invoice->amount
                    );
                    Log::info("SyncPaidInvoiceHardwareJob: Pesan WhatsApp pembayaran sukses terkirim ke {$customerPhone} ({$customerName})");
                } else {
                    Log::warning("SyncPaidInvoiceHardwareJob: Nomor telepon customer kosong untuk Invoice #{$invoice->invoice_number}");
                }
            } catch (Throwable $e) {
                Log::error("SyncPaidInvoiceHardwareJob: Gagal mengirim pesan WhatsApp: " . $e->getMessage());
            }
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(?Throwable $exception): void
    {
        Log::error("SyncPaidInvoiceHardwareJob FATAL: Job gagal diproses untuk Invoice #{$this->invoice->invoice_number}: " . $exception?->getMessage());
    }
}
