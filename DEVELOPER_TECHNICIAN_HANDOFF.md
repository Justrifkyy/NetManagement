# 🤝 Developer ↔ Network Technician Communication Guide

**Status: Before Integration Starts**  
**Purpose: Clear data requirements between teams**  
**Date: April 17, 2026**

---

## 📋 Siapa Butuh Data dari Siapa?

```
DEVELOPER (Anda - Web App)
        ↕️ (need data/access)
NETWORK TECHNICIAN (Teman - Mikrotik Expert)

Developer butuh: Mikrotik credentials + configuration info
Technician perlu: Know yang Developer mau (create user, disable, etc)
```

---

## 🎯 Data yang WAJIB Diminta dari Teknisi

### **KATEGORI 1: SERVER CONNECTION INFO** (Paling Penting ⭐⭐⭐)

**Ini yang digunakan Laravel untuk connect ke Mikrotik:**

```
☐ Mikrotik IP Address
  Contoh: 192.168.88.1
  Tanya: "IP address Mikrotik berapa?"
  
☐ API Port
  Expected: 8728 (standard)
  Tanya: "Port untuk API berapa? Pakai default 8728?"
  
☐ API Username
  Contoh: api_user
  Tanya: "Sudah create user untuk API? Namanya apa?"
  
☐ API Password
  Contoh: api_password123
  Tanya: "Password API user apa?"
  
☐ Device Model & Specs
  Contoh: hAP ac² or RB750Gr3
  Tanya: "Model Mikrotik apa? Spek CPU/RAM?"
  
⚠️ SAVE THESE SOMEWHERE SAFE!
   (Will use in .env file)
```

**Format Rekam:**
```
Mikrotik Configuration:
├─ IP: ________________
├─ API Port: ________________
├─ API User: ________________
├─ API Password: ________________
└─ Device Model: ________________
```

---

### **KATEGORI 2: HOTSPOT CONFIGURATION** (Penting ⭐⭐⭐)

**Ini konfigurasi yang harus sudah dibuat teknisi:**

```
☐ Hotspot Enabled?
  Tanya: "Hotspot sudah aktif/enabled?"
  Answer harus: YES / SUDAH
  Jika No: Min minta setup dulu
  
☐ Hotspot Interface
  Contoh: ether1 atau wlan1
  Tanya: "Hotspot pakai interface apa?"
  Record: ________________
  
☐ Hotspot Address Pool
  Contoh: 10.0.0.0/24 atau 192.168.88.0/24
  Tanya: "Pool IP untuk hotspot berapa?"
  Record: ________________
  
☐ WiFi SSID Name (kalau ada WiFi)
  Contoh: "NetManager_WiFi"
  Tanya: "SSID WiFi apa nama?"
  Record: ________________
  
☐ Hotspot Profile Name
  Contoh: default, basic_plan, premium_plan
  Tanya: "Profile hotspot sudah dibuat? Nama-nama profile apa?"
  Record: ________________
```

**Checklist Teknisi:**
```
Sebelum developer code, teknisi HARUS:
☐ Hotspot enabled dan running
☐ WiFi broadcasting (jika ada WiFi module)
☐ API enabled pada port 8728
☐ API user created
☐ Test manual user login bisa
☐ Backup configuration sudah
```

---

### **KATEGORI 3: BANDWIDTH PROFILE INFO** (Penting ⭐⭐)

**Ini profile yang akan diassign ke customers:**

```
Tanya ke teknisi:
☐ "Sudah ada profile untuk bandwidth limit? Apa nama-namanya?"

Expected answer contoh:
  Profile 1: basic_plan → 10 Mbps
  Profile 2: premium_plan → 25 Mbps
  Profile 3: unlimited → tanpa limit

Kalau belum ada, minta buat:
☐ Basic_plan: 10M/10M (rate limit)
☐ Premium_plan: 25M/25M
☐ Unlimited: no limit

Record Profile Info:
Profile Name        │ Rate Limit    │ Notes
─────────────────────────────────────────────
basic_plan          │ 10M/10M       │ 
premium_plan        │ 25M/25M       │
unlimited           │ -             │
```

