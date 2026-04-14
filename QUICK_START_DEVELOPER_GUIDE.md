# Phase 2 Quick Start Guide - For Developers

**Document Purpose**: Quick reference for developers starting Phase 2 implementation  
**Date**: April 15, 2026  
**Audience**: Backend & Full-stack developers

---

## 📚 Documentation Files Available

| Document | Purpose | Best For |
|----------|---------|----------|
| **DEVELOPMENT_ROADMAP.md** | Complete project overview and phases | Project managers, Team leads |
| **PHASE2_TODO_LIST.md** | 335+ tasks organized by epic | Developers, Task planning |
| **ARCHITECTURE_INTEGRATION_GUIDE.md** | Data flows and component interaction | Architects, Senior devs |
| **This file** | Quick start & quick reference | New developers, Quick lookup |

---

## 🚀 Getting Started Quickly

### Step 1: Understand the Big Picture (10 min)
1. Read **DEVELOPMENT_ROADMAP.md** - Overview section
2. Review System Architecture overview in **ARCHITECTURE_INTEGRATION_GUIDE.md**
3. Understand the 4 main components:
   - **Midtrans**: Payment processing
   - **Email**: Transactional emails
   - **WhatsApp**: Customer notifications via PM2
   - **Mikrotik**: Network control

### Step 2: Choose Your Component (5 min)
Pick one component to focus on:
- Starting with **Midtrans**? → Go to "Epic 1 Checklist" below
- Starting with **Email**? → Go to "Epic 2 Checklist" below
- Starting with **WhatsApp**? → Go to "Epic 3 Checklist" below
- Starting with **Mikrotik**? → Go to "Epic 4 Checklist" below

### Step 3: Review Your Component's Flow (15 min)
Look at **ARCHITECTURE_INTEGRATION_GUIDE.md** for your component:
- Understand the data flow
- See which database tables needed
- Know which services/jobs required
- Understand triggering events

### Step 4: Start Coding (From Checklist)
Use **PHASE2_TODO_LIST.md**:
- Find your Epic (1-4)
- Follow the sections in order
- Check off completed items
- Track progress

---

## 📌 Quick Component Checklists

### Epic 1: Midtrans Payment (HIGH PRIORITY)

**Phase 1a: Setup & Database** (2-3 hours)
```
☐ Install midtrans/midtrans-php
☐ Create config/midtrans.php
☐ Create migration for payments table
☐ Create migration for transactions table
☐ Create Payment & Transaction models
☐ Add relationships to Invoice model
☐ Test database
```

**Phase 1b: Payment Service** (3-4 hours)
```
☐ Create app/Services/MidtransService.php
☐ Implement token generation
☐ Implement payment verification
☐ Implement webhook handler
☐ Test with Midtrans sandbox
```

**Phase 1c: Controllers & Views** (4-5 hours)
```
☐ Create PaymentController
☐ Create payment form view
☐ Create success/failure pages
☐ Create admin payment management
☐ Add routes under routes/payment.php
```

**Estimated Completion**: 2-3 days  
**Complexity**: Medium  
**Dependencies**: Database, Midtrans account

---

### Epic 2: Email Notifications (HIGH PRIORITY)

**Phase 2a: Setup & Database** (1-2 hours)
```
☐ Configure SMTP in .env
☐ Create migration for email_logs table
☐ Create migration for notification_settings table
☐ Set up queue driver (database or redis)
☐ Test SMTP connection
```

**Phase 2b: Mailable Classes** (3-4 hours)
```
☐ Create InvoiceNotificationMail
☐ Create PaymentReminderMail
☐ Create PaymentDueMail
☐ Create PaymentReceivedMail
☐ Create ServiceActivationMail
☐ Create ServiceSuspensionMail
☐ Design email templates (Blade)
```

**Phase 2c: Notification Triggers** (3-4 hours)
```
☐ Create EmailNotificationService
☐ Implement invoice creation trigger
☐ Implement scheduled payment reminders
☐ Implement on-payment triggers
☐ Create queue jobs
☐ Test with Laravel queue
```

**Estimated Completion**: 1-2 days  
**Complexity**: Medium  
**Dependencies**: SMTP account, Queue setup

---

### Epic 3: WhatsApp Notifications (MEDIUM PRIORITY)

**Phase 3a: Node.js Server Setup** (2-3 hours)
```
☐ Install Node.js on admin device
☐ Create node-whatsapp-server directory
☐ Initialize npm project
☐ Install dependencies (puppeteer, axios, express)
☐ Create main server file
☐ Set up PM2 configuration
☐ Test server local connection
```

**Phase 3b: Laravel WhatsApp Service** (3-4 hours)
```
☐ Create app/Services/WhatsAppService.php
☐ Create WhatsApp models
☐ Create migrations for whatsapp_logs table
☐ Implement sendMessage method
☐ Implement message formatting
☐ Implement phone validation
☐ Test with sandbox
```

