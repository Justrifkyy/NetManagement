# 🚀 Phase 2 - Prioritized Development Roadmap
**Status: Planning Phase**  
**Last Updated: April 17, 2026**

---

## 📋 Current Situation

### ⏳ Waiting For:
1. **Midtrans Payment Gateway** - Approval pending (3-5 hari kerja)
2. **Mikrotik Configuration** - Device available, setup pending

### ✅ Ready to Implement:
- Email/SMS Notifications
- WhatsApp API Integration (Choice: Twilio, Baileys, or Official WA Business)
- PM2 Process Management
- Mikrotik Hotspot Basic Setup

---

## 🎯 Phase 2 Work Order (Prioritized)

### **TIER 1: Core Infrastructure (This Week)**
*Can start immediately, doesn't depend on external approval*

#### 1️⃣ **Email & SMS Notifications System** ⏱️ 2-3 hari
**Kenapa duluan?** Banyak fitur lain butuh ini. Database struktur simple.

**Apa yang akan kita buat:**
```
✓ Notification model & migration
✓ Email templates (Ticket created, status updated, assigned)
✓ SMS integration (Twilio/SMS provider)
✓ Notification queue/jobs
✓ Email queue untuk performa
✓ Testing notification flow
```

**Teknik yang digunakan:**
- Laravel Mail (simple, built-in)
- Queue Jobs (background processing - jangan customer tunggu lama)
- Event-driven notifications

**Timeline:**
- Day 1: Setup notifications table & mail config
- Day 2: Create email templates & jobs
- Day 3: SMS + testing

**File yang akan dibuat:**
```
database/migrations/create_notifications_table.php
app/Models/Notification.php
app/Mail/TicketCreatedMail.php
app/Mail/TicketStatusUpdatedMail.php
app/Jobs/SendEmailNotification.php
app/Services/NotificationService.php
resources/views/emails/ticket-created.blade.php
tests/Feature/NotificationTest.php
```

---

#### 2️⃣ **WhatsApp Integration** ⏱️ 2-3 hari
**Kenapa?** Customer suka terima notifikasi via WhatsApp lebih dari email

**3 pilihan (recommended order):**

**Option A: Baileys (RECOMMENDED - Gratis, gampang)**
- Pakai WhatsApp personal account
- Tidak perlu approval
- Setup: 30 menit
```
npm install baileys qrcode
```
Cara kerja: WhatsApp web automation

**Option B: Twilio (Bayar, Professional)**
- Nomor WhatsApp bisnis
- Approval dari Twilio (~1-2 hari)
- Harga: mulai $5/bulan

**Option C: Official WA Business API (Kompleks)**
- Perlu approval Facebook/Meta (1-2 minggu)
- Harga: $5-10/bulan
- Paling enterprise

**Rekomendasi: Mulai dengan Baileys dulu (gratis, cepat), nanti bisa upgrade ke Twilio**

**Teknik yang digunakan:**
- Baileys library untuk WhatsApp automation
- Queue untuk bulk messages
- Template messages

**Timeline:**
- Day 1: Setup Baileys + QR connection
- Day 2: Create WhatsApp notification jobs
- Day 3: Integrate dengan notification system

**File yang akan dibuat:**
```
app/Services/WhatsAppService.php
app/Jobs/SendWhatsAppNotification.php
config/whatsapp.php
routes/api.php (webhook untuk receive messages)
```

---

#### 3️⃣ **PM2 Process Management & Monitoring** ⏱️ 1-2 hari
**Kenapa?** Jangan Laravel crash without warning. PM2 auto-restart + monitoring.

**Apa yang akan kita setup:**
```
✓ PM2 ecosystem.config.js
✓ Auto-restart on crash
✓ Log monitoring
✓ CPU/Memory alerts
✓ PM2 web dashboard (monitoring real-time)
```

**Cara kerja:**
```
PM2 watches Laravel → Crashes → Auto-restart
        ↓
   Logs stored in /logs/pm2/
        ↓
  Can access via PM2 web dashboard:9615
```

**Timeline:**
- Day 1: Install PM2 + create ecosystem config
- Day 2: Setup monitoring + testing crashes

**Konfigurasi yang kita buat:**
```javascript
// ecosystem.config.js
module.exports = {
  apps: [
    {
      name: 'laravel-app',
      script: 'artisan',
      args: 'serve',
      watch: ['app', 'routes', 'config'],
      env: {
        NODE_ENV: 'production'
      }
    },
    {
      name: 'laravel-queue',
      script: 'artisan',
      args: 'queue:work',
      instances: 2,
      watch: ['app/Jobs']
    }
  ]
};
```

---

### **TIER 2: Payment Gateway (Setelah Midtrans Approved)** ⏱️ 3-4 hari
*Tunggu Midtrans approval email terlebih dahulu*

