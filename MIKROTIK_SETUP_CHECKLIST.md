# ✅ Mikrotik Setup Checklist - Step by Step

**Tanggal: April 17, 2026**  
**Durasi: 2-3 jam minimum untuk setup lengkap**

---

## 🎯 GOAL HARI INI

- [ ] Mikrotik device idup + accessible
- [ ] Network connection verified
- [ ] Hotspot configured & working
- [ ] Manual WiFi test successful
- [ ] API enabled untuk Laravel integration

---

## 📍 STEP-BY-STEP CHECKLIST

### **BAGIAN 1: Hardware & Network Setup (30 min)**

#### Step 1.1: Prepare Mikrotik Device
```
☐ Unbox Mikrotik device
☐ Check power cable + source
☐ Check ethernet cable
☐ Check all antennas attached properly

Device info:
  Model: ________________
  Serial: ________________
  Power: ________________
```

#### Step 1.2: Physical Connection
```
☐ Connect internet cable ke ether1 (WAN port)
          ↓
☐ Connect ethernet ke laptop (ether2 or ether3)
          ↓
☐ Plug power adapter
          ↓
☐ Wait 30 seconds for device to boot
          ↓
☐ Check LED lights are ON/blinking
```

#### Step 1.3: Find Mikrotik IP
```
Option A - Default IP:
☐ Open browser
☐ Go to: http://192.168.88.1
☐ If page loads → IP correct! ✓

Option B - If not working, use WinBox:
☐ Download: https://mikrotik.com/download
☐ Install WinBox
☐ Open WinBox → Neighbors tab
☐ Find your Mikrotik device
☐ Double-click to connect

Default login:
  Username: admin
  Password: (leave empty)

Connected IP: ________________
```

---

### **BAGIAN 2: Initial Mikrotik Configuration (30 min)**

#### Step 2.1: Reset to Default (OPTIONAL - if device was used before)
```
⚠️ WARNING: This will erase all config!

☐ SSH to device:
   ssh admin@[IP_ADDRESS]
   
☐ Run:
   /system default-configuration
   y (confirm)
   
☐ Device restart automatically
☐ Wait 1 minute
☐ Reconnect to IP address
```

#### Step 2.2: Basic Configuration
```
☐ Connect via WinBox to: 192.168.88.1

☐ Check IP Address:
   IP → Addresses
   Should show: 192.168.88.1/24
   
   If not, set it:
   + Add
   Address: 192.168.88.1/24
   Interface: bridge (or ether1)
   
☐ Setup DNS:
   IP → DNS
   Servers: 8.8.8.8 (Google)
           8.8.4.4 (Google backup)
   Allow Remote: ☑️ (checked)

☐ Verify Internet Connection:
   Tool → Ping
   Enter: 8.8.8.8
   Should get ping responses ✓
```

---

### **BAGIAN 3: Hotspot Configuration (1 hour)**

#### Step 3.1: Create Address Pool
```
☐ In WinBox go to: IP → Pools
☐ Click: [ + New ]

Fill in:
  Name: hotspot_pool
  Ranges: 10.0.0.2-10.0.0.254
  
☐ Click: [ OK ]

Pool created, will be used by hotspot
```

#### Step 3.2: Create Hotspot
```
☐ In WinBox go to: IP → Hotspot
☐ Click: [ + New ]

Fill in:
  Name: HS1
  Interface: ether1 (or wlan1 if WiFi)
  Address Pool: hotspot_pool (we just created)
  Disabled: ☐ (unchecked = enabled)

☐ Click: [ OK ]

Hotspot created! ✓
```

#### Step 3.3: Create Hotspot Users
```
☐ In WinBox go to: IP → Hotspot → Users
☐ Click: [ + New ]

Fill in for first user:
  Name: customer_001
  Password: pass123
  Profile: default
  Disabled: ☐ (unchecked = enabled)
  
☐ Click: [ OK ]

Repeat for more users:
☐ Create customer_002 / customer_003 / etc

Users created! ✓
```

#### Step 3.4: Setup Bandwidth Profiles
```
☐ In WinBox go to: IP → Hotspot → Profile

Edit "default" profile to add speed limit:
  Rate Limit: 10M/10M (10 Mbps down/up)
  Session Timeout: 30d (30 days)
  Idle Timeout: 30m (30 minutes inactivity)
  
☐ Click: [ OK ]

☐ Create new profile for premium:
  Name: premium
  Rate Limit: 25M/25M
  Session Timeout: 30d

Profiles configured! ✓
```

---

### **BAGIAN 4: WiFi Broadcasting Setup (15 min)**

