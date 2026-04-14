# NetManager Phase 2 - Architecture & Integration Guide

**Date**: April 15, 2026  
**Purpose**: Visual architecture and data flow documentation for Phase 2 components

---

## 🏗️ System Architecture Overview

```
┌─────────────────────────────────────────────────────────────────┐
│                     NETMANAGEMENT SYSTEM                        │
├─────────────────────────────────────────────────────────────────┤
│                                                                   │
│  ┌───────────────────────────────────────────────────────────┐  │
│  │                    CUSTOMER PORTAL                        │  │
│  │  (Dashboard, Profile, Invoice View, Payment)             │  │
│  └───────────────────┬───────────────────────────────────────┘  │
│                      │                                            │
│  ┌───────────────────┴────────────────────────────────────────┐  │
│  │              LARAVEL CORE APPLICATION                     │  │
│  │  (Fortify Auth, Jetstream, Role Management)              │  │
│  ├────────────┬──────────────┬────────────┬──────────────────┤  │
│  │  Admin     │  Marketing   │ Technician │  Super Admin     │  │
│  │  Dashboard │  Dashboard   │ Dashboard  │  Dashboard       │  │
│  └────────────┴──────────────┴────────────┴──────────────────┘  │
│                      │                                            │
└──────────────────────┼────────────────────────────────────────────┘
                       │
        ┌──────────────┼──────────────┬──────────────┐
        │              │              │              │
        ▼              ▼              ▼              ▼
   ┌────────┐   ┌─────────┐   ┌──────────┐   ┌──────────┐
   │PAYMENTS│   │  EMAIL  │   │WHATSAPP  │   │ MIKROTIK │
   │ (PHASE │   │(PHASE 2)│   │(PHASE 2) │   │(PHASE 2) │
   │ 2.1)   │   │         │   │          │   │          │
   └────────┘   └─────────┘   └──────────┘   └──────────┘
```

---

## 💰 Payment Flow (Midtrans Integration)

### Customer Payment Journey

```
1. INVOICE CREATED
   └─> Create Invoice Record in DB
   └─> Trigger Email Notification
   └─> Trigger WhatsApp Notification
   └─> Trigger Mikrotik Status Check

2. CUSTOMER INITIATES PAYMENT
   ┌─> Visit Payment Page
   ├─> Select Payment Method
   ├─> Generate Midtrans Token
   └─> Display Payment Form

3. MIDTRANS PROCESSES PAYMENT
   ├─> Customer completes payment
   ├─> Midtrans processes transaction
   └─> Midtrans sends webhook notification

4. PAYMENT CONFIRMATION
   ├─> Verify webhook signature
   ├─> Update Payment status (COMPLETED)
   ├─> Update Invoice status (PAID)
   ├─> Trigger WhatsApp confirmation
   ├─> Trigger Email receipt
   ├─> UPDATE MIKROTIK (Enable queue)
   └─> Log transaction

5. CUSTOMER NOTIFIED
   ├─> Email receipt sent
   ├─> WhatsApp confirmation sent
   └─> Invoice marked as paid
```

### Data Flow Diagram

```
Customer Dashboard
       │
       ▼ (Request payment form)
┌─────────────────────────────┐
│  Laravel Payment Controller │
│  - Get invoice details      │
│  - Calculate amount         │
│  - Generate Midtrans token  │
└─────────────────────────────┘
       │
       ▼ (Send token)
┌─────────────────────────────┐
│  Midtrans Payment Form      │
│  (Hosted by Midtrans)       │
│  - Credit Card              │
│  - Bank Transfer            │
│  - E-wallet                 │
│  - QRIS                     │
└─────────────────────────────┘
       │
       ▼ (Webhook: payment completed)
┌─────────────────────────────┐
│  Webhook Handler            │
│  - Verify signature         │
│  - Update payment status    │
│  - Update invoice status    │
│  - Trigger notifications    │
└─────────────────────────────┘
       │
       ├─> Email Service
       ├─> WhatsApp Service
       ├─> Mikrotik Service
       └─> Database
```