#### 4️⃣ **Midtrans Payment Integration**
**Statuses:**
- ❌ Submission pending
- ⏳ Expected: 3-5 business days

**Apa yang akan kita buat:**
```
✓ Midtrans API integration
✓ Payment controller + routes
✓ Transaction model & migration
✓ Snap payment page (checkout)
✓ Webhook untuk payment confirmation
✓ Invoice generation after payment
✓ Payment history in admin panel
```

**Teknik yang digunakan:**
- Midtrans Snap (hosted payment page - lebih aman)
- Webhook validation (verifikasi payment dari Midtrans)
- Status tracking (pending → settlement → completed)

**Timeline (setelah approval):**
- Day 1: Setup Midtrans credentials + API integration
- Day 2: Create payment controller & transaction model
- Day 3: Build checkout & payment confirmation
- Day 4: Webhook + testing

**File yang akan dibuat:**
```
app/Models/Transaction.php
app/Http/Controllers/PaymentController.php
app/Services/MidtransService.php
database/migrations/create_transactions_table.php
routes/payment.php
resources/views/checkout.blade.php
tests/Feature/PaymentTest.php
```

---

### **TIER 3: Mikrotik Network Control** ⏱️ 3-5 hari
*Tunggu Mikrotik device configuration*

#### 5️⃣ **Mikrotik Hotspot Setup & API**

**Penjelasan Mikrotik untuk pemula:**

Mikrotik = Network management device (bukan WiFi biasa)

**3 functions yang akan kita gunakan:**

1. **Hotspot (WiFi dengan login)**
   - Customer login → dapat WiFi
   - Admin control bandwidth per customer
   - Ini yang friend rekomendasikan

2. **API (Remote Control)**
   - Dari Laravel program → control Mikrotik
   - Create user, suspend account, monitor bandwidth
   - Contoh: customer suspend → Mikrotik block internet

3. **Billing Integration**
   - Customer bayar Midtrans
   - Laravel create Mikrotik user
   - Customer dapat WiFi access
   - Auto-expire setelah 30 hari (contoh)

**Struktur yang akan dibuat:**

```
┌─────────────────────┐
│   Customer Bayar    │
│    (Midtrans)       │
└──────────┬──────────┘
           ↓
┌─────────────────────┐
│  Laravel Create     │
│   Hotspot User      │
└──────────┬──────────┘
           ↓
┌─────────────────────┐
│  Mikrotik API       │
│  Add new hotspot    │
│  user + bandwidth   │
└──────────┬──────────┘
           ↓
┌─────────────────────┐
│  Customer dapat     │
│  WiFi + Internet    │
└─────────────────────┘
```

**Apa yang akan kita implement:**

```
✓ Mikrotik API connector (PHP library)
✓ Create hotspot user account
✓ Set bandwidth limit per user
✓ Monitor usage in real-time
✓ Suspend/Unsuspend user
✓ Auto-expire after subscription end
✓ Admin dashboard untuk manage users
```

**Timeline:**
- Day 1: Mikrotik hotspot configuration (basic setup device)
- Day 2: Create API connector library
- Day 3: Laravel integration
- Day 4: Testing + monitoring
- Day 5: Fine-tuning + automation

**File yang akan dibuat:**
```
app/Services/MikrotikService.php
app/Http/Controllers/NetworkController.php
database/migrations/create_mikrotik_users_table.php
app/Models/MikrotikUser.php
app/Jobs/CreateMikrotikUser.php
app/Jobs/ExpireMikrotikUser.php
routes/network.php
resources/views/admin/network/users.blade.php
```

---

### **TIER 4: Testing & Optimization** ⏱️ 2 hari
*After basic features done*

#### 6️⃣ **Unit & Integration Testing**
```
✓ Notification tests
✓ Payment flow tests
✓ Mikrotik API tests
✓ Error handling tests
```

---

## 🗺️ **RECOMMENDED WORK SCHEDULE**

### **Week 1 (Apr 17-21):**
```
Mon (17):  Email notifications setup
Tue (18):  Email templates + jobs
Wed (19):  SMS + WhatsApp research
Thu (20):  WhatsApp Baileys integration
Fri (21):  PM2 setup + testing
```

### **Week 2 (Apr 24-28):**
```
Mon (24):  Check Midtrans approval
Tue (25):  Midtrans integration (if approved)
          OR continue Mikrotik setup
Wed (26-): Payment controller
Thu (27):  Testing + webhook
Fri (28):  Buffer day / optimize
```

### **Week 3 (May 1-5):**
```
Mon-Tue:   Mikrotik device configuration
Wed-Fri:   Laravel ↔ Mikrotik integration
```

---

## 📊 **Dependencies Chart**

