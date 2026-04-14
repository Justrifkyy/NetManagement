# NetManager Phase 2 - Complete Todo List

**Project**: NetManagement System - Phase 2 (Payments & Notifications)  
**Start Date**: April 15, 2026  
**Target Completion**: 6 weeks  
**Overall Status**: 📋 PLANNING

---

## 🎯 Epic 1: Midtrans Payment Gateway Integration

### 1.1 Setup & Configuration
- [ ] Install Midtrans PHP SDK via Composer
- [ ] Create Midtrans config file (`config/midtrans.php`)
- [ ] Set up environment variables for Midtrans keys (server & client)
- [ ] Create Midtrans service class (`app/Services/MidtransService.php`)
- [ ] Test Midtrans sandbox connection
- [ ] Document Midtrans setup process

### 1.2 Database Schema
- [ ] Create `payments` table migration
  - [ ] Fields: id, invoice_id, amount, currency, status, method, transaction_id, response_data, timestamps
- [ ] Create `transactions` table migration
  - [ ] Fields: id, payment_id, type (charge/refund), amount, status, ref_id, timestamps
- [ ] Create `payment_logs` table for audit trail
  - [ ] Fields: id, payment_id, action, ip_address, user_id, details, timestamps
- [ ] Add indexes for frequently queried columns

### 1.3 Models & Relationships
- [ ] Create `Payment` model with relationships
  - Relation: belongsTo Invoice
  - Relation: hasMany Transaction
  - Methods: getStatus(), isPaid(), isPaymentPending()
- [ ] Create `Transaction` model
  - Relation: belongsTo Payment
  - Methods: isSuccessful(), getDetails()
- [ ] Create `PaymentLog` model
  - Methods: logAction(), getHistory()
- [ ] Update `Invoice` model with payment relationship

### 1.4 Controllers & Routes
- [ ] Create `PaymentController` with methods:
  - [ ] show() - Display payment form
  - [ ] store() - Process payment request
  - [ ] verify() - Verify payment with Midtrans
  - [ ] callback() - Handle Midtrans webhook
  - [ ] receipt() - Show payment receipt
  - [ ] history() - Payment history
- [ ] Create `TransactionController` for admin view
- [ ] Create routes under `routes/payment.php`
- [ ] Implement webhook endpoint protection

### 1.5 Views & Front-end
- [ ] Create payment form view with Midtrans token
- [ ] Design payment method selection interface
  - [ ] Credit/Debit Card
  - [ ] Bank Transfer
  - [ ] E-wallet options
  - [ ] QRIS
- [ ] Create payment processing page (loading state)
- [ ] Design payment success page
- [ ] Design payment failure page
- [ ] Create payment history view
- [ ] Create receipt/invoice view

### 1.6 Payment Processing Logic
- [ ] Implement payment creation workflow
- [ ] Implement Midtrans API token generation
- [ ] Implement payment status verification
- [ ] Implement webhook handler for payment notifications
- [ ] Implement failed payment retry logic
- [ ] Implement payment confirmation logic
- [ ] Test all payment methods in sandbox

### 1.7 Admin Panel Integration
- [ ] Add payment management section to admin dashboard
- [ ] Create payment list view with filters
  - [ ] Filter by status (pending, completed, failed)
  - [ ] Filter by date range
  - [ ] Filter by customer
- [ ] Add payment detail view
- [ ] Add manual refund capability
- [ ] Add payment analytics/reports
- [ ] Add payment reconciliation tool

### 1.8 Testing
- [ ] Unit tests for payment service
- [ ] Integration tests for payment flow
- [ ] Test all payment methods in sandbox
- [ ] Test webhook validation
- [ ] Test error handling
- [ ] Test refund processing

### 1.9 Documentation
- [ ] Create Midtrans integration guide
- [ ] Document API endpoints
- [ ] Create troubleshooting guide
- [ ] Document payment flow diagram

---

## 📧 Epic 2: Email Notifications System

### 2.1 Setup & Configuration
- [ ] Configure SMTP settings in `.env` (Gmail/Custom)
- [ ] Create email configuration in `config/mail.php`
- [ ] Set up queue driver (database/Redis)
- [ ] Create email service class
- [ ] Test SMTP connection
- [ ] Configure email retry logic

### 2.2 Database Schema
- [ ] Create `email_logs` table migration
  - [ ] Fields: id, recipient, subject, template, status, sent_at, error_message, timestamps
