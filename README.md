# NetManagement - ISP Customer Management System

<p align="center">
  <strong>A comprehensive Laravel-based system for managing Internet Service Provider (ISP) operations including customer management, billing, network administration, and field operations.</strong>
</p>

---

## 📋 Table of Contents

- [Project Overview](#project-overview)
- [Key Features](#key-features)
- [Technology Stack](#technology-stack)
- [System Requirements](#system-requirements)
- [Installation](#installation)
- [Project Structure](#project-structure)
- [Role-Based Access Control](#role-based-access-control)
- [Core Modules](#core-modules)
- [Database Models](#database-models)
- [API Routes](#api-routes)
- [Development Setup](#development-setup)
- [Usage Guide](#usage-guide)
- [Troubleshooting](#troubleshooting)

---

## 🎯 Project Overview

NetManagement is a specialized ISP (Internet Service Provider) management platform designed to streamline operations from customer acquisition to billing and technical support. The system provides role-based access control and comprehensive management tools for different user roles within an ISP organization.

**Key Objectives:**
- Centralized customer database management
- Automated billing and invoice generation
- Technician task assignment and tracking
- Marketing lead pipeline management
- Network asset and router monitoring
- Complete audit logging and security compliance

---

## ✨ Key Features

### **Admin Panel Features** 
- 📊 Operational dashboard with key metrics
- 👥 Customer management (CRUD, activation, isolation)
- 📦 Internet package management
- 🌐 Network device (router) management
- 💰 Billing and invoice tracking
- 📝 **Ticket management** (Technician data governance)
- 🎯 **Lead management** (Marketing data governance)
- 📊 Reports and analytics
- 🔗 System integration management
- 📋 Activity logging

### **SuperAdmin Panel Features**
- 🔐 User & staff management
- 👮 Role and permission configuration
- 📌 Master data management (areas, technicians, marketers)
- ⚙️ System settings and configuration
- 📊 System health monitoring
- 🔍 Complete audit log tracking
- 🛠️ Database maintenance and backup
- 🔄 Cache optimization
- 📈 Advanced reporting

### **Technician Portal**
- 📋 Ticket/task management
- 🔍 Survey form creation
- 🔧 Installation documentation
- 🚨 Troubleshooting support
- 📱 Mobile-responsive interface

### **Marketing Portal**
- 🎯 Lead management pipeline
- 📞 Contact tracking
- 📅 Follow-up scheduling
- 📊 Conversion metrics
- 🎁 Promo code management

### **Customer Portal**
- 💵 Billing and payment tracking
- 📊 Service status monitoring
- 🎫 Complaint/ticket submission
- 📝 Service plan information

---

## 🛠️ Technology Stack

| Component | Version | Purpose |
|-----------|---------|---------|
| **Framework** | Laravel 11+ | Web framework |
| **Database** | MySQL 8.0+ | Data storage |
| **Frontend** | Tailwind CSS 3 | UI styling |
| **Build Tool** | Vite | Asset compilation |
| **Authentication** | Laravel Jetstream | User auth & roles |
| **PHP** | 8.2+ | Server-side language |
| **Node.js** | 16+ | Asset bundling |

---

## 📋 System Requirements

### Minimum Requirements
- PHP 8.2 or higher
- MySQL 8.0 or higher
- Node.js 16+
- Composer 2.0+
- 512MB RAM
- 200MB disk space

### Recommended Requirements
- PHP 8.3+
- MySQL 8.0.32+
- Node.js 18 LTS
- 2GB+ RAM
- SSD storage

---

## 📦 Installation

### Step 1: Clone Repository
```bash
git clone <repository-url>
cd NetManagement
```

### Step 2: Install Dependencies
```bash
composer install
npm install
```

### Step 3: Environment Configuration
```bash
cp .env.example .env
```

Edit `.env` with database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=netmanagement
DB_USERNAME=root
DB_PASSWORD=your_password
```

### Step 4: Generate Key
```bash
php artisan key:generate
```

### Step 5: Database Setup
```bash
php artisan migrate
php artisan db:seed
```

### Step 6: Compile Assets
```bash
npm run dev    # Development
npm run build  # Production
```

### Step 7: Start Server
```bash
php artisan serve
```

Access at: `http://localhost:8000`

---

## 📁 Project Structure

```
NetManagement/
├── app/Http/Controllers/
│   ├── Admin/                      # Admin controllers
│   │   ├── AdminDashboardController
│   │   ├── CustomerController      
│   │   ├── TicketManagementController    ✨ NEW
│   │   ├── LeadManagementController      ✨ NEW
│   │   ├── PackageController
│   │   ├── RouterController
│   │   └── ... (more controllers)
│   ├── SuperAdmin/                 # SuperAdmin controllers
│   │   ├── SuperAdminDashboardController
│   │   ├── UserManagementController
│   │   ├── RoleAccessController
│   │   ├── MasterDataController
│   │   ├── SystemSettingsController
│   │   ├── AuditController
│   │   └── MaintenanceController
│   ├── Marketing/                  # Marketing portal
│   ├── Technician/                 # Technician portal
│   ├── Customer/                   # Customer portal
│   └── Public/                     # Public controllers
│
├── app/Models/
│   ├── User                        # Users with roles
│   ├── Customer                    # Customer accounts
│   ├── Ticket         ✨ Enhanced   # Detailed ticket system
│   ├── Lead           ✨ Enhanced   # Lead management
│   ├── Package                     # Service packages
│   ├── Invoice                     # Billing
│   ├── Subscription                # Active subscriptions
│   ├── NetworkAsset                # Network devices
│   ├── AuditLog       ✨ NEW       # Audit logging
│   ├── SystemSetting  ✨ NEW       # Settings
│   ├── RolePermission ✨ NEW       # Permissions
│   ├── MasterArea     ✨ NEW       # Regional areas
│   ├── MasterTechnician ✨ NEW     # Technician profiles
│   └── MasterMarketing ✨ NEW      # Marketing profiles
│
├── resources/views/
│   ├── admin/
│   │   ├── tickets/                ✨ NEW
│   │   │   ├── index.blade.php
│   │   │   ├── create.blade.php
│   │   │   ├── edit.blade.php
│   │   │   └── show.blade.php
│   │   ├── leads/                  ✨ NEW
│   │   │   ├── index.blade.php
│   │   │   ├── create.blade.php
│   │   │   ├── edit.blade.php
│   │   │   └── show.blade.php
│   │   ├── customers/
│   │   ├── packages/
│   │   └── ... (more sections)
│   ├── superadmin/
│   ├── marketing/
│   ├── technician/
│   └── client/
│
├── database/migrations/             # Schema migrations
├── routes/
│   ├── web.php                      # Web routes (with ✨ new ticket/lead routes)
│   ├── api.php                      # API routes
│   └── console.php                  # Console commands
│
├── config/                          # Configuration files
├── storage/                         # File storage
└── tests/                           # Test files
```

---

## 🔐 Role-Based Access Control

### **5-Tier Role System**

| Role | Level | Access Scope |
|------|-------|--------------|
| **Super Admin** 👑 | 5 | Full system access, user management, settings |
| **Admin** 🏢 | 4 | Operations, data management, reporting |
| **Marketing** 📞 | 3 | Leads, customer info, sales pipeline |
| **Technician** 🔧 | 2 | Tickets, surveys, installations |
| **Customer** 👤 | 1 | Own billing, profile, service status |

### **Permission Matrix**

```
┌─────────────────┬────────┬──────┬───────────┬────────────┬──────────┐
│ Feature         │ Admin  │ Super│Marketing  │Technician  │Customer  │
├─────────────────┼────────┼──────┼───────────┼────────────┼──────────┤
│ Dashboard       │ ✓      │ ✓    │ ✓         │ ✓          │ ✓        │
│ Customers       │ ✓      │ ✓    │ R         │ R (own)    │ R (own)  │
│ Tickets  ✨ NEW │ CRUD   │ CRUD │ R         │ CRUD       │ R        │
│ Leads ✨ NEW    │ CRUD   │ CRUD │ CRUD      │ R          │ -        │
│ Billing         │ R      │ R    │ -         │ -          │ ✓        │
│ Reports         │ ✓      │ ✓    │ ✓         │ -          │ -        │
│ Users           │ -      │ ✓    │ -         │ -          │ -        │
│ Settings        │ -      │ ✓    │ -         │ -          │ -        │
└─────────────────┴────────┴──────┴───────────┴────────────┴──────────┘

✓ = Full Access  |  CRUD = Create/Read/Update/Delete  |  R = Read Only  |  - = No Access
```

---

## 📚 Core Modules

### **Admin Module** (`/admin`)
Operational management and data governance.

**Key Features:**
- Dashboard with KPIs & operational metrics
- Complete customer directory (search, filter)
- **Ticket Management** - CRUD for technician tickets with filters (status, type, customer)
- **Lead Management** - CRUD for marketing leads with search & status tracking
- Package catalogue
- Network device inventory
- Billing overview
- Integrations and APIs
- Reports and analytics

**Key Views:**
- `admin/dashboard` - Metrics & overview
- `admin/customers/index` - Customer list
- `admin/tickets/index` ✨ - Ticket list with filters
- `admin/leads/index` ✨ - Lead list with search

---

### **SuperAdmin Module** (`/superadmin`)
System administration and governance.

**Key Features:**
- Staff user management (Add, Edit, Delete)
- Role and permission configuration
- Master data management:
  - Service areas/regions
  - Technician staff profiles
  - Marketing staff profiles
- System settings and configuration
- Database backup/restore
- Cache optimization
- Activity audit logs
- System health monitoring

---

### **Marketing Module** (`/marketing`)
Sales pipeline and prospect management.

**Key Features:**
- Lead creation and management
- Status pipeline (Prospect → Contacted → Qualified → Proposal Sent → Negotiation → Converted/Lost)
- Customer contact tracking
- Follow-up scheduling
- Performance dashboard
- Promo code management

---

### **Technician Module** (`/technician`)
Field operation and task execution.

**Key Features:**
- Ticket assignment and claiming
- Survey documentation (location, contact, images)
- Installation records (connection type, cable length, device info)
- Troubleshooting reports
- Network & connectivity testing
- Work completion and handover

---

### **Customer Module** (`/client`)
Customer self-service portal.

**Key Features:**
- Service status dashboard
- Billing and invoices
- Payment history
- Complaint/ticket submission
- Profile management
- Subscription information

---

## 💾 Database Models

### **Core Data Models**

#### **User** 
- Authentication & authorization
- Role assignment (super_admin, admin, marketing, technician, customer)
- Profile information

#### **Customer** 
- Account information
- Contact & address details
- Service status (active/inactive/isolated)
- Billing information
- Subscription tracking

#### **Ticket** ✨ Enhanced
**Purpose:** Manage technician tasks (survey, installation, troubleshoot, maintenance)

**Fields (50+):**
- `type` - survey, installation, troubleshoot, maintenance
- `status` - open, assigned, in_progress, resolved, closed
- Survey data: location_obstacle, location_photo_path, survey_status, survey_date, survey_notes
- Installation data: connection_type, cable_length, mounting_position, installation_date, installation_status, installation_notes
- Device data: device_type, device_brand, device_sn, device_mac, device_condition
- Network data: vlan_id, odp_port, olt_source, connection_mode, dbm_signal
- Account data: pppoe_username, pppoe_password, service_status
- Connectivity: connectivity_status, speed_test_result, latency, speedtest_photo_path
- Handover: internet_active_confirmation, handover_date, final_technician_notes, evidence_photo_path

#### **Lead** ✨ Enhanced
**Purpose:** Marketing lead and prospect tracking

**Fields (40+):**
- `name`, `email`, `phone` - Contact info
- `customer_type` - residential, business
- Addresses: address_ktp, address_installation, rt_rw, village, district, city, province, postal_code
- `package_id` - Package preference
- `status` - prospect, contacted, qualified, proposal_sent, negotiation, converted, lost
- `source` - online, offline, referral, cold_call
- `survey_date`, `installation_date` - Timeline
- `promo_code` - Promotion tracking
- Notes: notes_summary, notes_obstacle, notes_special
- Image paths: ktp_image_path, house_image_path, customer_image_path

#### **Package**
- Service plans
- Speed specifications
- Pricing
- Data limits
- Features

#### **Invoice**
- Billing records
- Payment tracking
- Due dates & amounts
- Payment status

#### **Subscription**
- Active service subscriptions
- Package assignment
- Start/end dates
- Renewal information

#### **NetworkAsset**
- Router/network device inventory
- IP configuration
- Port management
- Device specifications

#### **AuditLog** ✨ NEW
- User action tracking
- Data change history
- Timestamp & user info
- Security monitoring

#### **SystemSetting** ✨ NEW
- Application configuration
- Feature flags
- System parameters

#### **RolePermission** ✨ NEW
- Permission definitions
- Role assignments
- Access control matrix

#### **Master Data** ✨ NEW
- **MasterArea** - Geographic service regions
- **MasterTechnician** - Technician staff profiles
- **MasterMarketing** - Marketing staff profiles

---

## 🔗 API Routes

### **Admin Routes** (`/admin`)

**Tickets Management** ✨ NEW
```
GET    /admin/tickets                 - List all tickets (with filters)
GET    /admin/tickets/create          - Ticket creation form
POST   /admin/tickets                 - Create new ticket
GET    /admin/tickets/{id}            - View ticket details
GET    /admin/tickets/{id}/edit       - Edit form
PUT    /admin/tickets/{id}            - Update ticket
DELETE /admin/tickets/{id}            - Delete ticket
PATCH  /admin/tickets/{id}/status     - Update status
```

**Leads Management** ✨ NEW
```
GET    /admin/leads                   - List all leads (with search/filters)
GET    /admin/leads/create            - Lead creation form
POST   /admin/leads                   - Create new lead
GET    /admin/leads/{id}              - View lead details
GET    /admin/leads/{id}/edit         - Edit form
PUT    /admin/leads/{id}              - Update lead
DELETE /admin/leads/{id}              - Delete lead
PATCH  /admin/leads/{id}/status       - Update status
POST   /admin/leads/bulk-import       - Import leads (CSV)
```

**Customer Management**
```
GET    /admin/customers               - Customer list
GET    /admin/customers/{id}          - Customer details
PUT    /admin/customers/{id}          - Update customer
POST   /admin/customers/{id}/isolate  - Isolate connection
POST   /admin/customers/{id}/activate - Reactivate connection
```

**Package Management**
```
GET    /admin/packages                - List packages
POST   /admin/packages                - Create package
PUT    /admin/packages/{id}           - Update package
DELETE /admin/packages/{id}           - Delete package
```

**Network/Router Management**
```
GET    /admin/routers                 - List routers
POST   /admin/routers                 - Create router
PUT    /admin/routers/{id}            - Update router
DELETE /admin/routers/{id}            - Delete router
POST   /admin/routers/{id}/test       - Test connection
```

**Other Admin Functions**
```
GET    /admin/dashboard               - Dashboard
GET    /admin/billing                 - Billing overview
GET    /admin/reports                 - Reports
GET    /admin/logs                    - Activity logs
GET    /admin/profile                 - User profile
```

---

### **SuperAdmin Routes** (`/superadmin`)
```
GET    /superadmin/dashboard          - System dashboard
GET    /superadmin/users              - User management
POST   /superadmin/users              - Create user
PUT    /superadmin/users/{id}         - Update user
DELETE /superadmin/users/{id}         - Delete user
POST   /superadmin/users/{id}/reset-password

GET    /superadmin/roles              - Roles & permissions
POST   /superadmin/roles/permissions  - Update permissions

GET    /superadmin/master             - Master data
POST   /superadmin/master/areas       - Add area
POST   /superadmin/master/technicians - Add technician
POST   /superadmin/master/marketings  - Add marketer

GET    /superadmin/settings           - Settings
POST   /superadmin/settings           - Update settings
POST   /superadmin/settings/backup    - Database backup

GET    /superadmin/audits             - Audit logs
GET    /superadmin/maintenance        - Maintenance tools
```

---

### **Marketing Routes** (`/marketing`)
```
GET    /marketing/dashboard           - Marketing dashboard
GET    /marketing/leads               - Lead list
POST   /marketing/leads               - Create lead
PUT    /marketing/leads/{id}          - Update lead
```

---

### **Technician Routes** (`/technician`)
```
GET    /technician/dashboard          - Dashboard
GET    /technician/tickets            - Task list
POST   /technician/tickets/{id}/claim - Claim ticket
PUT    /technician/tickets/{id}       - Update ticket
```

---

### **Customer Routes** (`/client`)
```
GET    /client/dashboard              - Dashboard
GET    /client/billing                - Invoices
GET    /client/services               - Service status
POST   /client/tickets                - Submit complaint
```

---

## 🚀 Development Setup

### **Database Operations**
```bash
# Run migrations
php artisan migrate

# Seed sample data
php artisan db:seed

# Rollback migrations
php artisan migrate:rollback

# Refresh database (dangerous!)
php artisan migrate:refresh --seed
```

### **Asset Management**
```bash
# Development mode (watch for changes)
npm run dev

# Production build
npm run build

# Build with minification
npm run build --prod
```

### **Maintenance Commands**
```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimize for production
php artisan optimize
php artisan config:cache
php artisan route:cache

# View logs
php artisan log:level
tail -f storage/logs/laravel.log
```

---

## 📖 Usage Guide

### **Initial Setup (First Time)**

1. **Create Super Admin**
   - Register new account
   - Set role to 'super_admin' in database (dev only)
   - Login to SuperAdmin panel

2. **Configure Master Data**
   - Navigate: SuperAdmin → Master Data
   - Add service areas/regions
   - Add technician staff members
   - Add marketing team members

3. **Create Service Packages**
   - Navigate: Admin → Packages
   - Create internet packages
   - Set pricing and specifications

4. **Manage Leads & Customers** ✨ NEW
   - Marketing creates leads
   - Admin reviews/manages all leads
   - Convert qualified leads to customers
   - Assign subscriptions

5. **Manage Tickets** ✨ NEW
   - Technicians create/complete tickets
   - Admin oversees all ticket operations
   - Track survey/installation/troubleshoot tasks
   - Update ticket status and assignments

---

### **Daily Operations**

**Admin Checklist:**
- Morning: Check dashboard for metrics
- Review new leads from marketing
- Monitor active technician tickets
- Verify customer billing
- Check system logs

**Technician Checklist:**
- View assigned tickets
- Complete field work
- Document survey/installation
- Mark tasks completed
- Submit reports

**Marketing Checklist:**
- Create new prospects
- Update lead status
- Schedule follow-ups
- Track conversion metrics
- Review performance

---

## 🔧 Troubleshooting

### **Common Issues & Solutions**

**Issue: Database Connection Error**
```
Error: Connection refused
Solution:
  1. Verify MySQL is running: sudo service mysql start
  2. Check .env credentials
  3. Create database: CREATE DATABASE netmanagement;
```

**Issue: View File Not Found**
```
Error: View [admin.tickets.index] not found
Solution:
  1. Run: npm run dev
  2. Check file path exists
  3. Verify blade syntax
```

**Issue: Permission Denied**
```
Error: Permission denied on storage/logs
Solution:
  chmod -R 755 storage
  chmod -R 755 bootstrap/cache
```

**Issue: Composer Dependencies**
```
Error: Package conflicts
Solution:
  composer update
  composer dump-autoload
  php artisan serve
```

**Issue: Route Not Found**
```
Error: 404 on new routes
Solution:
  php artisan route:clear
  php artisan route:cache
```

**Issue: Database Migration Failed**
```
Error: Migration integrity constraint
Solution:
  1. php artisan migrate:rollback
  2. Fix the issue
  3. php artisan migrate
```

---

## 📊 Key Metrics & KPIs

The Admin & SuperAdmin dashboards display:

| Metric | Purpose |
|--------|---------|
| Active Customers | Total active subscriptions |
| Monthly Revenue | Billing collected |
| Open Tickets | Pending technician tasks |
| Lead Conversion Rate | Marketing effectiveness |
| System Uptime | Infrastructure health |
| User Activity | System usage tracking |
| Network Health | Device connectivity |
| Recent Transactions | Financial tracking |

---

## 🔒 Security Features

- **Role-Based Access Control** - Granular permission management
- **Audit Logging** - Complete action tracking
- **Password Hashing** - Encrypted credentials
- **CSRF Protection** - Form token validation
- **SQL Injection Prevention** - Parameterized queries
- **Data Isolation** - Role-based data visibility
- **Session Management** - Secure session handling

---

## 📱 Responsive Design

All views are fully responsive:
- ✓ Desktop (1920px+)
- ✓ Tablet (768px - 1024px)
- ✓ Mobile (320px - 767px)

Built with Tailwind CSS for modern UI/UX.

---

## 📞 Support & Documentation

- **Issue Tracker:** Report bugs in repository
- **Documentation:** See `ADMIN_SUPERADMIN_DOCUMENTATION.md`
- **Laravel Docs:** https://laravel.com/docs
- **Tailwind Docs:** https://tailwindcss.com/docs

---

## 📝 Version History

| Version | Date | Changes |
|---------|------|---------|
| v1.0.0 | Apr 2026 | Initial release with complete admin/superadmin functionality, ticket/lead management, role-based access |

---

## 📋 Future Enhancements

Planned features:
- [ ] Advanced analytics dashboard
- [ ] SMS/Email notifications
- [ ] Mobile native app
- [ ] API documentation (Swagger)
- [ ] Bulk import/export (Excel)
- [ ] Scheduled report generation
- [ ] Payment gateway integration
- [ ] Multi-tenant support

---

**Last Updated:** April 13, 2026

**Built with ❤️ for ISP Management**
