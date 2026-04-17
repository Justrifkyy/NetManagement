<?php

namespace App\Services;

use App\Jobs\SendEmailNotification;
use App\Mail\TicketCreatedMail;
use App\Mail\TicketStatusUpdatedMail;
use App\Models\Notification;
use App\Models\Ticket;

class NotificationService
{
    public static function notifyTicketCreated(Ticket $ticket)
    {
        $notification = Notification::create([
            'user_id' => $ticket->customer_id,
            'type' => 'ticket_created',
            'notifiable_type' => Ticket::class,
            'notifiable_id' => $ticket->id,
            'recipient_email' => $ticket->customer->user->email,
            'subject' => 'Tiket Baru Dibuat #' . $ticket->id,
            'body' => 'Tiket baru: ' . $ticket->subject,
            'channel' => 'email',
            'data' => ['ticket_id' => $ticket->id],
        ]);

        dispatch(new SendEmailNotification(
            $notification,
            new TicketCreatedMail($ticket)
        ));

        return $notification;
    }

    public static function notifyTicketStatusUpdated(Ticket $ticket, $oldStatus, $newStatus)
    {
        $notification = Notification::create([
            'user_id' => $ticket->customer_id,
            'type' => 'ticket_status_updated',
            'notifiable_type' => Ticket::class,
            'notifiable_id' => $ticket->id,
            'recipient_email' => $ticket->customer->user->email,
            'subject' => 'Status Tiket Berubah',
            'body' => 'Status tiket #' . $ticket->id . ' berubah ke ' . $newStatus,
            'channel' => 'email',
            'data' => ['old_status' => $oldStatus, 'new_status' => $newStatus],
        ]);

        dispatch(new SendEmailNotification(
            $notification,
            new TicketStatusUpdatedMail($ticket, $oldStatus, $newStatus)
        ));

        return $notification;
    }
}