- [ ] Create `notification_settings` table
  - [ ] Fields: id, customer_id, reminder_days_before, enable_invoice_email, enable_reminder, timestamps
- [ ] Create `email_templates` table (for future customization)

### 2.3 Mailable Classes
- [ ] Create `InvoiceNotificationMail` (invoice sent email)
- [ ] Create `PaymentReminderMail` (7 days before due)
- [ ] Create `PaymentDueMail` (on due date)
- [ ] Create `PaymentReceivedMail` (payment confirmation)
- [ ] Create `PaymentReceiptMail` (receipt with details)
- [ ] Create `ServiceActivationMail` (service activated)
- [ ] Create `ServiceSuspensionMail` (suspension warning)
- [ ] Create `TicketUpdateMail` (ticket status changes)

### 2.4 Email Templates
- [ ] Design invoice notification template
- [ ] Design payment reminder template (with button link)
- [ ] Design due date alert template
- [ ] Design payment received template (with receipt)
- [ ] Design receipt template (PDF format)
- [ ] Design service activation template
- [ ] Design suspension warning template
- [ ] Design ticket update template
- [ ] Create email layout component (header, footer)

### 2.5 Notification Triggers
- [ ] Trigger email on invoice creation
- [ ] Implement scheduled email for payment reminders
  - [ ] Send 7 days before due date
  - [ ] Check at 8 AM daily
- [ ] Implement scheduled email for due date alerts
  - [ ] Send on due date at 9 AM
  - [ ] Resend at 5 PM if not paid
- [ ] Trigger email on payment received
- [ ] Trigger email on service activation
- [ ] Trigger email on suspension warning
  - [ ] 3 days before suspension
  - [ ] 1 day before suspension
- [ ] Trigger email on ticket updates

### 2.6 Notification Service
- [ ] Create `EmailNotificationService` class
- [ ] Implement queue jobs for async sending
- [ ] Implement retry mechanism for failed emails
- [ ] Implement email tracking (sent/failed/bounced)
- [ ] Implement customer notification preferences
- [ ] Implement bulk email capability

### 2.7 Queue Configuration
- [ ] Set up Laravel queue worker
- [ ] Configure queue retry attempts
- [ ] Configure queue timeout
- [ ] Implement "failed jobs" table
- [ ] Create queue monitoring mechanism

### 2.8 Admin Panel Integration
- [ ] Add email log section to admin panel
- [ ] Create email template editor (future feature)
- [ ] Add email test tool
- [ ] Add bulk email sender
- [ ] Add email statistics dashboard
- [ ] Add customer notification preference settings

### 2.9 Error Handling & Logging
- [ ] Log all email attempts (sent/failed)
- [ ] Implement retry logic for failed emails
- [ ] Create alert system for critical errors
- [ ] Implement email bouncing detection
- [ ] Create bounce reporting

### 2.10 Testing
- [ ] Unit tests for email service
- [ ] Integration tests for email triggers
- [ ] Test all email types with real SMTP
- [ ] Test queue worker functionality
- [ ] Test retry logic
- [ ] Test customer preferences

### 2.11 Documentation
- [ ] Create SMTP setup guide
- [ ] Document email templates
- [ ] Create troubleshooting guide
- [ ] Document queue configuration

---

## 💬 Epic 3: WhatsApp Notifications System

### 3.1 PM2 & Node.js Setup
- [ ] Install Node.js on admin device
- [ ] Install PM2 globally on admin device
- [ ] Create Node.js WhatsApp server project
  - [ ] Initialize project with `npm init`
  - [ ] Install dependencies (puppeteer, axios, dotenv, express)
- [ ] Create PM2 configuration file (`pm2.config.js`)
- [ ] Set up PM2 to auto-start on boot
- [ ] Test PM2 process management

### 3.2 WhatsApp API Server (Node.js)
- [ ] Create Express.js server (`node-whatsapp-server/index.js`)
- [ ] Implement WhatsApp connection handler
- [ ] Implement message send endpoint (`POST /api/send`)
- [ ] Implement message queue logic
- [ ] Implement connection status endpoint
- [ ] Implement QR code generation for WhatsApp Web login
- [ ] Implement authentication middleware for Laravel communication
- [ ] Implement error handling and recovery

### 3.3 Database Schema
- [ ] Create `whatsapp_logs` table
  - [ ] Fields: id, customer_id, phone, message, status, waid, timestamps
- [ ] Create `whatsapp_templates` table
  - [ ] Fields: id, name, content, variables, active, timestamps