---

## 📧 Email Notification Flow

### Email Notification Triggers

```
DAILY SCHEDULED TASKS (via Laravel Schedule)
│
├─ 8 AM: Check payment reminders
│  ├─> Find invoices due in 7 days
│  ├─> Filter by notification preference
│  ├─> Queue PaymentReminder emails
│  ├─> Log email attempts
│  └─> Send via queue worker
│
├─ 9 AM: Check payment due alerts
│  ├─> Find invoices due today
│  ├─> Filter not yet paid
│  ├─> Queue PaymentDueAlert emails
│  └─> Send via queue worker
│
└─ 5 PM: Resend due alerts (if not paid)
   ├─> Check if still unpaid
   └─> Queue reminder again

ON-DEMAND NOTIFICATIONS
│
├─ Invoice Creation
│  └─> Queue InvoiceNotification
│
├─ Payment Received
│  └─> Queue PaymentReceivedMail + Receipt
│
├─ Service Activation
│  └─> Queue ServiceActivationMail
│
└─ Service Suspension Warning
   ├─> 3 days before (warning 1)
   ├─> 1 day before (warning 2)
   └─> On suspension (final)
```

### Queue Processing

```
┌─────────────────────────────┐
│  Laravel Queue (Database)   │
│  - Job waiting to be sent   │
│  - Retry attempt counter    │
│  - Timestamps              │
└──────────────┬──────────────┘
               │
      ┌────────▼────────┐
      │ Queue Worker    │
      │ (Running 24/7)  │
      └────────┬────────┘
               │
       ┌───────▼────────┐
       │ SMTP Connection│
       │ (Gmail/Custom) │
       └────────┬───────┘
               │
        ┌──────▼──────┐
        │ Send Email  │
        └──────┬──────┘
               │
        ┌──────▼──────────────┐
        │ Success?            │
        │ ├─ YES: Log success │
        │ └─ NO: Retry queue  │
        └─────────────────────┘
```

---

## 💬 WhatsApp Notification Flow

### WhatsApp Architecture (PM2 Integration)

```
LARAVEL APPLICATION                    ADMIN DEVICE (PM2)
┌──────────────────────┐               ┌──────────────────────┐
│ WhatsApp Service     │               │  Node.js Server      │
│ (Laravel App)        │               │  (Running on PM2)    │
│                      │               │                      │
│ sendMessage($phone)  │───API─────>│  Express Router       │
│                      │  (Axios)    │  - /api/send         │
│ Formats message      │             │  - /api/status       │
│ Validates phone      │             │  - /api/reconnect    │
│ Queues job           │             │                      │
│                      │             │ WhatsApp Web         │
│ Logs delivery status │<──Response──│ - Puppeteer Browser  │
│ Tracks success rate  │  (JSON)     │ - Session Manager    │
│                      │             │ - Message Queue      │
└──────────────────────┘             └──────────────────────┘
```

### WhatsApp Message Queue

```
┌─────────────────────────────┐
│  Laravel Queue Job          │
│  SendWhatsAppMessage        │
│  - Phone number             │
│  - Message content          │
│  - Customer ID              │
│  - Retry count              │
└──────────────────────────────┘
            │
            ▼
┌─────────────────────────────┐
│  WhatsApp Service Handler   │
│  1. Check device status     │
│  2. Format message          │
│  3. Call Node.js API        │
│  4. Wait for response       │
│  5. Log result              │
└──────────────────────────────┘
            │
            ▼
┌─────────────────────────────┐
│  PM2 Node.js Server         │
│  (On Admin Device)          │
│  1. Receive message         │
│  2. Queue in system         │
│  3. Send via WhatsApp Web   │
│  4. Track delivery (WAID)   │
│  5. Return status           │
└──────────────────────────────┘
            │
            ▼
┌─────────────────────────────┐
│  WhatsApp Delivery          │
│  ✓ Sent to WhatsApp         │
│  ✓ Delivered to customer    │
│  ✓ Read by customer         │
└─────────────────────────────┘
```

