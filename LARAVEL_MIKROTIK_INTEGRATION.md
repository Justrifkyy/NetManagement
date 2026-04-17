# 🔗 Laravel ↔ Mikrotik Integration Blueprint

**Status: Ready to implement after Mikrotik setup complete**  
**Estimated time: 3-4 days**

---

## 📊 Integration Flow

```
PAYMENT CONFIRMATION
        ↓
  🤖 Laravel receives webhook from Midtrans
        ↓
  Transaction status = 'completed'
        ↓
  Dispatch job: CreateMikrotikUser
        ↓
  🌐 Connect to Mikrotik API
        ↓
  Create hotspot user with credentials
        ↓
  Set bandwidth limits
        ↓
  Set expiration date (30 days)
        ↓
  ✅ Customer receives WiFi access
        ↓
  📧 Send invoice + WiFi credentials
        ↓
  🔔 Customer can login & use WiFi
```

---

## 🛠️ Built-In PHP Library for Mikrotik

Since we need to control Mikrotik from Laravel, we'll use RouterOS API library.

### **Option 1: mtk-php-api (Recommended)**

```bash
# Install library
composer require larvatechn/mtk-php-api

# This gives us methods like:
# - createUser()
# - deleteUser()
# - disableUser()
# - getUsers()
# - setRateLimit()
```

### **Option 2: Build Custom (Learning)**

Create our own API connector using PHP sockets.

---

## 📁 Files We'll Create

```
app/
├── Services/
│   ├── MikrotikService.php          ← Main service class
│   └── MikrotikConnectionManager.php ← Handle connection
│
├── Jobs/
│   ├── CreateMikrotikUser.php       ← Queue job for user creation
│   ├── DisableMikrotikUser.php      ← Queue job for suspension
│   ├── ExpireMikrotikUser.php       ← Queue job for expiration
│   └── MonitorMikrotikUsage.php     ← Monitoring job
│
├── Http/
│   └── Controllers/
│       ├── MikrotikUserController.php ← Manage users
│       ├── MikrotikMonitorController.php ← View stats
│       └── WebhookController.php    ← Receive webhooks
│
├── Models/
│   ├── MikrotikUser.php            ← Store Mikrotik user data
│   └── NetworkUsage.php            ← Track bandwidth usage
│
└── Commands/
    ├── ExpireUsersCommand.php       ← Daily expiration check
    └── SyncUsersCommand.php         ← Sync with Mikrotik

database/
└── migrations/
    ├── create_mikrotik_users_table
    └── create_network_usage_table

resources/views/
├── admin/network/
│   ├── users.blade.php             ← User list
│   ├── user-detail.blade.php       ← Individual stats
│   └── monitoring.blade.php        ← Real-time monitoring
└── customer/
    └── wifi-credentials.blade.php  ← Show WiFi login in dashboard
```

---

## 📝 Core Implementation

### **1. MikrotikService.php** (Main Service Class)