- [ ] Create `whatsapp_device_settings` table
  - [ ] Fields: id, device_ip, api_port, auth_key, last_connection, status

### 3.4 Laravel WhatsApp Service
- [ ] Create `app/Services/WhatsAppService.php`
  - [ ] Method: sendMessage($phone, $message)
  - [ ] Method: formatPhoneNumber($phone)
  - [ ] Method: validatePhoneNumber($phone)
  - [ ] Method: getDeviceStatus()
  - [ ] Method: reconnectDevice()
- [ ] Create `app/Services/PM2Service.php`
  - [ ] Method: getProcessStatus()
  - [ ] Method: restartProcess()
  - [ ] Method: viewLogs()

### 3.5 Queue Jobs
- [ ] Create `SendWhatsAppMessage` job
  - [ ] Queue-based async sending
  - [ ] Retry on failure
  - [ ] Track delivery status
- [ ] Create `SendTemplateMessage` job for bulk messaging

### 3.6 Models & Controllers
- [ ] Create `WhatsAppLog` model
- [ ] Create `WhatsAppTemplate` model
- [ ] Create `WhatsAppController`
  - [ ] Methods for sending messages
  - [ ] Methods for viewing logs
  - [ ] Methods for template management
- [ ] Create `app/Events/WhatsAppMessageSent` event

### 3.7 Notification Triggers
- [ ] Trigger WhatsApp on invoice creation
  - [ ] Message: "Tagihan terbaru: Rp X. Lanjutkan pembayaran..."
- [ ] Trigger WhatsApp payment reminder (7 days before)
  - [ ] Message: "Pengingat: Tagihan Anda jatuh tempo dalam 7 hari"
- [ ] Trigger WhatsApp due date alert
  - [ ] Message: "Tagihan Anda telah jatuh tempo hari ini"
- [ ] Trigger WhatsApp payment received
  - [ ] Message: "Pembayaran Anda telah kami terima. Terima kasih!"
- [ ] Trigger WhatsApp service suspension warning
  - [ ] 3 days warning
  - [ ] 1 day warning
  - [ ] Suspension notification
- [ ] Trigger WhatsApp on ticket updates

### 3.8 Admin Panel Integration
- [ ] Create WhatsApp settings page
  - [ ] Device IP configuration
  - [ ] API key management
  - [ ] Device connection status
- [ ] Create WhatsApp log viewer
- [ ] Create WhatsApp template manager
- [ ] Add QR code scanner for device login
- [ ] Add test message sender
- [ ] Add bulk message tool
- [ ] Add WhatsApp statistics

### 3.9 Error Handling & Recovery
- [ ] Handle device disconnection gracefully
- [ ] Implement automatic reconnection attempts
- [ ] Queue messages during disconnection
- [ ] Alert admin on critical failures
- [ ] Implement message delivery tracking
- [ ] Implement bounce-back handling

### 3.10 Security
- [ ] Encrypt API keys in database
- [ ] Implement request validation
- [ ] Implement rate limiting
- [ ] Implement CORS configuration
- [ ] Validate phone numbers format
- [ ] Implement message encryption

### 3.11 Testing
- [ ] Test WhatsApp connection
- [ ] Test message sending
- [ ] Test queue functionality
- [ ] Test error recovery
- [ ] Test bulk messaging
- [ ] Test on-device WhatsApp

### 3.12 Documentation
- [ ] Create PM2 setup guide
- [ ] Create Node.js server setup
- [ ] Create WhatsApp device setup guide
- [ ] Create troubleshooting guide
- [ ] Create API documentation

---

## 🌐 Epic 4: Mikrotik API Integration

### 4.1 Setup & Configuration
- [ ] Create Mikrotik config file (`config/mikrotik.php`)
- [ ] Set up environment variables (host, port, username, password)
- [ ] Create `app/Services/MikrotikService.php`
  - [ ] Connect method
  - [ ] Disconnect method
  - [ ] Query method
  - [ ] Command method
  - [ ] Error handling
- [ ] Test connection to Mikrotik device
- [ ] Create API user on Mikrotik device

### 4.2 Database Schema
- [ ] Create `mikrotik_connections` table
  - [ ] Fields: id, host, port, username, status, last_connection, timestamps
- [ ] Create `network_logs` table
  - [ ] Fields: id, customer_id, action, status, details, timestamps