### Failure Recovery

```
Message Sending Failed
        │
        ▼
┌─────────────────────┐     ┌─────────────────────┐
│ Retry Logic         │────>│ Is retry_count < 3? │
├─────────────────────┤     └──────┬───────────┬──┘
│ Max retries: 3      │            │YES        │NO
│ Retry interval: 5m  │            │           │
│ Backoff: exponential│            ▼           ▼
└─────────────────────┘      ┌──────────┐  ┌──────────┐
                             │  Retry   │  │  Mark    │
                             │  Again   │  │  Failed  │
                             └──────────┘  │  Alert   │
                                           │  Admin   │
                                           └──────────┘
```

### WhatsApp Notification Triggers

```
INVOICE EVENTS
├─ Invoice Created → Send invoice link + due date
├─ Payment Reminder → "Tagihan jatuh tempo dalam 7 hari"
├─ Due Date Alert → "Tagihan sudah jatuh tempo hari ini"
├─ Payment Received → "Pembayaran Anda telah diterima"
└─ Suspension Warning → "Layanan Anda akan dinonaktifkan dalam X hari"

NETWORK EVENTS
├─ Service Activated → "Layanan internet Anda sudah aktif"
├─ Service Deactivated → "Layanan internet Anda telah dinonaktifkan"
├─ Suspension → "Layanan Anda telah dinonaktifkan karena pembayaran menunggak"
└─ Restoration → "Layanan Anda telah dipulihkan setelah pembayaran"

TICKET EVENTS
├─ Ticket Created → "Ticket Anda telah dibuat. No: #123"
├─ Ticket Assigned → "Teknisi akan segera menghubungi Anda"
├─ Ticket Completed → "Ticket Anda telah diselesaikan"
└─ Ticket Updated → "Ada update pada ticket Anda"
```

---

## 🌐 Mikrotik Network Management Flow

### Service Activation Workflow

```
CUSTOMER BECOMES ACTIVE
        │
        ▼
┌─────────────────────────────┐
│ Create Subscription         │
│ (After service approval)    │
└──────────────┬──────────────┘
               │
               ▼
┌─────────────────────────────┐
│ Trigger Network Activation  │
│ Event: subscription.created │
└──────────────┬──────────────┘
               │
               ▼
┌──────────────────────────────────────┐
│ Mikrotik Service                     │
│ 1. Establish connection              │
│ 2. Create queue command:             │
│    - Queue name: [CUSTOMER_ID]       │
│    - Target: [CUSTOMER_IP/SUBNET]    │
│    - Limit: [BANDWIDTH]              │
│    - Priority: [PRIORITY]            │
│ 3. Send command to Mikrotik          │
│ 4. Verify queue created              │
│ 5. Log operation                     │
└──────────────┬───────────────────────┘
               │
       ┌───────┴───────┐
       │               │
       ▼ (Success)     ▼ (Failed)
  ┌────────┐      ┌────────────┐
  │ Enable │      │ Log error  │
  │ Service│      │ Alert admin│
  │ Status │      │ Retry      │
  └────────┘      └────────────┘
       │
       ▼
  Send notifications (Email + WhatsApp)
```

### Service Deactivation Workflow

```
PAYMENT BECOMES OVERDUE
        │
        ▼
┌──────────────────────────────────┐
│ Daily Scheduled Check (8 AM)     │
│ Find overdue invoices (> 10 days)│
└──────────────┬───────────────────┘
               │
               ▼
┌──────────────────────────────────┐
│ For each overdue customer:       │
│ 1. Check if already suspended    │
│ 2. Get last payment date         │
│ 3. Calculate overdue days        │
│ 4. Send warning (if applicable)  │
└──────────────┬───────────────────┘
               │
       ┌───────┴───────┐
       │               │
       ▼ (>10 days)    ▼ (≤10 days)
  ┌─────────────┐  ┌──────────────┐
  │ Suspend now │  │ Send warning │
  └──────┬──────┘  └──────────────┘
         │
         ▼
    ┌──────────────────────────────────┐
    │ Mikrotik Service Disable         │
    │ 1. Connect to Mikrotik           │
    │ 2. Disable queue:                │
    │    - Queue name: [CUSTOMER_ID]   │
    │ 3. Alternatively: Remove queue   │
    │ 4. Verify status changed         │
    │ 5. Log operation                 │
    └──────────┬───────────────────────┘
               │
       ┌───────┴──────────┐
       │                  │
       ▼                  ▼
   Success            Failed
       │                  │
       ▼                  ▼
  Send WhatsApp    Alert Admin
  Notify customer  Log error
  Mark suspended   Retry later
```

