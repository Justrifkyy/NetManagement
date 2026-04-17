# 📅 Phase 2 - Weekly Action Plan (April 17-21, 2026)

## 🎯 This Week's Goal: Notification System + WhatsApp

---

## **DAY 1 - APRIL 17 (TODAY) - Email Notifications Setup**

### Morning (2-3 jam)
**1. Create Notification Database & Model**
```bash
# Command to run
php artisan make:model Notification -m

# This creates:
# - app/Models/Notification.php
# - database/migrations/[date]_create_notifications_table.php
```

**Migration content:**
```php
Schema::create('notifications', function (Blueprint $table) {
    $table->id();
    $table->string('type'); // 'email', 'sms', 'whatsapp'
    $table->morphs('notifiable'); // Which model (User/Ticket)
    $table->timestamp('read_at')->nullable();
    $table->string('channel');
    $table->text('data');
    $table->timestamps();
});
```

**2. Setup Mail Configuration**
- Edit `.env`:
  ```
  MAIL_MAILER=smtp
  MAIL_HOST=smtp.gmail.com
  MAIL_PORT=587
  MAIL_USERNAME=your-email@gmail.com
  MAIL_PASSWORD=your-app-password
  ```

### Afternoon (2-3 jam)
**3. Create Mail Templates**
```bash
php artisan make:mail TicketCreatedMail
php artisan make:mail TicketStatusUpdatedMail
php artisan make:mail TicketAssignedMail
```

**4. Create Email Views**
```
resources/views/emails/
├── ticket-created.blade.php
├── ticket-status-updated.blade.php
└── ticket-assigned.blade.php
```

### Evening
**5. Testing**
```bash
php artisan tinker
# Test: Mail::to('test@example.com')->send(new TicketCreatedMail())
```

---

## **DAY 2 - APRIL 18 - Email Jobs & Queue**

### Morning
**1. Create Notification Jobs**
```bash
php artisan make:job SendEmailNotification
php artisan make:job SendSmsNotification
php artisan make:job SendWhatsAppNotification
```

**2. Create Notification Service**
```bash
php artisan make:class Services/NotificationService
```

**Content:**
```php
// app/Services/NotificationService.php
class NotificationService
{
    public function notifyTicketCreated($ticket)
    {
        dispatch(new SendEmailNotification($ticket, 'created'));
        // Later: also SMS & WhatsApp
    }
    
    public function notifyTicketStatusUpdated($ticket)
    {
        dispatch(new SendEmailNotification($ticket, 'updated'));
    }
}
```

### Afternoon
**3. Setup Queue Worker**
```bash
# Edit config/queue.php to use 'database'
php artisan queue:table
php artisan migrate

# Start queue worker
php artisan queue:work
```

**4. Integrate with Ticket Controller**
- When ticket created → dispatch notification job
- When status updated → dispatch notification job

### Evening
**5. End-to-End Testing**
- Create ticket → Check email received
- Update status → Check email received

---

## **DAY 3 - APRIL 19 - WhatsApp Research & Baileys Setup**

### Morning (1-2 jam)
**1. Install Baileys Library**
```bash
npm install baileys qrcode axios
```

**2. Create WhatsApp Service Class**
```bash
# Create app/Services/WhatsAppService.php
```

**Content structure:**
```php
class WhatsAppService
{
    public function connect()
    {
        // Initialize Baileys
    }
    
    public function sendMessage($phone, $message)
    {
        // Send WhatsApp message
    }
}
```

### Afternoon (2-3 jam)
**3. Test QR Connection**
```bash
# Create test route for WhatsApp connection
php artisan serve
# Scan QR code with your WhatsApp
```

**4. Send Test Message**
```php
WhatsAppService::sendMessage('62812345678', 'Test message');
```

---

## **DAY 4 - APRIL 20 - WhatsApp Integration**

### Morning
**1. Create WhatsApp Notification Job**
```bash
php artisan make:job SendWhatsAppNotification
```

### Afternoon
**2. Integrate with NotificationService**
```php
// In NotificationService
public function notifyTicketCreated($ticket)
{
    dispatch(new SendEmailNotification($ticket, 'created'));
    dispatch(new SendWhatsAppNotification($ticket, 'created'));
}
```

**3. Test WhatsApp Message Flow**
- Create ticket → Receive email + WhatsApp

---

## **DAY 5 - APRIL 21 - PM2 Setup & Week Wrap-up**

### Morning (1-2 jam)
**1. Install PM2**
```bash
npm install -g pm2
```

**2. Create ecosystem.config.js**
```javascript
module.exports = {
  apps: [
    {
      name: 'netmanagement-app',
      script: 'artisan',
      args: 'serve',
      env: { APP_ENV: 'production' }
    },
    {
      name: 'netmanagement-queue',
      script: 'artisan',
      args: 'queue:work',
      instances: 2
    }
  ]
};
```

**3. Start with PM2**
```bash
pm2 start ecosystem.config.js
pm2 monit        # Monitor
pm2 web          # Dashboard at localhost:9615
```

### Afternoon
**4. Testing**
- Verify auto-restart on crash
- Check logs
- Monitor memory/CPU

### Evening
**5. Documentation & Review**
- Document what was done
- Identify blockers for next week
- Prepare for Midtrans integration

---

## 📋 **Checklist (Copy & Paste)**

```
APRIL 17 (Email Setup):
☐ Create Notification model
☐ Setup Mail config
☐ Create mail templates
☐ Test email sending

APRIL 18 (Email Jobs):
☐ Create notification jobs
☐ Create NotificationService
☐ Setup queue worker
☐ Integrate with Ticket controller
☐ End-to-end testing

APRIL 19 (WhatsApp Research):
☐ Install Baileys
☐ Create WhatsAppService
☐ Test QR connection

APRIL 20 (WhatsApp Integration):
☐ Create WhatsApp job
☐ Integrate with NotificationService
☐ Test full flow

APRIL 21 (PM2):
☐ Install PM2
☐ Create ecosystem config
☐ Start PM2
☐ Monitor & test
☐ Documentation
```

---

## 🔑 **Key Commands Reference**

```bash
# Email Testing
php artisan tinker
>>> Mail::to('test@example.com')->send(new TicketCreatedMail())

# Queue Testing
php artisan queue:work
php artisan queue:failed  # Check failed jobs
php artisan queue:retry all

# WhatsApp
npm install baileys qrcode
npm start  # If using Node.js server

# PM2
pm2 start ecosystem.config.js
pm2 logs
pm2 monit
pm2 web
pm2 kill
```

---

## ⚠️ **Potential Issues & Solutions**

| Issue | Solution |
|-------|----------|
| Email not sending | Check MAIL_* env variables & SMTP credentials |
| Queue jobs not running | `php artisan queue:work` must be running in separate terminal |
| WhatsApp QR auth fails | Try disconnect/reconnect, check internet |
| PM2 restart issues | Check artisan file permissions, use `pm2 logs` |

---

## 📞 **Next Week (April 24)**

IF Midtrans approved:
- Start payment gateway integration
- Create Transaction model
- Setup Snap checkout page

IF Midtrans not approved yet:
- Continue Mikrotik setup
- OR add more failure scenarios testing
- OR optimize notification system

---

**Status: READY TO START 🚀**

Semua tools & libraries sudah tersedia. Mari kita mulai hari ini!

