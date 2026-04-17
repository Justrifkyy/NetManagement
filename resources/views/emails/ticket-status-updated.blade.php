<x-mail::message>
# 📌 Status Tiket Diperbarui

Halo,

Status tiket anda **#{{ $ticket->id }}** telah diperbarui.

## Perubahan:
- **Dari:** {{ ucfirst(str_replace('_', ' ', $oldStatus)) }}
- **Ke:** **{{ ucfirst(str_replace('_', ' ', $newStatus)) }}**
- **Waktu:** {{ now()->format('d M Y, H:i') }}

## Subjek Tiket:
{{ $ticket->subject }}

<x-mail::button :url="url('/customer/tickets/' . $ticket->id)">
Lihat Detail
</x-mail::button>

Terima kasih,
{{ config('app.name') }}
</x-mail::message>