### Real-time Status Monitoring

```
MONITORING LOOP (Every 5 minutes)
        │
        ▼
┌──────────────────────────────────┐
│ Get online customer list         │
│ from active subscriptions        │
└──────────────┬───────────────────┘
               │
       ┌───────▼────────┐
       │ For each       │
       │ customer:      │
       └────────┬───────┘
                │
                ▼
        ┌──────────────────────┐
        │ Query Mikrotik:      │
        │ - Get queue stats    │
        │ - Check bytes rx/tx  │
        │ - Check status       │
        │ - Get online time    │
        └────────┬─────────────┘
                 │
                 ▼
        ┌──────────────────────┐
        │ Update DB:           │
        │ - Update status      │
        │ - Store bandwidth    │
        │ - Log activity       │
        │ - Update timestamp   │
        └────────┬─────────────┘
                 │
        ┌────────▼──────────┐
        │ Status Changed?   │
        └────────┬──────────┘
                 │
         ┌───────┴────────┐
         │                │
         ▼ (YES)          ▼ (NO)
    Trigger alerts    Continue
    Send notification  monitoring
```

---

## 🔄 Complete Integration Flow

### Full Customer Payment Journey

```
1. INVOICE CREATED
   ├─ Create Invoice (DB)
   ├─ Email: Invoice notification
   ├─ WhatsApp: Invoice sent
   └─ Monitor: Check Mikrotik status

2. WAIT FOR PAYMENT (7+ days)
   ├─ (Day 1-6): No action
   └─ (Day 7): Scheduled tasks run

3. 7 DAYS BEFORE DUE DATE
   ├─ Email: Payment reminder
   ├─ WhatsApp: "7 hari sampai jatuh tempo"
   └─ Log: Notification sent

4. ON DUE DATE
   ├─ Email: Payment due alert
   ├─ WhatsApp: "Tagihan jatuh tempo hari ini"
   ├─ Log: Alert sent
   └─ Monitor: Check payment status

5. CUSTOMER INITIATES PAYMENT
   ├─ Visit payment page
   ├─ Select payment method
   ├─ Midtrans processes payment
   └─ Midtrans sends webhook

6. PAYMENT WEBHOOK RECEIVED
   ├─ Verify webhook signature
   ├─ Update Payment.status = COMPLETED
   ├─ Update Invoice.status = PAID
   ├─ Create Transaction record
   ├─ Log: Payment confirmed
   └─ Trigger: notification service

7. SEND CONFIRMATIONS
   ├─ Email: Payment receipt + invoice
   ├─ WhatsApp: "Pembayaran diterima"
   └─ Log: Confirmations sent

8. ENABLE SERVICE (Mikrotik)
   ├─ Verify payment confirmed
   ├─ Call Mikrotik API
   ├─ Enable customer queue
   ├─ Set bandwidth limits
   └─ Log: Service enabled

9. FINAL NOTIFICATIONS
   ├─ Email: Service activated
   ├─ WhatsApp: "Layanan aktif"
   └─ Update: Subscription status

CYCLE COMPLETE ✓
```

---

## 📊 Database Relationship Diagram

