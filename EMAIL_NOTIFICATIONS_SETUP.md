# 📧 Email Notifications Setup - Step by Step

**Status: Implementation Phase**  
**Date: April 17, 2026**  
**Duration: ~2-3 hours**

---

## 📋 Apa yang akan kita setup

```
SMTP Configuration (Email sender)
        ↓
Notification Model (Database track)
        ↓
Mail Templates (Email design)
        ↓
Mail Jobs (Background sending)
        ↓
Event Listeners (Trigger otomatis)
        ↓
Testing (Verify semua works)
```

---

## 🛠️ STEP 1: Configure .env File

**Edit `.env` file di root project:**

```bash
# Lokasi: NetManagement/.env

# Cari section MAIL atau tambah di bawah:

MAIL_MAILER=smtp
MAIL_HOST=smtp.stakeholder.com
MAIL_PORT=587
MAIL_USERNAME=your-email@stakeholder.com
MAIL_PASSWORD=your_16_character_token
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@netmanagement.com
MAIL_FROM_NAME="NetManagement Support"
```

**Penjelasan:**
```
MAIL_MAILER=smtp           → Menggunakan SMTP (standard email)
MAIL_HOST=...              → Server SMTP dari stakeholder
MAIL_PORT=587              → Port standar SMTP dengan TLS
MAIL_USERNAME=...          → Email yang akan kirim
MAIL_PASSWORD=...          → Token 16 character
MAIL_ENCRYPTION=tls        → Enkripsi koneksi
MAIL_FROM_ADDRESS=...      → "Dari" address di email
MAIL_FROM_NAME=...         → "Dari" name di email
```

**Contoh nilai:**
```
Email: notification@company.id
Token: abc123def456ghi789

MAIL_MAILER=smtp
MAIL_HOST=smtp.company.id
MAIL_PORT=587
MAIL_USERNAME=notification@company.id
MAIL_PASSWORD=abc123def456ghi789
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@netmanagement.com
MAIL_FROM_NAME="NetManagement Support"
```

---

## 🔧 STEP 2: Create Notification Model & Migration

**Run command:**

```bash
cd "d:\Kyy's File\PEKERJAAN\Proyek Suami Ibu Lilis\NetManagement"

php artisan make:model Notification -m
```

**Output:**
```
Created Model: app/Models/Notification.php
Created Migration: database/migrations/[timestamp]_create_notifications_table.php
```

---

## 📝 STEP 3: Edit Migration File

**File:** `database/migrations/[timestamp]_create_notifications_table.php`

**Content:**

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
            
            // Who receive notification
            $table->unsignedBigInteger('user_id')->nullable();
            
            // What type
            $table->string('type'); // 'ticket_created', 'status_updated', 'assigned'
            
            // Notification relation
            $table->morphs('notifiable'); // Which model (Ticket, etc)
            
            // Email specific
            $table->string('recipient_email');
            $table->string('subject');
            $table->longText('body');
            
            // Status tracking
            $table->string('channel')->default('email'); // email, sms, whatsapp
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('read_at')->nullable();
            
            // Additional data
            $table->json('data')->nullable();
            
            $table->timestamps();
            
            // Indexes
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

## 📦 STEP 4: Update Notification Model

**File:** `app/Models/Notification.php`

**Replace dengan:**

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'notifiable_type',
        'notifiable_id',
        'recipient_email',
        'subject',
        'body',
        'channel',
        'sent_at',
        'read_at',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
        'sent_at' => 'datetime',
        'read_at' => 'datetime',
    ];

    // Relationship: Notifiable (polymorphic)
    public function notifiable()
    {
        return $this->morphTo();
    }

    // Relationship: User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Mark as sent
    public function markAsSent()
    {
        $this->update(['sent_at' => now()]);
    }

    // Mark as read
    public function markAsRead()
    {
        $this->update(['read_at' => now()]);
    }

    // Check if pending
    public function isPending()
    {
        return is_null($this->sent_at);
    }
}
```

---

## 📬 STEP 5: Create Mail Classes

**Create Ticket Created Mail:**

```bash
php artisan make:mail TicketCreatedMail
```

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
    public $customerName;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
        $this->customerName = $ticket->customer->user->name;
    }

    public function envelope()
    {
        return new \Illuminate\Mail\Mailables\Envelope(
            subject: 'Tiket Baru Dibuat #' . $this->ticket->id,
        );
    }

    public function content()
    {
        return new \Illuminate\Mail\Mailables\Content(
            view: 'emails.ticket-created',
            with: [
                'ticket' => $this->ticket,
                'customerName' => $this->customerName,
            ],
        );
    }

    public function attachments()
    {
        return [];
    }
}
```

**Create Ticket Status Updated Mail:**

