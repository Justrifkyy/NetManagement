# NetManager Development Roadmap

**Project**: NetManagement System (ISP Management Platform)  
**Last Updated**: April 15, 2026  
**Status**: Core system complete, Phase 2 (Payments & Notifications) in planning

---

## 📋 Project Overview

NetManager is a comprehensive ISP (Internet Service Provider) management system built with Laravel 11. It handles customer management, billing, ticket support, network configuration, and technician operations.

### Current Status ✅
- **Core Features**: Complete
- **UI/UX**: Modern black-yellow theme with particle effects
- **Performance**: Optimized with eager loading and pagination
- **Testing**: Pending (unit & integration tests)

### Technology Stack
- **Backend**: Laravel 11 with Jetstream
- **Frontend**: Blade templates with Tailwind CSS v3
- **Database**: MySQL/PostgreSQL
- **Authentication**: Laravel Fortify + 2FA
- **Extra**: tsParticles for animations, Alpine.js for interactions

---

## 🎯 Phase 1: Current Implementation (COMPLETED ✅)

### User Management System
- ✅ Role-based access control (Super Admin, Admin, Marketing, Technician, Customer)
- ✅ User authentication with 2FA
- ✅ Profile management

### Customer Management
- ✅ Customer registration and profile
- ✅ Customer dashboard
- ✅ Contact information and preferences
- ✅ Service subscription tracking

### Marketing Module
- ✅ Lead management system
- ✅ Lead status tracking (prospek, survey, instalasi, aktif, converted)
- ✅ Lead-to-customer conversion workflow
- ✅ Marketing dashboard with statistics

### Technician Module
- ✅ Job desk system (open tickets)
- ✅ Ticket assignment and claiming
- ✅ Work process management
- ✅ Survey forms and installation reports
- ✅ Device configuration tracking
- ✅ Network connectivity testing
- ✅ Technician dashboard with KPIs

### Admin Module
- ✅ Dashboard with KPIs
- ✅ Customer management
- ✅ Billing and invoicing
- ✅ Package management
- ✅ QC (Quality Control) process
- ✅ Ticket management
- ✅ Router and network asset management

### Super Admin Module
- ✅ System monitoring dashboard
- ✅ Audit logs
- ✅ User management
- ✅ Role and permission management
- ✅ System settings

### Billing System
- ✅ Invoice generation
- ✅ Subscription management
- ✅ Package pricing
- ✅ Invoice status tracking

### Network Management
- ✅ Network asset inventory
- ✅ Router configuration
- ✅ Port management
- ✅ VLAN configuration
- ✅ ODP (Optical Distribution Point) management

---

## 🚀 Phase 2: Payments & Notifications (IN PLANNING)

### 2.1 Midtrans Payment Integration
**Objective**: Enable online payment processing for customers

#### Features to Implement:
- [ ] Integration with Midtrans API
- [ ] Payment method options:
  - [ ] Credit/Debit Card
  - [ ] Bank Transfer
  - [ ] E-wallet (GoPay, OVO, Dana)
  - [ ] QRIS
- [ ] Payment status tracking
- [ ] Transaction history
- [ ] Payment confirmation and receipt
- [ ] Failed payment handling and retry logic
- [ ] Refund processing
- [ ] Payment dashboard for Admin/Super Admin

#### Technical Requirements:
```
Midtrans SDK: midtrans/midtrans-php (v2.x)
Webhook endpoint for payment notifications
Transaction status table in database
Payment log table for audit trail
```

#### Files to Create/Modify:
```
app/Models/Payment.php                          (NEW)
app/Models/Transaction.php                      (NEW)
app/Http/Controllers/Payment/PaymentController.php (NEW)
app/Http/Controllers/Payment/TransactionController.php (NEW)
app/Services/MidtransService.php               (NEW)
config/midtrans.php                            (NEW)
database/migrations/*_create_payments_table.php (NEW)
database/migrations/*_create_transactions_table.php (NEW)
resources/views/payment/*                      (NEW)
routes/payment.php                             (NEW)
```

---

### 2.2 Email Notifications System
**Objective**: Send transactional emails for payment reminders and invoices

#### Features to Implement:
- [ ] SMTP configuration with token authentication
- [ ] Email notification triggers:
  - [ ] Invoice creation email
  - [ ] Payment reminder (7 days before due date)
  - [ ] Payment due date alert (on due date)
  - [ ] Payment overdue notification
  - [ ] Payment received confirmation
  - [ ] Invoice payment receipt
  - [ ] Service activation confirmation
  - [ ] Service suspension warning
- [ ] Email template system with variables
- [ ] Email log and tracking
- [ ] Retry mechanism for failed emails
- [ ] Email preview in admin panel

#### SMTP Configuration:
```
Provider: Configurable (Gmail, Outlook, Custom SMTP)
Authentication: Token-based
Template Engine: Blade with HTML emails
Queue: Laravel Queue for async sending
```

