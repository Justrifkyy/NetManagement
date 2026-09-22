<?php

namespace App\Http\Controllers\Integrations;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class WhatsappController extends Controller
{
    /**
     * Mendapatkan URL endpoint pengiriman pesan WhatsApp Gateway
     */
    public static function getEndpoint(): string
    {
        $baseUrl = rtrim(config('services.whatsapp.api_url', env('WA_API_URL', 'http://127.0.0.1:3000')), '/');
        return str_ends_with($baseUrl, '/send-message') ? $baseUrl : $baseUrl . '/send-message';
    }

    /**
     * Sanitasi dan format nomor telepon ke standar internasional (62xxxx)
     */
    public static function formatPhoneNumber(string $phone): string
    {
        // 1. Buang semua karakter selain angka
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // 2. Jika diawali angka 0, ubah menjadi 62
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        return $phone;
    }

    /**
     * Fungsi Statis Utama: Kirim Pesan Teks via Node.js Bot Gateway
     *
     * @param string $phone Nomor HP tujuan
     * @param string $message Konten pesan teks
     * @return bool
     */
    public static function send(string $phone, string $message): bool
    {
        try {
            $formattedPhone = self::formatPhoneNumber($phone);

            if (empty($formattedPhone)) {
                Log::warning('WhatsApp Gateway: Nomor telepon kosong atau tidak valid.');
                return false;
            }

            $endpoint = self::getEndpoint();

            // Panggilan HTTP POST dengan timeout 5 detik agar fail-safe
            $response = Http::timeout(5)->post($endpoint, [
                'number'  => $formattedPhone,
                'message' => $message,
            ]);

            if ($response->successful()) {
                Log::info("WhatsApp Gateway: Pesan berhasil dikirim ke {$formattedPhone}");
                return true;
            }

            Log::error("WhatsApp Gateway: Gagal kirim ke {$formattedPhone}. Status: {$response->status()}, Response: " . $response->body());
            return false;

        } catch (Throwable $e) {
            // Fail-safe jika server Node.js / PM2 offline
            Log::error("WhatsApp Gateway Offline / Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Method instance untuk backward-compatibility
     */
    public function sendMessage($phone, $message): bool
    {
        return self::send($phone, $message);
    }

    /**
     * FUNGSI OTOMATIS: Kirim Notifikasi Pembayaran Berhasil (Payment Success)
     *
     * @param string $customerName
     * @param string $phone
     * @param string $invoiceNumber
     * @param int|float $amount
     * @return bool
     */
    public static function sendPaymentSuccess(string $customerName, string $phone, string $invoiceNumber, $amount): bool
    {
        $amountFormatted = number_format((float) $amount, 0, ',', '.');

        $message = "Halo {$customerName}, Terima kasih! Pembayaran tagihan {$invoiceNumber} sebesar Rp{$amountFormatted} telah berhasil kami terima. Akses internet Anda telah diaktifkan kembali. - PT. Mandiri Global Data";

        return self::send($phone, $message);
    }

    /**
     * FUNGSI OTOMATIS: Kirim Pengingat Tagihan (Invoice Reminder)
     */
    public function sendInvoiceNotification($customerName, $phone, $invoiceNumber, $amount, $dueDate): bool
    {
        $amountFormatted = number_format((float) $amount, 0, ',', '.');
        $message = "Halo *{$customerName}*,\n\n";
        $message .= "Ini adalah pengingat tagihan internet Anda dari *NetManager*.\n\n";
        $message .= "🧾 No. Tagihan: {$invoiceNumber}\n";
        $message .= "💰 Jumlah: Rp {$amountFormatted}\n";
        $message .= "🗓 Jatuh Tempo: {$dueDate}\n\n";
        $message .= 'Mohon segera melakukan pembayaran untuk menghindari isolir otomatis. Terima kasih! 🙏';

        return self::send($phone, $message);
    }

    /**
     * FUNGSI OTOMATIS: Kirim Notifikasi Update Tiket Gangguan
     */
    public function sendTicketUpdate($customerName, $phone, $ticketSubject, $status): bool
    {
        $message = "Halo *{$customerName}*,\n\n";
        $message .= "Status tiket laporan Anda (*{$ticketSubject}*) telah diperbarui menjadi: *{$status}*.\n\n";
        $message .= 'Teknisi kami sedang memproses permintaan Anda. Terima kasih atas kesabarannya.';

        return self::send($phone, $message);
    }
}