---

### **KATEGORI 4: SESSION & EXPIRATION CONFIG** (Penting ⭐⭐)

**Ini konfigurasi lifetime user:**

```
Tanya ke teknisi:

☐ "Session timeout berapa hari?"
  (How long customer dapat access)
  Expected: 30 days
  Tanya: "Default 30 hari atau berapa?"
  Record: ________________
  
☐ "Idle timeout berapa menit?"
  (Disconnect kalau tidak aktif)
  Expected: 30 minutes
  Tanya: "Kalau idle menit brp di-disconnect?"
  Record: ________________
  
☐ "Ada mekanisme auto-expire?"
  (Disable user setelah X hari)
  Tanya: "Bisa auto-disable user setelah hari ke-30?"
  Jawaban harus: YES atau bisa dikonfigurasi
```

---

### **KATEGORI 5: MONITORING & STATS** (Nice to Have ⭐)

**Untuk dashboard admin tracking:**

```
Tanya ke teknisi:

☐ "Bisa track bandwidth per user?"
  (Real-time monitoring)
  
☐ "Bisa lihat active connections?"
  (Siapa yang sedang online)
  
☐ "Format API response untuk stats?"
  (Bandwidth uploaded/downloaded structure)
  
☐ "Rate limiting untuk API calls?"
  (Berapa request/detik maksimal?)
```

---

## 📝 DOCUMENT TO GIVE TO TECHNICIAN

**Paste ini ke teknisi agar tahu apa yang dibutuhkan:**

```
═════════════════════════════════════════════════════════════
UNTUK TEKNISI MIKROTIK:

Ini data yang developer butuh dari Mikrotik setup:

WAJIB DISEDIAKAN:
✓ Mikrotik IP address: _______________
✓ API port: _______________ (default: 8728)
✓ API username: _______________ 
✓ API password: _______________
✓ Device model: _______________

HOTSPOT CONFIGURATION WAJIB:
✓ Hotspot enabled dan running
✓ Hotspot interface: _______________ (ether1? wlan1?)
✓ Address pool: _______________ (contoh: 10.0.0.0/24)
✓ WiFi SSID (jika ada): _______________

BANDWIDTH PROFILE WAJIB:
✓ Profile untuk basic_plan: 10M/10M
✓ Profile untuk premium_plan: 25M/25M
✓ Session timeout: 30 hari
✓ Idle timeout: 30 menit

TESTING WAJIB BEFORE HANDOFF:
✓ Manual login hotspot works
✓ API accessible dari laptop
✓ Can create user via API
✓ Can disable user via API
✓ Bandwidth limiting working
✓ Session timeout working

Setelah semua done, kirim data ke developer untuk integrate.
═════════════════════════════════════════════════════════════
```

---

## 🔄 Langkah-Langkah Komunikasi

### **STEP 1: Briefing Meeting (30 min)**

**Waktu:** Sebelum teknisi setup Mikrotik

**Agenda:**
```
1. Explain apa yang mau dibuat (2 min)
   - "Kita akan buat sistem WiFi dengan billing"
   - "Customer bayar → dapat WiFi"
   - "Admin bisa monitor bandwidth"

2. Tunjukkan diagram flow (3 min)
   Payment → Mikrotik user create → WiFi access

3. Minta list requirements (5 min)
   - Hotspot enabled
   - API enabled
   - Profiles created
   - Testing done

4. Set timeline (2 min)
   - "Kapan siap untuk testing?"
   - "Kapan siap untuk integration?"

5. Exchange Contact Info (1 min)
   - WhatsApp
   - Email
   - Working hours
```

---

### **STEP 2: Teknisi Setup & Testing (3 jam)**

**Teknisi do:**
```
☐ Setup Mikrotik hotspot
☐ Enable API
☐ Create API user
☐ Create bandwidth profiles
☐ Manual testing hotspot works
☐ Document configuration
☐ Prepare data handoff
```

**Developer do (sambil tunggu):**
```
☐ Review LARAVEL_MIKROTIK_INTEGRATION.md
☐ Prepare .env template
☐ Create MikrotikService class
☐ Write integration tests
```