#### Step 4.1: Check WiFi Interface
```
☐ In WinBox go to: Interface

☐ Look for:
   wlan1 or wlan2 (should be listed)
   
   If not listed:
   ☐ Device may not have WiFi
   ☐ Contact teman untuk confirm
   
WiFi Interface: ________________
```

#### Step 4.2: Configure WiFi
```
☐ Go to: Interface → Wireless

Find wlan1 (or your WiFi interface):
☐ Double-click to edit

Change settings:
  SSID: NetManager_WiFi (or name of choice)
  Band: 2.4GHz-B/G/N (supported by most devices)
  Channel: 6 (default, change if interference)
  Disabled: ☐ (unchecked = enabled)

☐ Click: [ OK ]

WiFi SSID: ________________
```

#### Step 4.3: Test WiFi Broadcasting
```
☐ On your laptop/phone:
   Look for WiFi networks
   
☐ SSID should appear:
   "NetManager_WiFi" (or whatever name you set)
   
   See it? ✓
   
☐ Try to connect (Optional - will ask for login)
```

---

### **BAGIAN 5: Manual Hotspot Login Test (30 min)**

#### Step 5.1: Connect from Device
```
☐ on phone/laptop:
   WiFi → Select "NetManager_WiFi"
   
☐ When connected:
   Should also see a login page automatically
   
   If not automatic, open browser and go to:
   192.168.88.1 (or might redirect automatically)
```

#### Step 5.2: Login via Hotspot
```
You should see login form:

Username: customer_001
Password: pass123

☐ Enter credentials
☐ Click: [ Login ]

Expected result:
  ✓ "Login successful"
  ✓ Can browse internet/google.com
  ✓ Connection stable
```

#### Step 5.3: Monitor Active Session
```
☐ Go back to Laptop WinBox
☐ IP → Hotspot → Active
☐ You should see connection:

customer_001
IP: 10.0.0.X
Session time: 0:00:xx
Upload/Download: [traffic shown]

This confirms: Hotspot working! ✓
```

#### Step 5.4: Disconnect & Retry
```
☐ Logout or disconnect WiFi
☐ Reconnect with different credential:

Username: customer_002
Password: pass123

☐ Should work same way ✓

Test different users working!
```

---

### **BAGIAN 6: Enable API for Laravel Integration (20 min)**

#### Step 6.1: Enable API Service
```
☐ In WinBox go to: IP → Services

Find "api":
  Protocol: api
  Port: 8728
  
☐ Check: Enabled? Should show ☑️

If not enabled:
☐ Double-click api row
☐ Disabled: ☐ (uncheck)
☐ Click: [ OK ]

API enabled! ✓
```

#### Step 6.2: Create API User
```
☐ In WinBox go to: System → Users

☐ Click: [ + New ]

Fill in:
  Name: api_user
  Password: api_password
  Group: full (full permissions)
  Disabled: ☐ (unchecked = enabled)

☐ Click: [ OK ]

API user created! ✓
```

#### Step 6.3: Test API Access
```
Option A - Using Postman:
  ☐ Open Postman app
  ☐ Create new request
  
  Method: POST
  URL: http://192.168.88.1:8728/api/login
  
  Body (raw JSON):
  {
    "username": "api_user",
    "password": "api_password"
  }
  
  ☐ Send
  
  Should see: Response 200 or authentication token

Option B - Using curl (command line):
  curl -X POST http://192.168.88.1:8728/api/login \
    -u api_user:api_password

Expected:
  ✓ Response successful
  ✓ No error messages
  ✓ Ready for Laravel integration!
```

---

### **BAGIAN 7: Network & Connectivity Verification (10 min)**

#### Step 7.1: Test Internet on Device
```
From Mikrotik device:

☐ Tool → Ping
  Target: 8.8.8.8
  
  Should response: ✓
  
☐ Tool → Traceroute
  Target: 8.8.8.8
  
  Should show path to google: ✓
```

#### Step 7.2: Test from WiFi Client
```
From phone/laptop connected to hotspot:

☐ Open browser
☐ Go to: google.com
☐ Should load: ✓

☐ Ping from terminal:
  ping 8.8.8.8
  Should response: ✓

Internet working! ✓
```

#### Step 7.3: Monitor Bandwidth
```
☐ In WinBox go to: Queue → Simple

This shows:
  Current bandwidth usage
  Connected users
  Active connections

Monitor it while using WiFi to see traffic ✓
```

---

### **BAGIAN 8: Test Bandwidth Limiting (15 min)**

#### Step 8.1: Assign User to Limited Profile
```
☐ In WinBox go to: IP → Hotspot → Users
☐ Double-click: customer_001

Change:
  Profile: premium (instead of default)
  
☐ Click: [ OK ]

User now has 25Mbps limit instead of original
```