### 4.3 Mikrotik Service Class
- [ ] Implement connection pool management
- [ ] Implement queue commands
  - [ ] Add customer queue
  - [ ] Remove customer queue
  - [ ] Update queue limits
  - [ ] Disable queue
  - [ ] Enable queue
  - [ ] Check queue status
- [ ] Implement monitoring commands
  - [ ] Get interface status
  - [ ] Get connection statistics
  - [ ] Get bandwidth usage
  - [ ] Get online status
- [ ] Implement error handling and reconnection

### 4.4 Models & Controllers
- [ ] Create `MikrotikConnection` model
- [ ] Create `NetworkLog` model
- [ ] Create `MikrotikController`
  - [ ] Methods for managing queues
  - [ ] Methods for viewing status
  - [ ] Methods for monitoring

### 4.5 Network Management Features
- [ ] Service activation workflow
  - [ ] Create queue on Mikrotik
  - [ ] Log network activation
  - [ ] Send confirmation notifications
- [ ] Service deactivation workflow
  - [ ] Remove queue from Mikrotik
  - [ ] Log network deactivation
- [ ] Bandwidth limit update
  - [ ] Modify queue limits
  - [ ] Log changes
- [ ] Service suspension (automatic)
  - [ ] Disable queue on payment overdue
  - [ ] Send warning notifications
- [ ] Service restoration (automatic)
  - [ ] Enable queue after payment received
  - [ ] Send restoration notifications

### 4.6 Monitoring & Status Checking
- [ ] Create monitoring service for real-time status
- [ ] Implement scheduled status check (every 5 minutes)
- [ ] Create online/offline detection
- [ ] Create bandwidth usage tracking
- [ ] Implement connection stability monitoring
- [ ] Create performance metrics dashboard

### 4.7 Admin Panel Integration
- [ ] Create network management dashboard
  - [ ] Online/offline customer count
  - [ ] Total bandwidth usage
  - [ ] Connection statistics
- [ ] Create customer network detail view
  - [ ] Current queue status
  - [ ] Bandwidth limits
  - [ ] Online time
  - [ ] Bandwidth usage graph
- [ ] Add manual queue management tools
- [ ] Add network statistics reports
- [ ] Add customer connection logs

### 4.8 Technician Panel Integration
- [ ] Create technician network view
  - [ ] Check customer connection status
  - [ ] View bandwidth usage
  - [ ] Manual queue enable/disable (if needed)

### 4.9 Automated Operations
- [ ] Implement scheduled task (every day at 8 AM)
  - [ ] Check for overdue payments
  - [ ] Auto-suspend overdue customers
  - [ ] Send notifications
- [ ] Implement scheduled task (when payment received)
  - [ ] Re-enable customer queue
  - [ ] Send notifications
- [ ] Implement scheduled monitoring (every 5 minutes)
  - [ ] Update connection status
  - [ ] Update bandwidth usage
- [ ] Implement error alerts
  - [ ] Connection failures
  - [ ] Command execution errors

### 4.10 Error Handling & Logging
- [ ] Log all Mikrotik commands
- [ ] Log command responses
- [ ] Log errors with details
- [ ] Implement retry mechanism
- [ ] Alert admin on critical errors
- [ ] Create rollback mechanism

### 4.11 Testing
- [ ] Unit tests for Mikrotik service
- [ ] Integration tests with test Mikrotik
- [ ] Test all queue operations
- [ ] Test error scenarios
- [ ] Test monitoring functionality
- [ ] Test automated operations

### 4.12 Documentation
- [ ] Create Mikrotik setup guide
- [ ] Create API documentation
- [ ] Create queue naming convention guide
- [ ] Create monitoring guide
- [ ] Create troubleshooting guide

---

## 🧪 Epic 5: Testing & Quality Assurance

### 5.1 Unit Tests
- [ ] Payment service tests
- [ ] Email service tests
- [ ] WhatsApp service tests
- [ ] Mikrotik service tests
- [ ] Model tests
- [ ] Validation tests

### 5.2 Integration Tests
- [ ] End-to-end payment flow
- [ ] End-to-end notification flow
- [ ] End-to-end network management flow
- [ ] Multi-service interaction tests

### 5.3 Sandbox Testing
- [ ] Midtrans sandbox payment testing
  - [ ] All payment methods
  - [ ] Success scenarios
  - [ ] Failed payment scenarios
  - [ ] Webhook validation
- [ ] Email sandbox testing
- [ ] WhatsApp testing environment

### 5.4 Performance Testing
- [ ] Load test payment processing
- [ ] Load test email queue
- [ ] Load test Mikrotik API calls
- [ ] Database query performance