#### Files to Create/Modify:
```
app/Mail/InvoiceNotification.php              (NEW)
app/Mail/PaymentReminder.php                  (NEW)
app/Mail/PaymentDueAlert.php                  (NEW)
app/Mail/PaymentReceivedConfirmation.php      (NEW)
app/Mail/PaymentReceiptEmail.php              (NEW)
app/Mail/ServiceActivationEmail.php           (NEW)
app/Mail/ServiceSuspensionWarning.php         (NEW)
app/Models/EmailLog.php                       (NEW)
app/Services/EmailNotificationService.php     (NEW)
config/mail.php                               (MODIFY - add SMTP config)
config/queue.php                              (MODIFY - configure queue)
database/migrations/*_create_email_logs_table.php (NEW)
database/migrations/*_create_notification_settings_table.php (NEW)
resources/views/emails/*                      (NEW - 7+ templates)
routes/email.php                              (NEW - optional)
```

---

### 2.3 WhatsApp Notifications System
**Objective**: Send WhatsApp messages via PM2-connected admin device

#### Features to Implement:
- [ ] PM2 integration with admin device
- [ ] WhatsApp message queue system
- [ ] WhatsApp notification triggers:
  - [ ] Invoice created notification
  - [ ] Payment reminder
  - [ ] Payment due date alert
  - [ ] Payment received confirmation
  - [ ] Service suspension warning
  - [ ] Ticket updates
  - [ ] Installation confirmation
- [ ] Message tracking and logs
- [ ] Bulk message capability
- [ ] WhatsApp media support (images, documents)
- [ ] Message template system

#### WhatsApp Integration Architecture:
```
Device-based approach using PM2:
1. Admin device runs WhatsApp Web via PM2
2. Node.js app (WhatsApp Web automation) connected to Laravel
3. Laravel sends messages via API to Node.js
4. PM2 manages the Node.js process
5. Message delivery confirmation tracked

Stack:
- PM2: Process manager for Node.js
- Puppeteer/Sessions: WhatsApp Web browser automation  
- Axios/Socket.io: Communication between Laravel and Node.js
- Redis: Message queue for pending messages
```

#### Files to Create/Modify:
```
app/Models/WhatsAppLog.php                    (NEW)
app/Models/WhatsAppTemplate.php               (NEW)
app/Http/Controllers/WhatsApp/WhatsAppController.php (NEW)
app/Services/WhatsAppService.php              (NEW)
app/Services/PM2Service.php                   (NEW)
app/Jobs/SendWhatsAppMessage.php              (NEW - queue job)
app/Events/WhatsAppMessageSent.php            (NEW)
config/whatsapp.php                           (NEW)
database/migrations/*_create_whatsapp_logs_table.php (NEW)
database/migrations/*_create_whatsapp_templates_table.php (NEW)
resources/views/admin/whatsapp/*              (NEW - admin panel)

Node.js App (separate):
node-whatsapp-server/
├── index.js                                  (Main server)
├── whatsapp-handler.js                       (WhatsApp logic)
├── package.json                              (Dependencies)
└── pm2.config.js                             (PM2 configuration)
```

---

### 2.4 Mikrotik API Integration
**Objective**: Control network connectivity status for clients

#### Features to Implement:
- [ ] Mikrotik RouterOS API connection
- [ ] Real-time network connectivity status checking
- [ ] Service activation/deactivation
  - [ ] Add/Remove bandwidth limiter
  - [ ] Enable/Disable customer connection
  - [ ] Configure QoS (Quality of Service)
  - [ ] Update bandwidth limits
- [ ] Network monitoring
  - [ ] Check connection status
  - [ ] Monitor bandwidth usage
  - [ ] Track online/offline status
  - [ ] Real-time connection logs
- [ ] Automated responses
  - [ ] Auto-disable on due payment
  - [ ] Auto-enable on payment received
  - [ ] Bandwidth throttling for overdue accounts
- [ ] Network dashboard for Admin/Technician

#### Mikrotik Connection Architecture:
```
Connection Method: RouterOS API
Authentication: API user credentials
Operations:
1. Connect to Mikrotik Router via API
2. Send commands to manage queues/connections
3. Receive status updates
4. Log all operations
5. Handle connection errors gracefully

Required Configuration:
- Mikrotik device IP/hostname
- API port (default: 8728)
- API username
- API password
- Queue naming convention
```

#### Files to Create/Modify:
```
app/Models/MikrotikConnection.php             (NEW)
app/Models/NetworkLog.php                     (NEW)
app/Http/Controllers/Network/MikrotikController.php (NEW)
app/Services/MikrotikService.php              (NEW)
app/Services/MikrotikQueueService.php         (NEW)
app/Jobs/UpdateNetworkStatus.php              (NEW - scheduled)
config/mikrotik.php                           (NEW)
database/migrations/*_create_mikrotik_connections_table.php (NEW)
database/migrations/*_create_network_logs_table.php (NEW)
database/seeders/MikrotikConfigSeeder.php     (NEW)
resources/views/admin/network/*               (NEW - network management)
resources/views/technician/network/*          (NEW - technician view)
routes/network.php                            (NEW)
```

