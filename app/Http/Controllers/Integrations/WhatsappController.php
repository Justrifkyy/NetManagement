<?php

namespace App\Http\Controllers\Integrations;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsappController extends Controller
{
    /**
     * URL lokal Server PM2 Node.js Anda (Contoh berjalan di port 3000)
     */
    private $waApiUrl = 'http://127.0.0.1:3000/send-message'; 

    /**
     * Fungsi Dasar Kirim Pesan Teks
     */
    public function sendMessage($phone, $message)
    {
        try {
            // Pastikan format nomor benar (misal: ubah 08 jadi 628)
            if (substr($phone, 0, 1) == '0') {
                $phone = '62' . substr($phone, 1);
            }

            // Hit API ke PM2 Bot Anda
            $response = Http::post($this->waApiUrl, [
                'number' => $phone . '@c.us', // Format whatsapp
                'message' => $message
            ]);

            if ($response->successful()) {
                Log::info("WA Terkirim ke: $phone");
                return true;
            }

            Log::error("WA Gagal dikirim ke $phone. Response: " . $response->body());
            return false;

        } catch (\Exception $e) {
            Log::error("WA Bot Down (PM2 Error): " . $e->getMessage());
            return false;
        }
    }

    /**
     * FUNGSI OTOMATIS 1: Kirim Notifikasi Tagihan (Invoice)
     */
    public function sendInvoiceNotification($customerName, $phone, $invoiceNumber, $amount, $dueDate)
    {
        $amountFormatted = number_format($amount, 0, ',', '.');
        $message = "Halo *{$customerName}*,\n\n";
        $message .= "Ini adalah pengingat tagihan internet Anda dari *NetManager*.\n\n";
        $message .= "🧾 No. Tagihan: {$invoiceNumber}\n";
        $message .= "💰 Jumlah: Rp {$amountFormatted}\n";
        $message .= "🗓 Jatuh Tempo: {$dueDate}\n\n";
        $message .= "Mohon segera melakukan pembayaran untuk menghindari isolir otomatis. Terima kasih! 🙏";

        return $this->sendMessage($phone, $message);
    }

    /**
     * FUNGSI OTOMATIS 2: Kirim Notifikasi Tiket (Laporan Gangguan)
     */
    public function sendTicketUpdate($customerName, $phone, $ticketSubject, $status)
    {
        $message = "Halo *{$customerName}*,\n\n";
        $message .= "Status tiket laporan Anda (*{$ticketSubject}*) telah diperbarui menjadi: *{$status}*.\n\n";
        $message .= "Teknisi kami sedang memproses permintaan Anda. Terima kasih atas kesabarannya.";

        return $this->sendMessage($phone, $message);
    }
}