```bash
php artisan make:mail TicketStatusUpdatedMail
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
            subject: 'Status Tiket Berubah: ' . ucfirst(str_replace('_', ' ', $this->newStatus)),
        );
    }

    public function content()
    {
        return new \Illuminate\Mail\Mailables\Content(
            view: 'emails.ticket-status-updated',
            with: [
                'ticket' => $this->ticket,
                'oldStatus' => $this->oldStatus,
                'newStatus' => $this->newStatus,
            ],
        );
    }

    public function attachments()
    {
        return [];
    }
}
```

---

## 🎨 STEP 6: Create Email Templates

**Create folder:** `resources/views/emails/`

**File:** `resources/views/emails/ticket-created.blade.php`

```blade
<x-mail::message>
# 🎟️ Tiket Baru Dibuat

Halo {{ $customerName }},

Tiket support anda telah berhasil dibuat dengan nomor **#{{ $ticket->id }}**.

## Detail Tiket:
- **Subjek:** {{ $ticket->subject }}
- **Tipe:** {{ ucfirst($ticket->type) }}
- **Status:** {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
- **Prioritas:** {{ ucfirst($ticket->priority ?? 'Normal') }}
- **Dibuat:** {{ $ticket->created_at->format('d M Y, H:i') }}

## Deskripsi:
{{ $ticket->description }}

Tim teknisi kami akan segera menangani tiket anda. Anda akan menerima notifikasi saat ada perkembangan.

<x-mail::button :url="url('/customer/tickets/' . $ticket->id)">
Lihat Detail Tiket
</x-mail::button>

Jika ada pertanyaan, hubungi support kami.

Terima kasih,<br>
{{ config('app.name') }}
</x-mail::message>
```

**File:** `resources/views/emails/ticket-status-updated.blade.php`

```blade
<x-mail::message>
# 📌 Status Tiket Berubah

Halo,

Status tiket anda **#{{ $ticket->id }}** telah diperbarui.

## Perubahan:
- **Dari:** {{ ucfirst(str_replace('_', ' ', $oldStatus)) }}
- **Menjadi:** <strong>{{ ucfirst(str_replace('_', ' ', $newStatus)) }}</strong>
- **Waktu:** {{ now()->format('d M Y, H:i') }}

## Detail Tiket:
- **Subjek:** {{ $ticket->subject }}
- **ID:** #{{ $ticket->id }}

@if($newStatus === 'assigned')
Tim teknisi telah ditugaskan untuk menangani tiket anda.
@elseif($newStatus === 'in_progress')
Tim teknisi sedang menangani tiket anda.
@elseif($newStatus === 'resolved')
Tiket anda telah diselesaikan. Silakan verifikasi solusi yang diberikan.
@elseif($newStatus === 'closed')
Tiket anda telah ditutup. Terima kasih telah menggunakan layanan kami.
@endif

<x-mail::button :url="url('/customer/tickets/' . $ticket->id)">
Lihat Detail Tiket
</x-mail::button>

Jika ada pertanyaan, hubungi support kami.

Terima kasih,<br>
{{ config('app.name') }}
</x-mail::message>
```

---

## ⚙️ STEP 7: Create Notification Service

**File:** `app/Services/NotificationService.php`