---

## 📊 Phase 2 Implementation Timeline

| Phase | Component | Timeline | Priority |
|-------|-----------|----------|----------|
| 2.1 | Midtrans Payment Gateway | Week 1-2 | HIGH |
| 2.2 | Email Notifications | Week 2-3 | HIGH |
| 2.3 | WhatsApp Notifications | Week 3-4 | MEDIUM |
| 2.4 | Mikrotik API Integration | Week 4-5 | HIGH |
| Testing | Unit & Integration Tests | Week 5-6 | HIGH |
| Deployment | Production Deployment | Week 6+ | HIGH |

---

## 🔧 Phase 2 Setup Instructions

### Prerequisites
```bash
# Laravel packages
composer require midtrans/midtrans-php
composer require laravel/framework:^11.0

# Node.js (for WhatsApp PM2 integration)
npm install -g pm2
npm install puppeteer axios dotenv

# Database migrations
php artisan migrate
```

### Configuration Files Needed
```
.env additions:
- MIDTRANS_SERVER_KEY=your_key
- MIDTRANS_CLIENT_KEY=your_key
- MIDTRANS_ENVIRONMENT=sandbox|production

- MAIL_DRIVER=smtp
- MAIL_HOST=smtp.hostname
- MAIL_PORT=587
- MAIL_USERNAME=your_email
- MAIL_PASSWORD=your_token
- MAIL_FROM_ADDRESS=noreply@netmanagement.local

- MIKROTIK_HOST=192.168.1.1
- MIKROTIK_PORT=8728
- MIKROTIK_USERNAME=api_user
- MIKROTIK_PASSWORD=api_password

- WHATSAPP_DEVICE_IP=192.168.1.100
- WHATSAPP_API_PORT=3000
- WHATSAPP_API_KEY=your_secret_key
```

---

## 🧪 Testing Strategy (Phase 2)

### Unit Tests
- [ ] Payment processing logic
- [ ] Email trigger conditions
- [ ] WhatsApp message formatting
- [ ] Mikrotik command execution
- [ ] Error handling and fallbacks

### Integration Tests
- [ ] End-to-end payment flow
- [ ] Email delivery and tracking
- [ ] WhatsApp message queue
- [ ] Network status updates

### Staging Environment
- [ ] Sandbox payment gateway testing
- [ ] Email delivery verification
- [ ] WhatsApp integration testing
- [ ] Mikrotik API connections

---

## 📝 Documentation Requirements

### For Each Phase 2 Component:
1. **API Documentation** - Endpoints and parameters
2. **Configuration Guide** - Setup and customization
3. **User Guide** - Admin panel usage
4. **Troubleshooting Guide** - Common issues and solutions
5. **Security Considerations** - Key storage, API security
6. **Monitoring & Logging** - Health checks, error tracking

---

## 🔐 Security Considerations

- [ ] Encrypt sensitive payment data
- [ ] Implement CSRF protection for payment forms
- [ ] Validate all Midtrans webhooks
- [ ] Secure SMTP credentials in environment variables
- [ ] Implement rate limiting on WhatsApp API
- [ ] Secure Mikrotik API credentials
- [ ] Audit trail for all payment/network operations
- [ ] PCI DSS compliance for payment handling
- [ ] Data privacy for customer information

---

## 📈 Performance Considerations

- [ ] Queue system for email and WhatsApp (async processing)
- [ ] Database indexing on payment and transaction tables
- [ ] Caching of Mikrotik connection status
- [ ] Rate limiting on API calls
- [ ] Connection pooling for Mikrotik requests
- [ ] Scheduled tasks for recurring notifications

---

## 🚀 Deployment Checklist

- [ ] Database migrations tested
- [ ] Environment variables configured
- [ ] Third-party API keys obtained
- [ ] SSL certificates configured
- [ ] PM2 process configured and tested
- [ ] Email delivery verified
- [ ] Payment gateway tested (sandbox → production)
- [ ] WhatsApp device connected and verified
- [ ] Mikrotik connection established
- [ ] Monitoring and alerting setup
- [ ] Backup strategy implemented
- [ ] Rollback plan documented

---

## 📞 Support & Maintenance

- **Email Support**: setup via SMTP token
- **WhatsApp Support**: Via PM2-connected device
- **Monitoring**: Real-time dashboard for all services
- **Escalation**: Super admin notifications on critical errors
- **Logs**: Comprehensive logging for all integrations

---

**Next Step**: Start implementing Phase 2 components based on priority and timeline.

