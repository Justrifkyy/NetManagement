# 🚀 Email Notifications - Quick Implementation

**Copy-Paste Ready Code**  
**Duration: 1-2 hours max**

---

## ✅ CHECKLIST: Sebelum Mulai

```
☐ .env file sudah tau lokasi: NetManagement/.env
☐ Email dari stakeholder: contact: _______________
☐ Token 16 character: _______________
☐ Terminal sudah buka cd NetManagement
☐ Sudah backup .env (aman-aman)
```

---

## 🎯 5 MENIT SETUP - .ENV CONFIGURATION

**Step 1: Buka `.env` file**

```bash
Windows:
Buka folder: d:\Kyy's File\PEKERJAAN\Proyek Suami Ibu Lilis\NetManagement
Cari file: .env
Buka dengan: VS Code atau Notepad++
```

**Step 2: Find atau Create MAIL section**

**Cari line yang contain: `MAIL_MAILER`**

Jika ada, replace. Jika tidak ada, add di bawah:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.stakeholder.com
MAIL_PORT=587
MAIL_USERNAME=your-email@stakeholder.com
MAIL_PASSWORD=your_16_character_token
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@netmanagement.com
MAIL_FROM_NAME="NetManagement Support"
```

**Step 3: Isi dengan data anda**

```env
# CONTOH:
MAIL_MAILER=smtp
MAIL_HOST=smtp.company.id
MAIL_PORT=587
MAIL_USERNAME=notification@company.id
MAIL_PASSWORD=abc123def456ghi789
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@netmanagement.com
MAIL_FROM_NAME="NetManagement Support"
```

**Step 4: Save file (Ctrl+S)**

---

## 💾 10 MENIT - DATABASE & MODELS

**Terminal 1: Run commands**

```bash
# Navigate to project
cd "d:\Kyy's File\PEKERJAAN\Proyek Suami Ibu Lilis\NetManagement"

# Create Notification model dengan migration
php artisan make:model Notification -m

# Create Mail classes
php artisan make:mail TicketCreatedMail
php artisan make:mail TicketStatusUpdatedMail

# Create Job
php artisan make:job SendEmailNotification

# Create NotificationService class (manual di Step 5)
```

---

## 📝 STEP 5: Create NotificationService.php

**Create file:** `app/Services/NotificationService.php`

**Content:**

```php
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
```

---

## 📋 STEP 6: Update Migration

**File:** `database/migrations/[timestamp]_create_notifications_table.php`

**Replace entire content:**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('type');
            $table->morphs('notifiable');
            $table->string('recipient_email');
            $table->string('subject');
            $table->longText('body');
            $table->string('channel')->default('email');
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->json('data')->nullable();
            $table->timestamps();
            $table->index('user_id');
            $table->index('type');
            $table->index('sent_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
```

---

## 📧 STEP 7: Update Notification Model

**File:** `app/Models/Notification.php`

**Replace entire content:**

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id', 'type', 'notifiable_type', 'notifiable_id',
        'recipient_email', 'subject', 'body', 'channel',
        'sent_at', 'read_at', 'data',
    ];

    protected $casts = [
        'data' => 'array',
        'sent_at' => 'datetime',
        'read_at' => 'datetime',
    ];

    public function notifiable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function markAsSent()
    {
        $this->update(['sent_at' => now()]);
    }

    public function markAsRead()
    {
        $this->update(['read_at' => now()]);
    }

    public function isPending()
    {
        return is_null($this->sent_at);
    }
}
```

---

## ✉️ STEP 8: Update Mail Classes

**File:** `app/Mail/TicketCreatedMail.php`

```php
<?php

namespace App\Mail;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function envelope()
    {
        return new \Illuminate\Mail\Mailables\Envelope(
            subject: 'Tiket Baru #' . $this->ticket->id,
        );
    }

    public function content()
    {
        return new \Illuminate\Mail\Mailables\Content(
            view: 'emails.ticket-created',
        );
    }

    public function attachments()
    {
        return [];
    }
}
```

**File:** `app/Mail/TicketStatusUpdatedMail.php`

```php
<?php

namespace App\Mail;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketStatusUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $oldStatus;
    public $newStatus;

    public function __construct(Ticket $ticket, $oldStatus, $newStatus)
    {
        $this->ticket = $ticket;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
    }

    public function envelope()
    {
        return new \Illuminate\Mail\Mailables\Envelope(
            subject: 'Status Tiket: ' . ucfirst(str_replace('_', ' ', $this->newStatus)),
        );
    }

    public function content()
    {
        return new \Illuminate\Mail\Mailables\Content(
            view: 'emails.ticket-status-updated',
        );
    }

    public function attachments()
    {
        return [];
    }
}
```

---

## 🎨 STEP 9: Create Email Templates

**Create folder:** `resources/views/emails/` (if not exist)

**File:** `resources/views/emails/ticket-created.blade.php`

```blade
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
```

**File:** `resources/views/emails/ticket-status-updated.blade.php`

```blade
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
```

---

## ⚙️ STEP 10: Update SendEmailNotification Job

**File:** `app/Jobs/SendEmailNotification.php`

**Replace content:**

```php
<?php

namespace App\Jobs;

