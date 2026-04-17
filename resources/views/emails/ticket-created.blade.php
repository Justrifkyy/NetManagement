<x-mail::message>
# 🎟️ Tiket Baru Dibuat

Halo {{ $ticket->customer->user->name }},

Tiket anda telah berhasil dibuat dengan nomor **#{{ $ticket->id }}**.

## Detail Tiket:
- **Subjek:** {{ $ticket->subject }}
- **Tipe:** {{ ucfirst($ticket->type) }}
- **Status:** {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
- **Dibuat:** {{ $ticket->created_at->format('d M Y, H:i') }}

## Deskripsi:
{{ $ticket->description }}

Tim teknisi kami akan segera menangani tiket anda.

<x-mail::button :url="url('/customer/tickets/' . $ticket->id)">
Lihat Detail
</x-mail::button>

Terima kasih,
{{ config('app.name') }}
</x-mail::message>