**Create file dengan content:**

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
    /**
     * Notify when ticket created
     */
    public static function notifyTicketCreated(Ticket $ticket)
    {
        // Save to database
        $notification = Notification::create([
            'user_id' => $ticket->customer_id,
            'type' => 'ticket_created',
            'notifiable_type' => Ticket::class,
            'notifiable_id' => $ticket->id,
            'recipient_email' => $ticket->customer->user->email,
            'subject' => 'Tiket Baru Dibuat #' . $ticket->id,
            'body' => 'Tiket baru telah dibuat: ' . $ticket->subject,
            'channel' => 'email',
            'data' => [
                'ticket_id' => $ticket->id,
                'ticket_subject' => $ticket->subject,
                'ticket_type' => $ticket->type,
            ],
        ]);

        // Queue the email job
        dispatch(new SendEmailNotification(
            $notification,
            new TicketCreatedMail($ticket)
        ));

        return $notification;
    }

    /**
     * Notify when ticket status updated
     */
    public static function notifyTicketStatusUpdated(Ticket $ticket, $oldStatus, $newStatus)
    {
        // Save to database
        $notification = Notification::create([
            'user_id' => $ticket->customer_id,
            'type' => 'ticket_status_updated',
            'notifiable_type' => Ticket::class,
            'notifiable_id' => $ticket->id,
            'recipient_email' => $ticket->customer->user->email,
            'subject' => 'Status Tiket Berubah: ' . ucfirst(str_replace('_', ' ', $newStatus)),
            'body' => 'Status tiket #' . $ticket->id . ' berubah menjadi ' . $newStatus,
            'channel' => 'email',
            'data' => [
                'ticket_id' => $ticket->id,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
            ],
        ]);

        // Queue the email job
        dispatch(new SendEmailNotification(
            $notification,
            new TicketStatusUpdatedMail($ticket, $oldStatus, $newStatus)
        ));

        return $notification;
    }

    /**
     * Notify when ticket assigned
     */
    public static function notifyTicketAssigned(Ticket $ticket, $technicianName)
    {
        $notification = Notification::create([
            'user_id' => $ticket->customer_id,
            'type' => 'ticket_assigned',
            'notifiable_type' => Ticket::class,
            'notifiable_id' => $ticket->id,
            'recipient_email' => $ticket->customer->user->email,
            'subject' => 'Tiket Ditugaskan ke Teknisi',
            'body' => 'Tiket anda telah ditugaskan ke ' . $technicianName,
            'channel' => 'email',
            'data' => [
                'ticket_id' => $ticket->id,
                'technician_name' => $technicianName,
            ],
        ]);

        // Queue the email job
        dispatch(new SendEmailNotification(
            $notification,
            new TicketStatusUpdatedMail($ticket, $ticket->status, 'assigned')
        ));

        return $notification;
    }
}
```

---

## 📤 STEP 8: Create SendEmailNotification Job

**Run command:**

```bash
php artisan make:job SendEmailNotification
```

**File:** `app/Jobs/SendEmailNotification.php`

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
            // Send email
            Mail::to($this->notification->recipient_email)
                ->send($this->mailable);

            // Mark as sent
            $this->notification->markAsSent();

            \Log::info("Email sent to {$this->notification->recipient_email}");

        } catch (\Exception $e) {
            \Log::error("Failed to send email: " . $e->getMessage());
            
            // Retry after 5 minutes
            $this->release(300);
        }
    }

    public function failed(\Exception $exception)
    {
        \Log::error("Email notification failed: " . $exception->getMessage());
        
        // Mark notification as failed
        $this->notification->update([
            'data' => array_merge($this->notification->data ?? [], [
                'error' => $exception->getMessage(),
                'failed_at' => now(),
            ])
        ]);
    }
}
```

---

## 🧪 STEP 9: Setup Queue Configuration

**File:** `config/queue.php`

**Verify atau ubah:**

```php
'default' => env('QUEUE_CONNECTION', 'database'),

'connections' => [
    'database' => [
        'driver' => 'database',
        'table' => 'jobs',
        'queue' => 'default',
        'retry_after' => 90,
    ],
],
```

**Run migration untuk jobs table:**

```bash
php artisan queue:table
php artisan migrate
```

---

## 🔌 STEP 10: Create Test Routes

**File:** `routes/web.php`

**Add ini di bawah:**

```php
// Testing routes - REMOVE AFTER TESTING!
Route::get('/test/email-config', function () {
    return [
        'mailer' => config('mail.mailer'),
        'host' => config('mail.host'),
        'port' => config('mail.port'),
        'from' => config('mail.from'),
    ];
});

Route::get('/test/send-email', function () {
    try {
        $testEmail = 'test@example.com'; // Change to your email
        
        \Illuminate\Support\Facades\Mail::raw(
            'This is a test email from NetManagement',
            function ($message) use ($testEmail) {
                $message->to($testEmail)
                    ->subject('Test Email - NetManagement');
            }
        );

        return [
            'status' => 'success',
            'message' => 'Test email sent to ' . $testEmail,
            'check_inbox' => 'Check your inbox in a few seconds',
        ];
    } catch (\Exception $e) {
        return [
            'status' => 'error',
            'message' => $e->getMessage(),
        ];
    }
});

Route::get('/test/notification/{ticketId}', function ($ticketId) {
    try {
        $ticket = \App\Models\Ticket::find($ticketId);
        
        if (!$ticket) {
            return ['status' => 'error', 'message' => 'Ticket not found'];
        }

        \App\Services\NotificationService::notifyTicketCreated($ticket);

        return [
            'status' => 'success',
            'message' => 'Notification queued',
            'ticket' => $ticket->id,
            'customer_email' => $ticket->customer->user->email,
        ];
    } catch (\Exception $e) {
        return [
            'status' => 'error',
            'message' => $e->getMessage(),
        ];
    }
});
```

---

## 🚀 STEP 11: Run Setup Commands

**Execute dalam order:**

```bash
# 1. Run migrations
php artisan migrate

# 2. Clear cache
php artisan cache:clear

# 3. Start queue worker (di terminal baru!)
php artisan queue:work
```

---

## ✅ STEP 12: Testing

**Open browser dan test:**

### **Test 1: Check Email Config**
```
URL: http://localhost:8000/test/email-config

Expected Response:
{
  "mailer": "smtp",
  "host": "smtp.stakeholder.com",
  "port": 587,
  "from": {
    "address": "noreply@netmanagement.com",
    "name": "NetManagement Support"
  }
}
```

