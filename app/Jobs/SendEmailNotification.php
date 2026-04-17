<?php

namespace App\Jobs;

use App\Models\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendEmailNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $notification;
    protected $mailable;

    public $tries = 3;
    public $backoff = [10, 60, 300];

    public function __construct(Notification $notification, $mailable)
    {
        $this->notification = $notification;
        $this->mailable = $mailable;
    }

    public function handle()
    {
        try {
            Mail::to($this->notification->recipient_email)
                ->send($this->mailable);

            $this->notification->markAsSent();
            Log::info("Email sent: {$this->notification->recipient_email}");

        } catch (\Exception $e) {
            Log::error("Email failed: " . $e->getMessage());
            $this->release(300);
        }
    }

    public function failed(\Exception $exception)
    {
        Log::error("Job failed: " . $exception->getMessage());
    }
}