use App\Models\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $notification;
    protected $mailable;

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
            \Log::info("Email sent: {$this->notification->recipient_email}");

        } catch (\Exception $e) {
            \Log::error("Email failed: " . $e->getMessage());
            $this->release(300);
        }
    }

    public function failed(\Exception $exception)
    {
        \Log::error("Job failed: " . $exception->getMessage());
    }
}
```

---

## 🧪 STEP 11: Create Test Routes

**File:** `routes/web.php`

**Add ini di akhir (sebelum closing bracket):**

```php
// Email Testing Routes
Route::get('/test/email-config', function () {
    return [
        'status' => 'ok',
        'mailer' => config('mail.mailer'),
        'host' => config('mail.host'),
        'port' => config('mail.port'),
        'from' => config('mail.from.address'),
    ];
});

Route::get('/test/send-email', function () {
    try {
        $testEmail = auth()->user()->email ?? 'test@example.com';
        
        \Illuminate\Support\Facades\Mail::raw(
            'Test email from NetManagement',
            function ($message) use ($testEmail) {
                $message->to($testEmail)->subject('Test Email');
            }
        );

        return ['status' => 'success', 'sent_to' => $testEmail];
    } catch (\Exception $e) {
        return ['status' => 'error', 'message' => $e->getMessage()];
    }
});

Route::get('/test/notification/{ticketId}', function ($ticketId) {
    try {
        $ticket = \App\Models\Ticket::find($ticketId);
        if (!$ticket) return ['error' => 'Ticket not found'];

        \App\Services\NotificationService::notifyTicketCreated($ticket);

        return ['status' => 'success', 'sent_to' => $ticket->customer->user->email];
    } catch (\Exception $e) {
        return ['error' => $e->getMessage()];
    }
});
```

---

## 🚀 STEP 12: RUN EVERYTHING

**Terminal: Jalankan commands ini in sequence:**

```bash
# 1. Create queue jobs table
php artisan queue:table

# 2. Run migrations
php artisan migrate

# 3. Clear cache
php artisan cache:clear

# 4. Close existing queue worker (Ctrl+C jika ada)

# 5. Start queue worker di Terminal BARU
php artisan queue:work

# 6. Keep running. Jangan close terminal ini!
```

**Akan muncul:**
```
Processing jobs...
Waiting for jobs...
```

---

## ✅ STEP 13: TESTING

### **Test 1: Config check**
```
Browser: http://localhost:8000/test/email-config

Response:
{
  "status": "ok",
  "mailer": "smtp",
  "host": "smtp.company.id",
  ...
}
✓ Config OK
```

### **Test 2: Send test email**
```
Browser: http://localhost:8000/test/send-email

Response:
{
  "status": "success",
  "sent_to": "your-email@gmail.com"
}

✓ Check inbox in 5 seconds!
```

### **Test 3: Create notification**  
```
Browser: http://localhost:8000/test/notification/1

Response:
{
  "status": "success",
  "sent_to": "customer@example.com"
}

✓ Check terminal queue:work output:
   "✓ Sent notification email"
✓ Check inbox for email!
```

---

## 📊 Verify in Database

**Open database tool or artisan tinker:**

```bash
php artisan tinker

# Check notifications
>>> \App\Models\Notification::latest()->first()

# Should show:
Notification {
  id: 1,
  recipient_email: "customer@example.com",
  subject: "Tiket Baru",
  sent_at: 2026-04-17 10:30:45,  ← This confirms it was sent!
}

# Exit tinker
>>> exit
```

---

## 🎉 SUCCESS CRITERIA

```
✅ Email config correct
✅ Test email received in inbox
✅ Notification in database
✅ sent_at timestamp present
✅ Queue worker processing jobs
✅ No errors in logs

IF ALL OK ✓✓✓ → READY FOR PRODUCTION!
```

---

## 🔧 Integration into Ticket Controller

**When this all works, add to: `app/Http/Controllers/Admin/TicketController.php`**

**In store() method:**
```php
$ticket = Ticket::create($request->validated());

// Send notification
\App\Services\NotificationService::notifyTicketCreated($ticket);

return redirect()->with('success', 'Ticket created!');
```

**In updateStatus() method:**
```php
$oldStatus = $ticket->status;
$ticket->update(['status' => $newStatus]);

// Send notification
\App\Services\NotificationService::notifyTicketStatusUpdated(
    $ticket, $oldStatus, $newStatus
);

return back()->with('success', 'Status updated!');
```

---

## ⏱️ TIME BREAKDOWN

```
.env configuration: 5 min
Database & model: 10 min
Mail classes: 5 min
Email templates: 5 min
NotificationService: 5 min
SendEmailNotification job: 5 min
Migration: 5 min
Test routes: 5 min
Database setup: 5 min
TOTAL: ~50 minutes

Testing & verification: 15 min

GRAND TOTAL: ~1-1.5 hours
```

---

## 🐛 Common Issues & Fix

### Issue: SMTP Auth Failed
```
Error: "SMTP auth failed"

Fix:
☐ Check email correct
☐ Check token correct (copy paste carefully!)
☐ Check MAIL_ENCRYPTION=tls
☐ Check MAIL_PORT=587
☐ Test email/token with: https://www.smtpserver.com/
```

### Issue: Queue not processing
```
Error: "Waiting for jobs..."
Fix:
☐ Check artisan queue:work running
☐ Check database jobs table created
☐ Run: php artisan queue:table && php artisan migrate
☐ Restart: queue:work
```

### Issue: Email not received
```
Missing email
Fix:
☐ Check spam folder
☐ Check recipient email correct
☐ Run test again: /test/send-email
☐ Check sent_at in DB
☐ Check logs: tail storage/logs/laravel.log
```

---

**Ready mulai? Mari execute ASAP! 🚀**

**Tanya kalau ada blocker!**