### 5.5 Security Testing
- [ ] Payment data encryption
- [ ] Webhook signature validation
- [ ] CSRF protection
- [ ] Rate limiting
- [ ] SQL injection prevention
- [ ] XSS prevention

### 5.6 Staging Environment
- [ ] Deploy to staging server
- [ ] Run all tests
- [ ] Test with real services (sandbox)
- [ ] Performance monitoring
- [ ] User acceptance testing

---

## 📚 Epic 6: Documentation

### 6.1 User Documentation
- [ ] Customer payment guide
- [ ] Admin payment management guide
- [ ] Email notification customization guide
- [ ] WhatsApp setup guide (admin)
- [ ] Network status monitoring guide

### 6.2 Technical Documentation
- [ ] Midtrans integration guide
- [ ] Email SMTP setup guide
- [ ] WhatsApp PM2 server setup guide
- [ ] Mikrotik API integration guide
- [ ] Database schema documentation
- [ ] API endpoints documentation

### 6.3 Troubleshooting Guides
- [ ] Payment processing issues
- [ ] Email delivery issues
- [ ] WhatsApp connection issues
- [ ] Mikrotik API issues
- [ ] Common error codes & solutions

### 6.4 Maintenance Documentation
- [ ] Backup & recovery procedures
- [ ] Monitoring & alerting setup
- [ ] Update procedures
- [ ] Rollback procedures
- [ ] Performance optimization tips

---

## 🚀 Epic 7: Deployment & Production

### 7.1 Pre-Deployment Checklist
- [ ] All tests passing
- [ ] Code review completed
- [ ] Security audit completed
- [ ] Performance baseline established
- [ ] Backup strategy finalized
- [ ] Monitoring setup complete

### 7.2 Production Migration
- [ ] Database migrations
- [ ] Environment variables configured
- [ ] SSL certificates installed
- [ ] Domain DNS configured
- [ ] Email SMTP verified
- [ ] Payment gateway keys secured
- [ ] WhatsApp device setup
- [ ] Mikrotik connection verified

### 7.3 Production Launch
- [ ] Enable payment processing
- [ ] Enable email notifications
- [ ] Enable WhatsApp notifications
- [ ] Enable network management
- [ ] Monitor error logs
- [ ] Be on-call for issues

### 7.4 Post-Deployment
- [ ] Monitor performance metrics
- [ ] Track user feedback
- [ ] Fix critical issues
- [ ] Optimize based on real usage
- [ ] Scale infrastructure if needed

---

## 📊 Summary Statistics

| Category | Count | Status |
|----------|-------|--------|
| **Midtrans (Epic 1)** | 9 sections, 50+ tasks | 📋 Planning |
| **Email (Epic 2)** | 11 sections, 60+ tasks | 📋 Planning |
| **WhatsApp (Epic 3)** | 12 sections, 70+ tasks | 📋 Planning |
| **Mikrotik (Epic 4)** | 12 sections, 65+ tasks | 📋 Planning |
| **Testing (Epic 5)** | 6 sections, 40+ tasks | 📋 Planning |
| **Documentation (Epic 6)** | 4 sections, 20+ tasks | 📋 Planning |
| **Deployment (Epic 7)** | 4 sections, 30+ tasks | 📋 Planning |
| **TOTAL** | 58 sections, **335+ tasks** | 📋 PLANNING |

---

## 📈 Development Progress Tracker

Current Phase: **1 - Core System** ✅ COMPLETE  
Current Phase: **2 - Payments & Notifications** 📋 PLANNING

```
Phase 1: ████████████████████ 100% ✅
Phase 2: ░░░░░░░░░░░░░░░░░░░░   0% 📋
```

---

## 🎯 Priority Matrix

### HIGH Priority (Start First)
1. Midtrans payment gateway (required for revenue)
2. Email notifications (basic customer communication)
3. Mikrotik API (core ISP feature)
4. Payment automation (auto-suspend/enable)

### MEDIUM Priority (Start After HIGH)
1. WhatsApp notifications (improves customer experience)
2. Advanced email templates (customization)
3. Network monitoring dashboard (admin visibility)

### LOW Priority (Start When Time Allows)
1. Advanced analytics
2. Performance optimization
3. Additional payment methods
4. Multi-language support

---

**Created**: April 15, 2026  
**Last Updated**: April 15, 2026  
**Next Review**: After Phase 1 completion