---

### **STEP 3: Data Handoff (30 min)**

**Teknisi kirim:**

```
EMAIL SUBJECT: "Mikrotik Setup Complete - Configuration Data"

CONTENT:

Mikrotik is setup dan ready untuk integration.

CONFIGURATION DATA:
─────────────────────
IP Address: 192.168.88.1
API Port: 8728
API Username: api_user
API Password: api_password
Device Model: hAP ac²

HOTSPOT INFO:
─────────────
Interface: ether1
Address Pool: 10.0.0.0/24
WiFi SSID: NetManager_WiFi

PROFILES CREATED:
─────────────────
- basic_plan (10M/10M)
- premium_plan (25M/25M)
- unlimited (no limit)

SESSION CONFIG:
───────────────
- Session Timeout: 30d
- Idle Timeout: 30m
- Auto-expire: Yes

TESTING RESULTS:
────────────────
✓ Manual hotspot login works
✓ API accessible at 192.168.88.1:8728
✓ Can create/delete users via API
✓ Bandwidth limits enforced
✓ Session timeout working

TEST COMMANDS USED:
──────────────────
curl -X POST http://192.168.88.1:8728/api/login \
  -u api_user:api_password

Ready untuk developer integration!

Contact: [WhatsApp] [Email]
```

---

### **STEP 4: Developer Integration (3-4 hari)**

**Developer do:**
```
1. Update .env dengan credentials
   MIKROTIK_HOST=192.168.88.1
   MIKROTIK_API_USER=api_user
   MIKROTIK_API_PASSWORD=api_password

2. Create MikrotikService class
   - Connection test ✓
   - Create user ✓
   - Delete user ✓
   - Get users ✓
   - Monitor bandwidth ✓

3. Test integration
   - Laravel → Mikrotik API ✓
   - Payment webhook → Create user ✓
   - Admin dashboard ✓

4. Go-live testing
   - End-to-end flow test
   - Load testing
   - Failover testing
```

---

### **STEP 5: Go-Live (1 hari)**

**Bersama:**
```
☐ Final testing di production-like
☐ Teknisi monitor Mikrotik
☐ Developer monitor Laravel
☐ Test customer experience
☐ Setup monitoring/alerts
☐ Setup backup strategy
```

---

## 📞 REGULAR CHECK-IN TEMPLATE

**Send ini ke teknisi setiap 2 hari selama setup:**

```
WEEKLY CHECK-IN - Mikrotik Integration Setup

Progress:
☐ Phase: [Setup / Testing / Ready for handoff]
☐ Blocker: [None / Issue]

What completed:
- [Done item 1]
- [Done item 2]

What pending:
- [Pending item 1]
- [Pending item 2]

Questions:
- [Question 1]
- [Question 2]

Next steps:
- [Next step 1]
- [Next step 2]

ETA for completion: __________
```

---

## ✅ FINAL HANDOFF CHECKLIST

**Sebelum developer mulai code, pastikan teknisi sudah provide:**

```
CONFIGURATION DATA
☐ Mikrotik IP
☐ API Port
☐ API Username
☐ API Password
☐ Device Model
☐ Hotspot Interface
☐ Address Pool
☐ WiFi SSID

PROFILES
☐ basic_plan configured
☐ premium_plan configured
☐ unlimited option available

SESSION CONFIG
☐ Timeout 30 days
☐ Idle timeout set
☐ Auto-expire capability

TESTING VERIFICATION
☐ Manual hotspot login works
☐ API auth successful
☐ API user create works
☐ API user disable works
☐ Bandwidth limit tested
☐ Session expiration tested

DOCUMENTATION
☐ Configuration backup file provided
☐ CLI commands documented
☐ Network diagram provided
☐ API endpoints documented

SUPPORT PLAN
☐ Support contact info
☐ Emergency support hours
☐ Escalation procedure
☐ Remote access (if needed)
```

---

## 🎓 COMMUNICATION BEST PRACTICES