### **Test 2: Send Test Email**
```
URL: http://localhost:8000/test/send-email

Expected Response:
{
  "status": "success",
  "message": "Test email sent to test@example.com",
  "check_inbox": "Check your inbox in a few seconds"
}

Then check your email inbox! ✓
```

### **Test 3: Notification on Ticket Create**
```
URL: http://localhost:8000/test/notification/1

Expected Response:
{
  "status": "success",
  "message": "Notification queued",
  "ticket": 1,
  "customer_email": "customer@example.com"
}

Check email inbox + check DB notifications table ✓
```

---

## 📊 Testing Dashboard

**Create test controller to view notifications:**

**File:** `app/Http/Controllers/TestController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Models\Notification;

class TestController extends Controller
{
    public function notifications()
    {
        $notifications = Notification::latest()->take(20)->get();
        
        return view('test.notifications', ['notifications' => $notifications]);
    }
}
```

**File:** `resources/views/test/notifications.blade.php`

```blade
<!DOCTYPE html>
<html>
<head>
    <title>Notifications Dashboard</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
        tr:hover { background-color: #f5f5f5; }
        .success { color: green; }
        .pending { color: orange; }
    </style>
</head>
<body>
    <h1>📧 Notifications Dashboard</h1>
    
    <table>
        <tr>
            <th>ID</th>
            <th>Type</th>
            <th>To Email</th>
            <th>Subject</th>
            <th>Status</th>
            <th>Sent At</th>
            <th>Created At</th>
        </tr>
        @foreach($notifications as $notif)
        <tr>
            <td>{{ $notif->id }}</td>
            <td>{{ $notif->type }}</td>
            <td>{{ $notif->recipient_email }}</td>
            <td>{{ $notif->subject }}</td>
            <td>
                @if($notif->sent_at)
                    <span class="success">✓ Sent</span>
                @else
                    <span class="pending">⏳ Pending</span>
                @endif
            </td>
            <td>{{ $notif->sent_at?->format('d M Y H:i') ?? '-' }}</td>
            <td>{{ $notif->created_at->format('d M Y H:i') }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>
```

**Add route:**

```php
// In routes/web.php
Route::get('/test/notifications-dashboard', [TestController::class, 'notifications']);
```

---

## 📋 Integration into Ticket Controller

**After testing works, integrate with real Ticket creation:**

**File:** `app/Http/Controllers/Admin/TicketController.php`

```php
// In store method:
public function store(Request $request)
{
    $ticket = Ticket::create($request->validated());
    
    // Send notification
    \App\Services\NotificationService::notifyTicketCreated($ticket);
    
    return redirect()->route('admin.tickets.show', $ticket)
        ->with('success', 'Ticket created and customer notified');
}

// In update status method:
public function updateStatus(Ticket $ticket, $newStatus)
{
    $oldStatus = $ticket->status;
    $ticket->update(['status' => $newStatus]);
    
    // Send notification
    \App\Services\NotificationService::notifyTicketStatusUpdated(
        $ticket, 
        $oldStatus, 
        $newStatus
    );
    
    return back()->with('success', 'Status updated and customer notified');
}
```

---

## 🔍 Checklist

```
✅ SETUP COMPLETE WHEN:

☐ .env configured dengan email & token
☐ Notification model created
☐ Migration created & run
☐ TicketCreatedMail created
☐ TicketStatusUpdatedMail created
☐ Email templates created
☐ NotificationService created
☐ SendEmailNotification job created
☐ Queue configured (database)
☐ Test routes working
☐ Test email sent successfully ✓
☐ Notification in DB ✓
☐ Queue worker running
☐ All tests passing ✓
```

---

## 🐛 Troubleshooting

### **Error: SMTP connection failed**
```
Solution:
☐ Check email & token correct in .env
☐ Check stakeholder SMTP server address
☐ Check port 587 correct
☐ Try from different network (firewall)
☐ Contact stakeholder support
```

### **Email not sending**
```
Solution:
☐ Check queue:work is running
☐ Check artisan queue:work output for errors
☐ Check email in DB marked as sent_at
☐ Check config('mail') values correct
☐ Try php artisan queue:work --verbose
```

### **Email sent but customer didn't receive**
```
Solution:
☐ Check customer email address correct
☐ Check spam/junk folder
☐ Check email subject not trigger spam filter
☐ Verify via dashboard: /test/notifications-dashboard
```

---

## 🎯 Next Steps

**After this works:**

1. Add SMS notifications (similar pattern)
2. Add WhatsApp notifications
3. Add email templates for other events
4. Add admin notification preferences
5. Add notification history for customers

---

**Ready mulai setup? Mari start now! 🚀**