```php
<?php

namespace App\Services;

use Exception;

class MikrotikService
{
    private $host;
    private $port;
    private $user;
    private $password;
    private $connection;

    public function __construct()
    {
        // Load from config/mikrotik.php
        $this->host = config('mikrotik.host');          // 192.168.88.1
        $this->port = config('mikrotik.port');          // 8728
        $this->user = config('mikrotik.api_user');      // api_user
        $this->password = config('mikrotik.api_password'); // api_password
    }

    /**
     * Test connection to Mikrotik
     */
    public function testConnection()
    {
        try {
            $socket = @fsockopen($this->host, $this->port, $errno, $errstr, 5);
            
            if (!$socket) {
                throw new Exception("Cannot connect to Mikrotik: $errstr ($errno)");
            }
            
            fclose($socket);
            return ['status' => 'connected', 'message' => 'Successfully connected'];
            
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Create hotspot user
     */
    public function createUser($username, $password, $profile = 'basic_plan', $expirationDays = 30)
    {
        try {
            // Construct expiration date
            $expirationDate = now()->addDays($expirationDays)->toDateTimeString();
            
            // Build user creation data
            $userData = [
                '.tag' => 'user_add',
                'name' => $username,
                'password' => $password,
                'profile' => $profile,
                'comment' => "Created at: " . now(),
                // Limit: 30 days (set via profile)
            ];
            
            // Call Mikrotik API
            $result = $this->apiCall('/ip/hotspot/user/add', $userData);
            
            return [
                'status' => 'success',
                'username' => $username,
                'message' => 'User created successfully',
                'expiration' => $expirationDate
            ];
            
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Disable user (suspend)
     */
    public function disableUser($username)
    {
        try {
            // Get user ID first
            $userId = $this->getUserId($username);
            
            if (!$userId) {
                throw new Exception("User not found: $username");
            }
            
            // Disable the user
            $disableData = [
                '.tag' => 'user_disable',
                'numbers' => $userId
            ];
            
            $this->apiCall('/ip/hotspot/user/set', $disableData);
            
            return [
                'status' => 'success',
                'message' => "User $username disabled"
            ];
            
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Delete user permanently
     */
    public function deleteUser($username)
    {
        try {
            $userId = $this->getUserId($username);
            
            if (!$userId) {
                throw new Exception("User not found: $username");
            }
            
            $deleteData = [
                '.tag' => 'user_remove',
                'numbers' => $userId
            ];
            
            $this->apiCall('/ip/hotspot/user/remove', $deleteData);
            
            return [
                'status' => 'success',
                'message' => "User $username deleted"
            ];
            
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Get all users
     */
    public function getUsers()
    {
        try {
            $listData = ['.tag' => 'user_list'];
            
            $response = $this->apiCall('/ip/hotspot/user/print', $listData);
            
            return [
                'status' => 'success',
                'users' => $response
            ];
            
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Monitor real-time traffic for user
     */
    public function getActiveConnections()
    {
        try {
            $activeData = ['.tag' => 'active_list'];
            
            $response = $this->apiCall('/ip/hotspot/active/print', $activeData);
            
            return [
                'status' => 'success',
                'active_connections' => $response
            ];
            
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Get usage statistics for user
     */
    public function getUserStats($username)
    {
        try {
            $users = $this->getUsers()['users'] ?? [];
            
            $userStats = collect($users)->firstWhere('name', $username);
            
            if (!$userStats) {
                throw new Exception("User not found");
            }
            
            return [
                'status' => 'success',
                'stats' => $userStats
            ];
            
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Internal: Make API call to Mikrotik
     */
    private function apiCall($endpoint, $data)
    {
        // Implementation depends on library used
        // This is pseudo-code showing the concept
        
        // Using RouterOS API library:
        $api = new RouterOS\Client([
            'host' => $this->host,
            'user' => $this->user,
            'pass' => $this->password,
        ]);
        
        return $api->query($endpoint)->all();
    }

    /**
     * Internal: Get user ID from username
     */
    private function getUserId($username)
    {
        $users = $this->getUsers()['users'] ?? [];
        $user = collect($users)->firstWhere('name', $username);
        
        return $user['.id'] ?? null;
    }
}
?>
```

---

### **2. Config File** (config/mikrotik.php)

```php
<?php

return [
    'enabled' => env('MIKROTIK_ENABLED', false),
    
    'host' => env('MIKROTIK_HOST', '192.168.88.1'),
    'port' => env('MIKROTIK_PORT', 8728),
    
    'api_user' => env('MIKROTIK_API_USER', 'api_user'),
    'api_password' => env('MIKROTIK_API_PASSWORD', 'api_password'),
    
    'hotspot' => [
        'pool' => 'hotspot_pool',
        'interface' => 'ether1',
    ],
    
    'profiles' => [
        'basic_plan' => [
            'rate_limit' => '10M/10M',
            'duration' => '30d',
        ],
        'premium_plan' => [
            'rate_limit' => '25M/25M',
            'duration' => '30d',
        ],
    ],
];
```