**Phase 3c: Notification Triggers** (2-3 hours)
```
☐ Create queue jobs for messaging
☐ Implement invoice trigger
☐ Implement reminder triggers
☐ Implement test message endpoint
☐ Create admin WhatsApp panel
☐ Test message delivery
```

**Estimated Completion**: 2-3 days  
**Complexity**: High (requires Node.js knowledge)  
**Dependencies**: Admin device, Node.js, PM2

---

### Epic 4: Mikrotik API Integration (HIGH PRIORITY)

**Phase 4a: Setup & Service** (2-3 hours)
```
☐ Create app/Services/MikrotikService.php
☐ Create config/mikrotik.php
☐ Create Mikrotik models & migrations
☐ Implement connection management
☐ Implement queue commands
☐ Test Mikrotik API connection
```

**Phase 4b: Network Management** (3-4 hours)
```
☐ Implement service activation
☐ Implement service deactivation
☐ Implement status monitoring
☐ Implement bandwidth updates
☐ Create network logging
☐ Implement error recovery
```

**Phase 4c: Automation & Admin Panel** (3-4 hours)
```
☐ Create scheduled suspension task
☐ Create scheduled restoration task
☐ Create network monitoring dashboard
☐ Create manual queue management tools
☐ Add network status views
☐ Test all operations
```

**Estimated Completion**: 2-3 days  
**Complexity**: High (requires Mikrotik knowledge)  
**Dependencies**: Mikrotik device, API access

---

## 🛠️ Common Development Tasks

### Adding a New Email Notification Type

1. **Create Mailable Class** (`app/Mail/YourMailableName.php`)
   ```php
   <?php
   namespace App\Mail;
   
   use Illuminate\Mail\Mailable;
   
   class YourMailableName extends Mailable
   {
       public function __construct(public $data) {}
       
       public function envelope()
       {
           return new Envelope(
               subject: 'Your Subject Here',
           );
       }
       
       public function content()
       {
           return new Content(
               view: 'emails.your-email-name',
               with: ['data' => $this->data]
           );
       }
   }
   ```

2. **Create Email Template** (`resources/views/emails/your-email-name.blade.php`)
   ```blade
   <h1>{{ $data['title'] }}</h1>
   <p>Dear {{ $data['customer_name'] }},</p>
   <p>{{ $data['message'] }}</p>
   ```

3. **Create Queue Job** (`app/Jobs/SendYourEmailJob.php`)
   ```php
   <?php
   namespace App\Jobs;
   
   use Illuminate\Queue\SerializesModels;
   use App\Mail\YourMailableName;
   use Illuminate\Support\Facades\Mail;
   
   class SendYourEmailJob implements ShouldQueue
   {
       public function handle()
       {
           Mail::send(new YourMailableName($this->data));
       }
   }
   ```

4. **Dispatch Job When Needed**
   ```php
   SendYourEmailJob::dispatch($data);
   // or
   SendYourEmailJob::dispatch($data)->delay(now()->addMinutes(5));
   ```

---

### Adding a New WhatsApp Message Trigger

1. **Add to WhatsApp Service**
   ```php
   public function sendInvoiceNotification($customer, $invoice)
   {
       $phone = $this->formatPhoneNumber($customer->phone);
       $message = "Tagihan Anda: Rp " . number_format($invoice->amount) . 
                  "\nJatuh tempo: " . $invoice->due_date->format('d-m-Y');
       
       return $this->sendMessage($phone, $message);
   }
   ```

2. **Trigger on Event**
   ```php
   // In your controller or event listener
   $this->whatsappService->sendInvoiceNotification($customer, $invoice);
   ```

3. **Queue for Reliability**
   ```php
   dispatch(new SendWhatsAppMessage($phone, $message));
   ```

---

### Adding a New Midtrans Payment Method

Payment methods are handled by Midtrans - just ensure your payment form supports them:

```blade
<!-- In payment view -->
<div id="snap-container"></div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" 
        data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
    snap.pay('{{ $snapToken }}', {
        onSuccess: function(result){ 
            // Handle success
        },
        onPending: function(result){ 
            // Handle pending
        },
        onError: function(result){ 
            // Handle error
        }
    });
</script>
```

Midtrans automatically includes: Credit Card, Bank Transfer, E-wallet, QRIS

---

## 🧪 Testing Your Components

### Test Midtrans Payment (Sandbox)
```
Card: 4811111111111114
Exp: 08/25
CVV: 123
OTP: 123456
```

### Test Email Sending
```bash
# Check queue jobs
php artisan queue:work --tries=3

# Test mail sending
php artisan tinker
>>> Mail::send(new App\Mail\InvoiceNotificationMail($invoice))
```

