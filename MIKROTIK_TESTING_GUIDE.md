# 🌐 Mikrotik Integration & Testing Guide

**Status: Preparation Phase**  
**Date: April 17, 2026**  
**Goal: Siapkan testing environment dengan Mikrotik**

---

## 📋 DAFTAR ISI
1. [Apa itu Mikrotik?](#apa-itu-mikrotik)
2. [Apa yang Dibutuhkan](#apa-yang-dibutuhkan)
3. [Network Setup](#network-setup)
4. [Mikrotik Configuration](#mikrotik-configuration)
5. [Testing Procedure](#testing-procedure)
6. [Integration Steps](#integration-steps)
7. [Troubleshooting](#troubleshooting)

---

## 🤔 Apa itu Mikrotik?

### **Sederhana:**
Mikrotik = Device router untuk manage jaringan (internet, WiFi, akses kontrol)

### **Apa beda dengan WiFi router biasa?**

| Aspek | WiFi Router Biasa | Mikrotik |
|-------|-------------------|---------|
| Fungsi | Cuma WiFi access | WiFi + Kontroler akses |
| Billing | Semua orang dapat akses sama | Per-user tracking + limits |
| Management | Via web browser | Via web atau API |
| Customization | Limited options | Unlimited possibilities |
| API | Tidak ada | Ada (bisa control via program) |
| Harga | Murah (~Rp 200k) | Medium (~Rp 500k-2jt) |

### **3 Mode Mikrotik yang Akan Kita Pakai:**

```
1️⃣ HOTSPOT MODE
   • Customer login → Dapat WiFi
   • Bisa limit per user
   • Auto-disconnect setelah expired
   
2️⃣ API MODE
   • Program connect ke Mikrotik → Create user
   • Monitor usage
   • Enable/disable user
   
3️⃣ MONITORING MODE
   • Real-time bandwidth monitoring
   • User activity tracking
   • Alert system
```

---

## 📦 Apa yang Dibutuhkan

### **Hardware:**
```
✅ Mikrotik Device (1 pcs)
   Pilihan populer:
   • hAP ac² (~Rp 900k) - WiFi 5GHz, bagus
   • hAP ac (~Rp 700k) - WiFi standard
   • RB750Gr3 (~Rp 500k) - Wired only (router)
   • RB4011iGS+RM (~Rp 2.5jt) - Enterprise
   
   Rekomendasi: hAP ac² atau hAP ac (WiFi penting)

✅ Internet Connection
   • Dari ISP (Indihome, Biznet, dll)
   • Atau tethering dari laptop
   
✅ Network Cable (RJ45)
   • 2-3 kabel untuk testing
   
✅ Power Supply
   • Micro USB atau khusus (sesuai device)
```

### **Software/Tools:**
```
✅ Mikrotik WinBox (Windows app untuk manage)
   Download: https://mikrotik.com/download
   
✅ Putty atau SSH Client (Optional)
   
✅ Postman (Testing API calls)
   Download: https://www.postman.com/download
   
✅ Router OS (Sudah built-in di device)
```

### **Network Setup:**
```
✅ Local development environment
   • Laravel app running (localhost:8000)
   • Database connected
   
✅ Mikrotik accessible in same network
   • IP: Usually 192.168.88.1 (default)
   • Or check in Mikrotik device
```

---

## 🏗️ Network Setup Diagram

### **Option 1: Simple (Testing)**
```
┌──────────────────────────────────────────┐
│         YOUR INTERNET                    │
└────────────────┬─────────────────────────┘
                 │
        ┌────────┴────────┐
        ↓                 ↓
    ┌────────┐      ┌────────────────┐
    │ Laptop │      │   Mikrotik     │
    │ (Dev)  │◄─────┤   Device       │
    │        │      │                │
    │8000    │      │192.168.88.1    │
    └────────┘      └────────────────┘
        │                    │
        │              ┌─────┴──────┐
        │              ↓            ↓
        │          ┌──────┐     ┌──────┐
        │          │Phone1│     │Phone2│
        │          │(WiFi)│     │(WiFi)│
        │          └──────┘     └──────┘
        │
    Testing: Buka browser http://localhost:8000
             Mikrotik buat hotspot user
             Test WiFi access via hotspot
```

### **Option 2: Production-like (Better)**
```
┌──────────────────────────────────────────┐
│       ISP Internet                        │
└────────────────┬─────────────────────────┘
                 │
        ┌────────┴────────┐
        ↓                 ↓
    ┌────────┐      ┌────────────────┐
    │ Laptop │      │   Mikrotik     │
    │ (Dev)  │      │   Device       │
    │        │      │                │
    │192.168.│◄─────┤192.168.88.1    │
    │1.100   │      │(Router)        │
    └────────┘      └────────────────┘
        │                    │
        └────────┬───────────┘
                 │
        ┌────────┴─────────┐
        ↓                  ↓
    ┌──────────┐      ┌────────────┐
    │ WiFi     │      │ Simulator  │
    │Broadcast │      │ (VM)       │
    │5 devices │      │2VMs        │
    └──────────┘      └────────────┘
```

---

## 🔧 Mikrotik Configuration

### **STEP 1: Initial Setup**

**1.1 Connect to Mikrotik:**

```bash
# Download WinBox from: https://mikrotik.com/download
# Or use SSH:

ssh admin@192.168.88.1
# Default password: (empty - just press Enter)
```

**1.2 Basic Configuration:**

```
IP Address:     192.168.88.1/24
Gateway:        [Your ISP gateway] e.g. 192.168.1.1
DNS:            8.8.8.8 (Google DNS)
```

---

### **STEP 2: Enable Hotspot**

**Di Mikrotik WinBox:**

```
1. Navigate ke: IP → Hotspot
2. Klik "+ New"
3. Interface: ether1 (atau yang connected ke internet)
4. Address Pool: 10.0.0.0/24
5. Klik OK
```

**Atau via CLI:**

```bash
/ip hotspot
add name=HS1 interface=ether1 address-pool=hotspot_pool disabled=no

# Create address pool
/ip pool
add name=hotspot_pool ranges=10.0.0.2-10.0.0.254
```

---

### **STEP 3: Create Hotspot Users**

**Option A: Manual (via WinBox)**

```
1. Go to: IP → Hotspot → Users
2. Click "+ New"
3. Fill:
   - Name: customer_001
   - Password: pass123
   - Profile: default
   - Uptime Limit: 30d (30 days)
4. Click OK
```

**Option B: CLI**

```bash
/ip hotspot user
add name=customer_001 password=pass123 profile=default
add name=customer_002 password=pass123 profile=default
add name=customer_003 password=pass123 profile=default
```

---

### **STEP 4: Setup Bandwidth Limits**

**Create Profile dengan limit:**

```bash
# Create profile dengan 10 Mbps limit
/ip hotspot profile
add name=basic_plan rate-limit=10M/10M
add name=premium_plan rate-limit=25M/25M

# Assign ke user
/ip hotspot user
add name=customer_001 password=pass123 profile=basic_plan
```

**Profile options:**
```
rate-limit       = Download/Upload speed limit
session-timeout  = How long user can be online
idle-timeout     = Disconnect after X minutes idle
addresses        = Limit devices per user
```

---

### **STEP 5: Enable API (For Laravel Integration)**

**⭐ PENTING untuk connect dari Laravel:**

```bash
# Enable API service
/ip service
set api disabled=no

# By default: port 8728 (non-SSL) or 8729 (SSL)

# Create API user
/user
add name=api_user password=api_password group=full disabled=no
```

**Check if API is running:**

```bash
# Via CLI:
/ip service print
# Should show: api running, port 8728

# Via Postman:
# POST http://192.168.88.1:8728/test
# Should get response
```

---

### **STEP 6: Test Hotspot Login**

**Test dengan device WiFi:**

```
1. Connect ke WiFi hotspot yang broadcast dari Mikrotik
2. Buka browser → go to any website (e.g., google.com)
3. Should redirect to login page
4. Login dengan: 
   Username: customer_001
   Password: pass123
5. Should get internet access ✓
```

---

## 🧪 Testing Procedure

### **Phase 1: Basic Testing (Manual)**

```
✓ Mikrotik online & accessible
✓ Hotspot enabled
✓ WiFi broadcasting
✓ Manual user login works
✓ Internet access after login ✓
```

**Checklist:**

```bash
# Test 1: Ping Mikrotik
ping 192.168.88.1
# Should respond ✓

# Test 2: Check Hotspot status
ssh admin@192.168.88.1
/ip hotspot print
# Should show enabled

# Test 3: Check users
/ip hotspot user print
# Should list users ✓

# Test 4: Check API
/ip service print
# api should be running ✓
```

---

### **Phase 2: API Testing (Postman)**

**Test 1: API Connection**

```
Method: POST
URL: http://192.168.88.1:8728/api/login
Headers:
  - Content-Type: application/json

Body:
{
  "username": "api_user",
  "password": "api_password"
}

Response: Should get token ✓
```

**Test 2: Create User via API**

```
Method: POST
URL: http://192.168.88.1:8728/api/hotspot/user/add

Body:
{
  "name": "customer_001",
  "password": "pass123",
  "profile": "default"
}

Response: User created ✓
```

**Test 3: Get Users List**

```
Method: GET
URL: http://192.168.88.1:8728/api/hotspot/user/print

Response: List of all users ✓
```

---

### **Phase 3: Laravel App Testing**

**Create test controller:**

```php
// app/Http/Controllers/MikrotikTestController.php

public function testConnection()
{
    try {
        $mikrotik = new MikrotikService();
        $connected = $mikrotik->connect();
        
        return response()->json([
            'status' => 'connected',
            'message' => 'Mikrotik accessible'
        ]);
    } catch (Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
}

public function testCreateUser()
{
    try {
        $mikrotik = new MikrotikService();
        $user = $mikrotik->createUser('test_user', 'password123');
        
        return response()->json([
            'status' => 'success',
            'user' => $user
        ]);
    } catch (Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
}
```

---

## 🔌 Integration Steps

### **Step 1: Setup Mikrotik Service Class**

```php
// app/Services/MikrotikService.php

namespace App\Services;

use Exception;

class MikrotikService
{
    private $host = '192.168.88.1';
    private $port = 8728;
    private $user = 'api_user';
    private $password = 'api_password';
    private $connection;

    public function connect()
    {
        try {
            // Simple connection test
            $socket = @fsockopen($this->host, $this->port, $errno, $errstr, 5);
            
            if (!$socket) {
                throw new Exception("Cannot connect to Mikrotik: $errstr");
            }
            
            fclose($socket);
            return true;
            
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function createUser($username, $password, $profile = 'default')
    {
        // Logic to create hotspot user
        // Will implement after understanding RouterOS API better
    }

    public function disableUser($username)
    {
        // Logic to disable user
    }

    public function deleteUser($username)
    {
        // Logic to delete user
    }
}
```

---

### **Step 2: Integration Route**

```php
// routes/api.php

Route::prefix('mikrotik')->middleware('auth:sanctum')->group(function () {
    Route::post('/test-connection', 'MikrotikTestController@testConnection');
    Route::post('/create-user', 'MikrotikTestController@testCreateUser');
    Route::get('/users', 'MikrotikTestController@listUsers');
});
```

---

### **Step 3: Payment → Mikrotik Integration**

```php
// When customer pays successfully:

namespace App\Models;

class Transaction extends Model
{
    protected $fillable = ['customer_id', 'amount', 'status'];

    // After payment confirmed
    public function confirmPayment()
    {
        $this->status = 'completed';
        $this->save();

        // Create Mikrotik user
        dispatch(new CreateMikrotikUser($this->customer));
        
        // Send notification
        dispatch(new SendNotification($this->customer, 'Payment confirmed!'));
    }
}
```

---

## 🐛 Troubleshooting

### **Problem 1: Cannot connect to Mikrotik**

```
Error: "Connection refused"

Solutions:
☐ Check IP address correct: ping 192.168.88.1
☐ Check device is online: LED lights?
☐ Check network cable connected
☐ Try: ssh admin@192.168.88.1
☐ Check firewall not blocking
☐ Restart Mikrotik device
```

### **Problem 2: Hotspot not broadcasting WiFi**

```
Error: "WiFi not visible"

Solutions:
☐ Check WiFi interface enabled: /interface print
☐ Check SSID set: /interface wireless print
☐ Try: /interface wireless set wlan1 disabled=no
☐ Check antenna not blocking WiFi
☐ Restart wireless: /interface wireless disable wlan1; enable wlan1
```

### **Problem 3: Cannot login to hotspot**

```
Error: "Wrong password / User not found"

Solutions:
☐ Check user exists: /ip hotspot user print
☐ Check spelling: Username case-sensitive
☐ Check profile: /ip hotspot profile print
☐ Try recreate user: /ip hotspot user remove [id]; add new
☐ Check device IP: May need to login at 10.0.0.1
```

### **Problem 4: API not responding**

```
Error: "Cannot reach API"

Solutions:
☐ Check API enabled: /ip service print
☐ Check port 8728: telnet 192.168.88.1 8728
☐ Check firewall: /ip firewall filter print
☐ Try enable: /ip service set api disabled=no
☐ Create API user: /user add name=api_user password=xxx group=full
```

### **Problem 5: No internet after hotspot login**

```
Error: "Connected but no internet"

Solutions:
☐ Check ISP connection: ping 8.8.8.8 di Mikrotik
☐ Check firewall rules: /ip firewall filter print
☐ Check NAT rules: /ip firewall nat print
☐ Check routing: /ip route print
☐ Check bandwidth limit: May be too low
```

---

## 📝 Quick Reference Commands

### **Check Status:**
```bash
/ip address print          # IP configuration
/interface print           # All interfaces
/ip hotspot print          # Hotspot status
/ip hotspot user print     # All hotspot users
/ip service print          # Services status
```

### **Create/Modify:**
```bash
/ip hotspot user add name=test password=123 profile=default
/ip hotspot user disable numbers=0
/ip hotspot user enable numbers=0
/ip hotspot user remove numbers=0
```

### **Monitor:**
```bash
/interface monitor-traffic interface=ether1
/queue simple print         # Bandwidth queue monitor
/ip hotspot stat print      # Hotspot statistics
```

---

## 🎯 Testing Checklist

```
BASIC SETUP
☐ Mikrotik device online
☐ Connected to internet
☐ IP: 192.168.88.1 accessible

HOTSPOT CONFIGURATION
☐ Hotspot enabled
☐ WiFi broadcasting
☐ Hotspot users created
☐ Manual login works

API CONFIGURATION
☐ API service enabled (port 8728)
☐ API user created
☐ API authentication works

BANDWIDTH LIMITS
☐ Profiles created (basic, premium)
☐ Rate limits configured
☐ Time limits set

LARAVEL INTEGRATION
☐ MikrotikService created
☐ Connection test passes
☐ Can create user via code
☐ Can disable user via code
☐ Can list users via code

PAYMENT FLOW
☐ Customer pays (Midtrans)
☐ Payment confirmed (webhook)
☐ Mikrotik user created automatically
☐ WiFi access enabled immediately
☐ Notification sent

MONITORING
☐ Real-time usage viewed
☐ Bandwidth tracked
☐ Users monitored
☐ Alerts working

TESTING
☐ Manual WiFi login works
☐ Automatic user creation works
☐ Disable user works
☐ Auto-expire working
☐ Multiple users testing ✓
```

---

## 📞 Questions to Ask Teman Anda

Before starting integration:

```
1. Device Setup
   ☐ Device model? (hAP, RB750, etc.)
   ☐ Current IP? (Default 192.168.88.1?)
   ☐ Internet connected?
   ☐ WiFi working?

2. Hotspot Configuration
   ☐ Hotspot enabled?
   ☐ Can show me configuration?
   ☐ Current users setup how?
   ☐ Password setup examples?

3. API Access
   ☐ API enabled?
   ☐ Port 8728 open?
   ☐ Can access from other device?
   ☐ Can provide API credentials?

4. Network Setup
   ☐ My laptop access same network?
   ☐ Firewall blocking anything?
   ☐ WiFi 2.4GHz or 5GHz?
   ☐ SSID name?

5. Bandwidth Management
   ☐ How to set per-user limits?
   ☐ How to monitor usage?
   ☐ How to set expiration?
   ☐ How to auto-disable after time?
```

---

## 🚀 Next Steps

### **Before Integration:**
1. Get Mikrotik device ready
2. Run through all testing checklist
3. Verify all features working
4. Get teman's contact for support

### **Integration Ready When:**
✅ Hotspot manually working  
✅ API accessible from Laravel  
✅ Can create users via API  
✅ Bandwidth limits working  
✅ Time expiration working  

### **Then Start:**
1. Create MikrotikService class
2. Test each API method
3. Integrate with payment flow
4. Deploy to production

---

**Ada pertanyaan tentang Mikrotik setup? Tanya sekarang! 🙋**