### **.env File Update**

```
MIKROTIK_ENABLED=true
MIKROTIK_HOST=192.168.88.1
MIKROTIK_PORT=8728
MIKROTIK_API_USER=api_user
MIKROTIK_API_PASSWORD=api_password
```

---

### **3. CreateMikrotikUser Job** (Queue Job)

```php
<?php

namespace App\Jobs;

use App\Models\Customer;
use App\Models\MikrotikUser;
use App\Services\MikrotikService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateMikrotikUser implements ShouldQueue
{
    use Dispatchable, Queueable;

    protected $customer;
    protected $transaction;

    public function __construct(Customer $customer, $transaction)
    {
        $this->customer = $customer;
        $this->transaction = $transaction;
    }

    public function handle()
    {
        $mikrotik = new MikrotikService();
        
        // Generate WiFi credentials
        $username = 'wifi_' . $this->customer->id . '_' . time();
        $password = $this->generateRandomPassword();
        
        // Create in Mikrotik
        $result = $mikrotik->createUser(
            $username,
            $password,
            'basic_plan',  // Profile
            30             // Expiration: 30 days
        );
        
        if ($result['status'] === 'success') {
            // Save to database
            MikrotikUser::create([
                'customer_id' => $this->customer->id,
                'transaction_id' => $this->transaction->id,
                'username' => $username,
                'password' => $password,
                'profile' => 'basic_plan',
                'status' => 'active',
                'expires_at' => now()->addDays(30),
            ]);
            
            // Send credentials to customer
            dispatch(new SendWiFiCredentials($this->customer, $username, $password));
        } else {
            // Log error
            \Log::error("Failed to create Mikrotik user: " . $result['message']);
            throw new Exception($result['message']);
        }
    }

    private function generateRandomPassword($length = 12)
    {
        return bin2hex(random_bytes($length / 2));
    }
}
?>
```

---

### **4. MikrotikUser Model**

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MikrotikUser extends Model
{
    protected $fillable = [
        'customer_id',
        'transaction_id',
        'username',
        'password',
        'profile',
        'status',    // active / suspended / expired
        'expires_at',
        'created_at',
        'updated_at',
    ];

    protected $dates = ['expires_at'];

    // Relationships
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    // Check if expired
    public function isExpired()
    {
        return $this->expires_at->isPast();
    }

    // Mark as expired
    public function markAsExpired()
    {
        $this->update(['status' => 'expired']);
    }
}
?>
```

---

### **5. Payment Webhook Integration**

When customer pays via Midtrans:

```php
// app/Http/Controllers/WebhookController.php

public function midtransNotification(Request $request)
{
    $notification = $request->all();
    $password = config('midtrans.server_key');
    
    // Verify signature
    $signature = hash('sha512', $notification['order_id'] . $password . $notification['gross_amount']);
    
    if ($signature !== $notification['signature_key']) {
        return response()->json(['message' => 'Invalid signature'], 403);
    }

    $transaction = Transaction::find($notification['order_id']);

    if ($notification['transaction_status'] == 'settlement') {
        // Payment confirmed ✅
        $transaction->update(['status' => 'completed']);
        
        // Create Mikrotik user
        dispatch(new CreateMikrotikUser(
            $transaction->customer,
            $transaction
        ));
        
        // Send notification
        dispatch(new SendNotification(
            $transaction->customer,
            'WiFi activated! Check your credentials'
        ));
    }

    return response()->json(['message' => 'OK']);
}
```

---

### **6. Database Migration**

```php
<?php