```
┌──────────────┐
│   CUSTOMER   │
├──────────────┤
│ id (PK)      │
│ name         │
│ phone        │◄─────────────┐
│ email        │              │
│ user_id (FK) │              │
└──────────────┘              │
       │                      │
       │ 1─────────┐          │
       │           │ N        │
       ▼           ▼          │
┌──────────────────────┐      │
│  SUBSCRIPTION        │      │
├──────────────────────┤      │
│ id (PK)              │      │
│ customer_id (FK)─────┘      │
│ package_id (FK)             │
│ status                       │
│ start_date                   │
│ renewal_date                 │
└──────────────────────┘
       │
       │ 1─────────┐
       │           │ N
       ▼           ▼
┌──────────────────────┐       ┌──────────────────────┐
│    INVOICE           │       │      PAYMENT         │
├──────────────────────┤       ├──────────────────────┤
│ id (PK)              │       │ id (PK)              │
│ subscription_id (FK) │◄─────>│ invoice_id (FK)      │
│ amount               │   1   │ amount               │
│ due_date             │   1   │ method               │
│ status               │       │ status               │
│ created_at           │       │ transaction_id       │
└──────────────────────┘       └──────────────────────┘
       │                               │
       │                               │ 1─────────┐
       │                               │           │ N
       │                               ▼           ▼
       │                        ┌──────────────────────┐
       │                        │   TRANSACTION        │
       │                        ├──────────────────────┤
       │                        │ id (PK)              │
       │                        │ payment_id (FK)      │
       │                        │ type                 │
       │                        │ amount               │
       │                        │ status               │
       │                        │ midtrans_ref_id      │
       │                        └──────────────────────┘
       │
       ▼
┌──────────────────────────────┐
│    EMAIL_LOG                 │
├──────────────────────────────┤
│ id (PK)                      │
│ customer_id (FK - optional)  │
│ invoice_id (FK - optional)   │
│ template_type                │
│ recipient_email              │
│ status                       │
│ created_at                   │
└──────────────────────────────┘

┌──────────────────────────────┐
│   WHATSAPP_LOG               │
├──────────────────────────────┤
│ id (PK)                      │
│ customer_id (FK)             │
│ phone_number                 │
│ message_type                 │
│ status                       │
│ waid (WhatsApp ID)           │
│ created_at                   │
└──────────────────────────────┘

┌──────────────────────────────┐
│    NETWORK_LOG               │
├──────────────────────────────┤
│ id (PK)                      │
│ subscription_id (FK)         │
│ action                       │
│ status                       │
│ details (JSON)               │
│ created_at                   │
└──────────────────────────────┘
```

---

## 📋 Configuration Checklist

Before launching Phase 2, ensure:

### Midtrans
- [ ] Sandbox test account created
- [ ] Server key obtained
- [ ] Client key obtained
- [ ] Webhook URL configured
- [ ] Merchant ID obtained

### Email Service
- [ ] SMTP server configured
- [ ] Email credentials obtained
- [ ] Email templates designed
- [ ] Test email sent successfully
- [ ] Queue setup complete

### WhatsApp Integration
- [ ] Admin device prepared
- [ ] PM2 installed on device
- [ ] Node.js server created
- [ ] Express routes configured
- [ ] WhatsApp Web login verified

### Mikrotik
- [ ] Mikrotik device accessible
- [ ] API user created
- [ ] API port open (8728)
- [ ] Test connection successful
- [ ] Queue naming convention defined

### Database
- [ ] All migrations created
- [ ] All indexes added
- [ ] Test data seeded
- [ ] Backup strategy ready

---

## 🚨 Error Recovery Procedures

| System | Issue | Recovery |
|--------|-------|----------|
| Midtrans | Payment webhook delayed | Fallback to manual verification |
| Email | SMTP connection failed | Queue holds emails, retry in 5 min |
| WhatsApp | Device offline | Queue holds messages, check device |
| Mikrotik | API unreachable | Log error, alert admin, manual process |
| Database | Queue overflow | Increase queue memory, distribute load |

---

**Document Version**: 1.0  
**Last Updated**: April 15, 2026  
**Status**: Ready for Phase 2 Implementation