### **DO:**
```
✓ Be specific - "Port berapa?" instead of "Apa aja config?"
✓ Provide deadline - "Butuh sampai tanggal..."
✓ Dokumentasi jelas - kirim checklist bukan loose requests
✓ Test before handoff - jangan ada surprise integration
✓ Regular updates - weekly check-in
✓ Respect expertise - teknisi tahu network, Anda tahu code
✓ Use same language - define terms clearly
```

### **DON'T:**
```
✗ Assume - don't assume configuration default
✗ Be vague - "configure hotspot" is too vague
✗ Micromanage - let technician do their job
✗ Rush - give enough time for proper testing
✗ Skip documentation - always get written confirmation
✗ Ignore feedback - if technician says it's not possible, listen
```

---

## 🎯 EXAMPLE CONVERSATION WITH TECHNICIAN

### **Good Conversation:**
```
Developer: "Halo, untuk integrate Mikrotik ke web app, 
            aku butuh credentials sama config tertentu."
            
Technician: "Ok, apa aja yang dibutuhkan?"

Developer: "Ini checklistnya:
            - IP Mikrotik
            - API port
            - API username & password
            - Hotspot config
            - Bandwidth profiles"
            
Technician: "Ooh ok, aku setup dulu. Kapan butuh?"

Developer: "Minggu depan ok? Aku siapkan code dulu."

Technician: "Good, I'll have it ready by [date]"

[After 3 days]

Technician: "Setup done. Sudah test manual login, 
             API works. Ini config-nya:"
             [sends all data]

Developer: "Perfect. Terima kasih. 
            Aku test integration minggu ini,
            update kabar setiap 2 hari ok?"

Technician: "Ok, siap support."
```

### **Bad Conversation:**
```
Developer: "Tolong setup Mikrotik"

Technician: "Ok, sudah"

Developer: "Try code...error... 
            API tidak bisa connect"

Technician: "Hmm, tidak tahu"

Developer: "Gimana ini... stuck"
[Days wasted]
```

---

## 📋 ONE-PAGE HANDOFF DOCUMENT

**Print & send ini ke teknisi:**

```
═══════════════════════════════════════════════════════════════
                    MIKROTIK SETUP REQUIREMENTS
                    For Web App Integration
═══════════════════════════════════════════════════════════════

PROJECT: NetManagement WiFi Billing System

DEVELOPER NEEDS:

1. CONNECTION CREDENTIALS
   [ ] Mikrotik IP Address: _______________
   [ ] API Port: _______________
   [ ] API Username: _______________
   [ ] API Password: _______________

2. CONFIGURATION
   [ ] Hotspot enabled & type: _______________
   [ ] Interface used: _______________
   [ ] IP Pool: _______________
   [ ] WiFi SSID: _______________

3. PROFILES (rate limiting)
   [ ] basic_plan: ___M/___M
   [ ] premium_plan: ___M/___M

4. SESSION SETTINGS
   [ ] Max session: 30 days ✓ or ___
   [ ] Idle timeout: 30 min ✓ or ___
   [ ] Auto-expire: Yes ✓ or No

5. TESTING STATUS
   [ ] Manual login verified ✓
   [ ] API accessible ✓
   [ ] User create/delete tested ✓
   [ ] Bandwidth limits tested ✓
   [ ] Ready for developer integration ✓

SUPPORT CONTACT:
   Phone: _______________
   Email: _______________
   WhatsApp: _______________
   Available: _______________

═══════════════════════════════════════════════════════════════
Developer will use this data to integrate with Laravel.
Target handoff date: _______________
═══════════════════════════════════════════════════════════════
```

---

## 🚀 NEXT STEPS

### **TODAY (April 17):**
1. Send ini document ke teknisi
2. Schedule briefing meeting
3. Provide checklist & requirements

### **BEFORE TEKNISI START:**
1. Confirm timeline dengan teknisi
2. Confirm device specs & accessories ready
3. Agree on handoff date

### **DURING SETUP:**
1. Weekly check-in
2. Be available for questions
3. Prepare code side

### **AFTER SETUP:**
1. Receive data handoff
2. Test integration
3. Go-live together

---

**Pertanyaan apa yang harus ditanya ke teknisi? Inbox saya! 🙋**