return new class extends Migration {
    public function up()
    {
        Schema::create('mikrotik_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('transaction_id');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('profile')->default('basic_plan');
            $table->enum('status', ['active', 'suspended', 'expired'])->default('active');
            $table->dateTime('expires_at');
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('transaction_id')->references('id')->on('transactions');
            $table->index('status');
            $table->index('expires_at');
        });

        Schema::create('network_usage', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mikrotik_user_id');
            $table->datetime('recorded_at');
            $table->bigInteger('bytes_uploaded');
            $table->bigInteger('bytes_downloaded');
            $table->timestamps();

            $table->foreign('mikrotik_user_id')->references('id')->on('mikrotik_users');
            $table->index('recorded_at');
        });
    }
};
```

---

## 🔄 Complete Flow Diagram

```
┌──────────────────────────────────────────────────────────────┐
│                  CUSTOMER PAYMENT FLOW                        │
└──────────────────────────────────────────────────────────────┘

1. Customer clicks "Pay" button
   ↓
2. Laravel redirects to Midtrans checkout
   ↓
3. Customer enters payment details
   ↓
4. Midtrans processes payment
   ↓
5. Midtrans calls webhook: /api/webhook/midtrans
   ↓
6. Laravel receives payment confirmation
   ↓
7. Transaction status = 'completed'
   ↓
8. Dispatch Queue Job: CreateMikrotikUser
   ↓
9. Laravel calls Mikrotik API:
   createUser('wifi_123_456', 'password123')
   ↓
10. Mikrotik creates new hotspot user
   ↓
11. Save to DB: MikrotikUser record created
   ↓
12. Dispatch: SendWiFiCredentials notification
   ↓
13. Customer receives email:
    "WiFi ready!"
    Username: wifi_123_456
    Password: password123
   ↓
14. Customer login to WiFi hotspot
   ↓
15. WiFi access granted for 30 days
   ↓
16. Schedule: Check for expired users daily
   ↓
17. After 30 days: Mark user as expired
   ↓
18. Dispatch: DisableMikrotikUser job
   ↓
19. Mikrotik disables user access
   ↓
20. Send: "WiFi subscription expired, renew?"
   ↓
   REPEAT from step 3
```

---

## ✅ Testing Steps

### **Test 1: Connection**
```php
Route::get('/test/mikrotik-connect', function () {
    $service = new MikrotikService();
    return $service->testConnection();
});
// Response: { "status": "connected" }
```

### **Test 2: Create User**
```php
Route::post('/test/create-user', function () {
    $service = new MikrotikService();
    return $service->createUser('testuser', 'testpass', 'basic_plan', 30);
});
// Response: { "status": "success", "username": "testuser" }
```

### **Test 3: Get Users**
```php
Route::get('/test/list-users', function () {
    $service = new MikrotikService();
    return $service->getUsers();
});
// Response: { "status": "success", "users": [...] }
```

### **Test 4: Disable User**
```php
Route::post('/test/disable-user/{username}', function ($username) {
    $service = new MikrotikService();
    return $service->disableUser($username);
});
// Response: { "status": "success" }
```

---

## 📊 Admin Dashboard Views

After integration, admin can:

```
1. View all users
   /admin/network/users
   • Table showing all WiFi users
   • Username, status, expiration date
   • Bandwidth usage
   • Actions: suspend, delete, renew

2. Monitor traffic real-time
   /admin/network/monitoring
   • Current connected users
   • Active sessions
   • Bandwidth graph
   • Top users

3. Customer WiFi info
   /customer/wifi-info
   • My WiFi username
   • My WiFi password
   • Subscription expires
   • Data used: X GB / Y GB
   • Renew button

4. Reports
   /admin/network/reports
   • Revenue from WiFi sales
   • User statistics
   • Peak usage times
   • Network health
```

---

## 🚀 Deployment Checklist

Before going live:

```
☐ Mikrotik device configured & tested
☐ MikrotikService class created & tested
☐ Queue worker running
☐ Webhook URL configured in Midtrans
☐ Database migrations run
☐ All tests passing
☐ Error logging setup
☐ Monitoring dashboard ready
☐ Admin trained
☐ Customer support ready
☐ Backup strategy in place
```

---

**Status: Ready to implement after Mikrotik setup complete! 🚀**