```
┌─────────────────────────────────────────┐
│  Phase 1 (✅ COMPLETE)                  │
│  - Auth, Dashboard, Tickets             │
│  - Performance optimization             │
└────────────────┬────────────────────────┘
                 ↓
    ┌────────────┴────────────┐
    ↓                         ↓
┌─────────────┐      ┌──────────────┐
│ Tier 1      │      │ Tier 2       │
│ (Ready now) │      │ (Wait approval)
├─────────────┤      ├──────────────┤
│ • Email     │      │ • Midtrans   │
│ • SMS       │      └──────────────┘
│ • WhatsApp  │           ↑ (approval pending)
│ • PM2       │           │
└──────┬──────┘           │
       │                  │
       └─────────────┬────┘
                     ↓
            ┌──────────────────┐
            │  Tier 3          │
            │  (Mid-late)      │
            ├──────────────────┤
            │  • Mikrotik API  │
            │  • Hotspot setup │
            └──────────────────┘
```

---

## 🎓 **Technical Concepts Explained**

### **1. Queue Jobs (Background Processing)**
**Masalah:** Email kirim butuh 1-2 detik
```
Customer submit → Server try send email → Tunggu 2 detik → Response
                  (Customer frustrated)
```

**Solusi: Queue Jobs**
```
Customer submit → Server queue job → Response INSTANT (0.1s)
                                    ↓
                            Background process kirim email
```

### **2. Webhooks (Listening for External Events)**
**Untuk Midtrans:**
- Customer bayar
- Midtrans API call Laravel webhook
- Laravel update transaction status
- Send invoice email
- Create Mikrotik user

### **3. API Integration (Program ↔ Program)**
**Mikrotik API:**
```
Laravel program: "halo Mikrotik, buat user baru"
↓
Mikrotik: "oke, user created"
↓
Laravel: "terima kasih"
```

### **4. Hotspot (WiFi Management)**
**Traditional WiFi:** Everyone same password
**Hotspot:** Everyone different login
- Billing per user
- Bandwidth limit per user
- Auto-disable when expired

---

## ⚠️ **Blockers & Solutions**

| Blocker | Status | Solution |
|---------|--------|----------|
| Midtrans Approval | ⏳ Pending | Keep monitoring email, check every day |
| Mikrotik Configuration | ⏳ Blocked | Ask friend HOW to setup, get training |
| WhatsApp API | 🟢 Ready | Can use Baileys immediately (free option) |
| PM2 Setup | 🟢 Ready | Node.js already installed |
| Notifications | 🟢 Ready | Laravel built-in, start today |

---

## 🎯 **Action Items (Start Today)**

### **Today (April 17):**
1. ✅ Create Notification model + migration
2. ✅ Setup Laravel mail config
3. ✅ Create email templates

### **Tomorrow (April 18):**
1. ✅ Create notification jobs
2. ✅ Test email sending
3. ✅ Setup queue worker

### **Day After (April 19):**
1. ✅ Research WhatsApp Baileys
2. ✅ Start Baileys setup
3. ✅ PM2 configuration

---

## 💡 **Questions to Ask Teman Mikrotik**

Before you start Mikrotik configuration, ask your friend:

1. **Hotspot setup:**
   - Should we use simple authentication (username/password)?
   - How to set bandwidth limits per user?
   - How long subscription validity (30 days?)?

2. **API access:**
   - How to enable Mikrotik API?
   - What port? (Usually 8728)
   - Username/password for API?

3. **Hardware:**
   - Mikrotik model? (hAP, RB750, etc.)
   - Current configuration status?
   - Internet connection type?

4. **Billing integration:**
   - Auto-expire users after subscription end?
   - How to handle overdue customers?

---

## 📈 **Success Metrics**

| Milestone | Target | Status |
|-----------|--------|--------|
| Email notifications working | Week 1 | ⏳ Pending |
| WhatsApp notifications | Week 1 | ⏳ Pending |
| PM2 monitoring active | Week 1 | ⏳ Pending |
| Midtrans integration | Week 2 | ⏳ Waiting approval |
| Mikrotik integration | Week 3 | ⏳ Pending device config |
| **Full Phase 2 MVP** | **By May 15** | ⏳ On track |

---

## 🚀 **Next Steps**

### **Prioritas 1: Email Notifications**
**Why:** Quickest to implement, needed for everything else

**Action:** 
```bash
cd NetManagement
php artisan make:model Notification -m
php artisan make:mail TicketCreatedMail
php artisan make:job SendEmailNotification
```

### **Prioritas 2: WhatsApp (Baileys)**
**Why:** Free alternative while waiting for official APIs

### **Prioritas 3: PM2**
**Why:** Stability + monitoring

### **Prioritas 4: Payment (After Midtrans approval)**

### **Prioritas 5: Mikrotik (After friend training)**

---

**Questions? Ask di step mana yang tidak jelas! 🙋**

