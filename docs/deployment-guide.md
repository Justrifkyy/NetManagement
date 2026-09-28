# Native Deployment & Development Guide — NetManager

Panduan resmi untuk menjalankan dan deploy aplikasi **NetManager** secara native (Local Development & Linux VPS) tanpa Docker.

---

## 1. Kebutuhan Sistem (Native Prerequisites)

- **OS:** Linux (Ubuntu 22.04 / 24.04 LTS direkomendasikan) atau Windows/macOS untuk local dev
- **PHP:** 8.2 atau lebih baru
  - Ekstensi wajib: `php8.2-fpm`, `php8.2-mysql`, `php8.2-mbstring`, `php8.2-xml`, `php8.2-curl`, `php8.2-bcmath`, `php8.2-sockets`, `php8.2-zip`, `php8.2-gd`, `php8.2-intl`
- **Composer:** 2.x
- **Node.js & NPM:** Node.js 20.x LTS & NPM
- **Database:** MySQL 8.0+ atau MariaDB 10.11+
- **Web Server:** Nginx (untuk produksi)
- **Process Manager:** PM2 atau Systemd / Supervisor (untuk WhatsApp Gateway service & Queue Worker)
- **Browser Runtime:** Chromium / Google Chrome (kebutuhan Puppeteer di WhatsApp service)

---

## 2. Local Development Setup

1. **Clone repository:**
   ```bash
   git clone https://github.com/appyx123/NetManager.git
   cd NetManager
   ```

2. **Setup file konfigurasi `.env`:**
   ```bash
   cp .env.example .env
   ```
   Sesuaikan konfigurasi database (`DB_HOST=127.0.0.1`, `DB_DATABASE=db_netmanager`, `DB_USERNAME`, `DB_PASSWORD`).

3. **Install dependensi PHP & generate app key:**
   ```bash
   composer install
   php artisan key:generate
   ```

4. **Jalankan migrasi database & seeder:**
   ```bash
   php artisan migrate --seed
   ```

5. **Buat symbolic link storage:**
   ```bash
   php artisan storage:link
   ```

6. **Install dependensi Frontend & WhatsApp service:**
   ```bash
   npm install
   npm run build

   cd whatsapp-service
   npm install
   cd ..
   ```

7. **Menjalankan aplikasi secara native:**
   ```bash
   # Terminal 1: Laravel Web Server
   php artisan serve --port=8000

   # Terminal 2: WhatsApp Gateway Service
   cd whatsapp-service && npm start

   # Terminal 3: Vite Dev (Opsional jika ingin hot-reload frontend)
   npm run dev
   ```

   Akses aplikasi di browser: `http://localhost:8000`

---

## 3. VPS Native Deployment (Ubuntu 22.04 / 24.04)

### A. Install Paket LEMP & Runtime di Server

```bash
sudo apt update && sudo apt upgrade -y
sudo apt install -y software-properties-common curl git unzip ufw nginx certbot python3-certbot-nginx

# Tambahkan repository PHP Sury
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update
sudo apt install -y php8.2 php8.2-fpm php8.2-mysql php8.2-mbstring php8.2-xml \
    php8.2-curl php8.2-bcmath php8.2-sockets php8.2-zip php8.2-gd php8.2-intl php8.2-cli

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install Node.js 20 & PM2
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt install -y nodejs chromium-browser
sudo npm install -g pm2

# Install MySQL Server
sudo apt install -y mysql-server
sudo mysql_secure_installation
```

### B. Konfigurasi Database MySQL

```sql
sudo mysql -u root -p
CREATE DATABASE db_netmanager CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'netmanager'@'localhost' IDENTIFIED BY 'PasswordKuatAnda123!';
GRANT ALL PRIVILEGES ON db_netmanager.* TO 'netmanager'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### C. Deploy Project ke `/var/www/netmanager`

```bash
# Clone project
sudo git clone https://github.com/appyx123/NetManager.git /var/www/netmanager
cd /var/www/netmanager

# Atur permissions direktori
sudo chown -R www-data:www-data /var/www/netmanager
sudo chmod -R 775 /var/www/netmanager/storage /var/www/netmanager/bootstrap/cache

# Setup environment
sudo cp .env.example .env
sudo nano .env
```

Pastikan `.env` produksi diisi:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://domainanda.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_netmanager
DB_USERNAME=netmanager
DB_PASSWORD=PasswordKuatAnda123!

WA_API_URL=http://127.0.0.1:3000
```

### D. Build & Inisialisasi Aplikasi

```bash
# Jalankan sebagai user www-data atau sesuaikan permission setelahnya
sudo -u www-data composer install --no-dev --optimize-autoloader
sudo -u www-data php artisan key:generate --force
sudo -u www-data php artisan migrate --force
sudo -u www-data php artisan storage:link

# Optimasi cache Laravel
sudo -u www-data php artisan config:cache
sudo -u www-data php artisan route:cache
sudo -u www-data php artisan view:cache

# Build aset frontend
npm install
npm run build

# Setup WhatsApp Microservice
cd /var/www/netmanager/whatsapp-service
npm install
cd /var/www/netmanager
```

### E. Jalankan Service di Background dengan PM2

Buat WhatsApp service dan Laravel queue worker berjalan terus secara otomatis:

```bash
# 1. Jalankan WhatsApp Gateway
cd /var/www/netmanager/whatsapp-service
pm2 start server.js --name "netmanager-wa"

# 2. Jalankan Laravel Queue Worker
cd /var/www/netmanager
pm2 start "php artisan queue:work --sleep=3 --tries=3" --name "netmanager-queue"

# Simpan state PM2 agar auto-start saat reboot VPS
pm2 save
pm2 startup
```

*Untuk scan QR WhatsApp awal: jalankan `pm2 logs netmanager-wa` lalu pindai QR dengan WhatsApp smartphone.*

### F. Konfigurasi Nginx Web Server

Buat file konfigurasi `/etc/nginx/sites-available/netmanager`:

```nginx
server {
    listen 80;
    server_name domainanda.com;
    root /var/www/netmanager/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Aktifkan konfigurasi dan restart Nginx:
```bash
sudo ln -s /etc/nginx/sites-available/netmanager /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

Pasang sertifikat SSL Let's Encrypt:
```bash
sudo certbot --nginx -d domainanda.com
```

### G. Setup Cron Job Scheduler

Tambahkan ke crontab server (`sudo crontab -u www-data -e`):
```cron
* * * * * cd /var/www/netmanager && php artisan schedule:run >> /dev/null 2>&1
```

---

## 4. Maintenance & Troubleshooting

- **Cek status service background:**
  ```bash
  pm2 status
  pm2 logs netmanager-wa
  ```
- **Reset sesi WhatsApp jika corrupt:**
  ```bash
  pm2 stop netmanager-wa
  rm -rf /var/www/netmanager/whatsapp-service/.wwebjs_auth
  pm2 start netmanager-wa
  pm2 logs netmanager-wa
  ```
- **Clear cache saat deploy update baru:**
  ```bash
  php artisan optimize:clear
  php artisan config:cache
  php artisan route:cache
  php artisan view:cache
  ```