#### Step 8.2: Speed Test
```
From phone connected as customer_001:

Open: speedtest.net (or fast.com)

Before limit change:
  Speed: __________ Mbps

After changing to limited profile:
  Speed: Should be ~25 Mbps max

Confirms: Bandwidth limiting works! ✓
```

---

### **BAGIAN 9: Documentation**

#### Step 9.1: Record Configuration
```
MIKROTIK CONFIGURATION SUMMARY
═══════════════════════════════

Device Model: ________________
Device IP: ________________
Internet Connection: ________________
WiFi SSID: ________________

HOTSPOT CREDENTIALS:
  User 1: customer_001 / pass123
  User 2: customer_002 / pass123
  User 3: customer_003 / pass123

PROFILES:
  basic_plan: 10 Mbps, Rate Limit: 10M/10M
  premium_plan: 25 Mbps, Rate Limit: 25M/25M

API CREDENTIALS:
  Username: api_user
  Password: api_password
  Port: 8728
  URL: http://192.168.88.1:8728

TEST RESULTS:
  ☐ WiFi broadcasting
  ☐ Manual hotspot login
  ☐ Internet access through hotspot
  ☐ Bandwidth limited
  ☐ API accessible
```

#### Step 9.2: Save Backup
```
⚠️ Always backup before continuing!

☐ In WinBox go to: File → Backup

☐ Save as:
  Name: Mikrotik_Config_[TODAY_DATE]
  Location: Save on your laptop

This configuration can be restored anytime ✓
```

---

## ⚠️ Common Issues During Setup

### Issue 1: Cannot access 192.168.88.1
```
Solution:
☐ Check ethernet cable connected
☐ Check device has power (LED lights?)
☐ Restart device (unplug 30 sec, plug back)
☐ Try different laptop/cable
☐ Use WinBox Neighbor discovery
```

### Issue 2: No WiFi appearing
```
Solution:
☐ Check interface: Interface → wlan1 should exist
☐ Check if disabled: Should show Disabled: ☐
☐ Try enable: wlan1 → Disabled: uncheck
☐ Check antenna: May be loose
```

### Issue 3: Hotspot login not working
```
Solution:
☐ Check hotspot enabled: IP → Hotspot → print
☐ Check user exists: IP → Hotspot → Users → print
☐ Check password correct: Try recreation
☐ Check pool configured: IP → Pools → should exist
```

### Issue 4: No internet after hotspot login
```
Solution:
☐ Check device internet: Ping 8.8.8.8 from Mikrotik
☐ Check firewall: IP → Firewall → may be blocking
☐ Check NAT: IP → Firewall → NAT → may need rule
☐ Check routing: IP → Routes → verify default route set
```

---

## 📊 FINAL VERIFICATION CHECKLIST

Mark when complete:

```
✓ HARDWARE
  ☐ Device powered on
  ☐ LED lights visible
  ☐ Ethernet connected
  ☐ Internet connected (ISP/tethering)

✓ NETWORK
  ☐ Device accessible at 192.168.88.1
  ☐ DNS configured
  ☐ Ping 8.8.8.8 works
  ☐ Internet verified

✓ HOTSPOT
  ☐ Hotspot enabled
  ☐ WiFi broadcasting
  ☐ Users created (3+ test users)
  ☐ Profiles configured with limits

✓ TESTING
  ☐ Manual WiFi login works
  ☐ Internet access works
  ☐ Multiple users can login
  ☐ Bandwidth limits working
  ☐ Session duration working

✓ API
  ☐ API service enabled (port 8728)
  ☐ API user created
  ☐ Can connect to API
  ☐ Authentication works

✓ DOCUMENTATION
  ☐ Configuration backed up
  ☐ Credentials documented
  ☐ Device info recorded
  ☐ Setup notes saved

ALL CHECKS COMPLETE! ✓✓✓
```

---

## 🎯 NOW READY FOR

1. **Laravel Integration** → Create MikrotikService
2. **Payment Integration** → Create user when customer pays
3. **Auto-expiration** → Disable user after subscription ends
4. **Monitoring** → Real-time bandwidth tracking
5. **Admin Dashboard** → Manage all users

---

## 📞 When You Need Support

Message with:
```
1. What step are you on?
2. What error do you see?
3. What have you tried?
4. Screenshot if possible

Example:
"Step 5.2 - Manual login test
Error: Cannot see login page
Tried: Reset device, reconnect WiFi
Issue: Still blank page"
```

---

**Siap mulai setup? 🚀 Atau ada pertanyaan dulu?**