### Test WhatsApp Connection
```bash
# Check Node.js server
curl http://192.168.1.100:3000/api/status

# Check PM2 process
pm2 list
pm2 logs
```

### Test Mikrotik Connection
```bash
# In Laravel Tinker
>>> app(\App\Services\MikrotikService::class)->testConnection()
```

---

## 🐛 Common Issues & Solutions

| Issue | Cause | Solution |
|-------|-------|----------|
| Email not sending | Queue worker not running | `php artisan queue:work` |
| Midtrans webhook fails | Wrong URL in config | Check Midtrans dashboard webhook URL |
| WhatsApp offline | PM2 process crashed | `pm2 restart app-name` |
| Mikrotik connection timeout | API port blocked | Open port 8728 in firewall |
| Queue table full | Jobs piling up | Increase queue memory or add more workers |

---

## 📊 Component Dependencies

```
Midtrans Payment
  ├─ Composer: midtrans/midtrans-php
  ├─ Database: payments, transactions tables
  ├─ Config: config/midtrans.php
  └─ External: Midtrans account

Email Notifications
  ├─ SMTP: Gmail/Custom SMTP
  ├─ Database: email_logs table
  ├─ Config: .env (MAIL_* variables)
  ├─ Queue: Database/Redis driver
  └─ Services: EmailNotificationService

WhatsApp Notifications
  ├─ Node.js: 14+ with PM2
  ├─ npm packages: puppeteer, axios, express
  ├─ Device: Admin device with WhatsApp account
  ├─ Network: Stable internet connection
  ├─ Database: whatsapp_logs table
  └─ Service: WhatsAppService (Laravel)

Mikrotik Integration
  ├─ Device: Mikrotik RouterOS device
  ├─ API: Enabled on port 8728
  ├─ User: API credentials created
  ├─ Database: network_logs table
  ├─ Config: config/mikrotik.php
  └─ Service: MikrotikService (Laravel)
```

---

## ⏱️ Time Estimates (Per Developer)

| Task | Time | Priority |
|------|------|----------|
| Midtrans full setup | 2-3 days | HIGH |
| Email system | 1-2 days | HIGH |
| WhatsApp setup | 2-3 days | MEDIUM |
| Mikrotik integration | 2-3 days | HIGH |
| Testing & QA | 3-5 days | HIGH |
| Documentation | 2-3 days | MEDIUM |
| **Total Phase 2** | **2-3 weeks** | - |

With 2 developers working parallel: **1-2 weeks**  
With 3 developers working parallel: **1 week**

---

## 📞 Quick Reference Links

**Composer Packages to Install**
```bash
composer require midtrans/midtrans-php
composer require laravel/framework:^11.0
```

**npm Packages for WhatsApp**
```bash
npm install puppeteer axios express dotenv
npm install -g pm2
```

**Useful Commands**
```bash
# Queue management
php artisan queue:work
php artisan queue:retry-failed
php artisan queue:flush

# Laravel utilities
php artisan migr ate
php artisan tinker
php artisan make:job SendEmailJob
php artisan make:mail InvoiceNotification

# PM2 (Node.js)
pm2 start app.js
pm2 stop app-name
pm2 logs app-name
pm2 restart app-name
pm2 delete app-name
```

---

## 🎯 Recommended Implementation Order

**Week 1 (Mandatory)**
1. ✅ Setup Midtrans payment gateway (4 days)
2. ✅ Implement email notifications (3 days)

**Week 2 (Core Features)**
3. ✅ Setup Mikrotik API integration (3 days)
4. ✅ Implement WhatsApp if possible (3 days)

**Week 3 (Polish & Testing)**
5. ✅ Full integration testing
6. ✅ Performance optimization
7. ✅ Documentation cleanup

---

## ✅ Pre-Implementation Checklist

Before starting Phase 2:

- [ ] All Phase 1 features complete and tested
- [ ] Performance optimizations applied (✅ Done)
- [ ] Database is optimized with indexes (✅ Done)
- [ ] Code is well-documented
- [ ] Team has necessary access:
  - [ ] Midtrans sandbox account
  - [ ] SMTP email account
  - [ ] Admin device for WhatsApp
  - [ ] Mikrotik device access
- [ ] Staging environment ready
- [ ] Backup strategy in place
- [ ] Monitoring setup ready

---

## 🚀 You're Ready!

Once you've read this guide:

1. **Pick your component** from the 4 epics
2. **Open PHASE2_TODO_LIST.md** and find your section
3. **Start with "Setup & Configuration"** tasks
4. **Reference architecture diagrams** when stuck
5. **Check off each task** as you complete it
6. **Share progress** with the team daily

**Happy coding!** 💻

---

**Document Version**: 1.0  
**Last Updated**: April 15, 2026  
**Revision Date**: After first milestone completion

