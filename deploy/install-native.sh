#!/bin/bash
echo "🚀 Memulai Instalasi Native NetManager di STB HG680P..."

# 1. Update Permissions
echo "🔐 Mengatur permission folder..."
sudo chown -R $USER:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

# 2. Setup .env & Composer
echo "📦 Menginstal dependensi PHP (Composer)..."
if [ ! -f .env ]; then
    cp .env.example .env
    echo "✅ File .env berhasil dibuat dari .env.example."
fi

composer install --optimize-autoloader --no-dev
php artisan key:generate --force

# 3. INTERACTIVE ENV CONFIGURATION (CRUCIAL)
echo "====================================================="
echo "⚠️ PENGATURAN ENVIRONMENT VARIABLES DIBUTUHKAN ⚠️"
echo "Anda harus mengatur kredensial Database, Midtrans, dan MikroTik."
echo "Script akan membuka text editor (nano) sekarang."
echo "Setelah selesai mengedit, tekan CTRL+X, lalu Y, lalu ENTER untuk menyimpan."
echo "====================================================="
read -p "Tekan ENTER untuk membuka file .env sekarang..."
nano .env

echo "✅ Konfigurasi .env disimpan! Melanjutkan proses..."

# 4. Database & Optimization
echo "🔗 Menghubungkan Storage..."
php artisan storage:link

echo "🗄️ Menjalankan Migrasi Database..."
php artisan migrate --force

echo "⚡ Mengoptimalkan Laravel..."
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 5. Build Frontend Assets (Vite)
echo "🎨 Mengkompilasi aset Frontend (Vite)..."
npm install
npm run build

# 6. Setup WhatsApp Microservice
echo "📱 Mengatur WhatsApp Gateway..."
cd whatsapp-service
npm install
cd ..

# 7. PM2 Setup for Daemons
echo "🔄 Mengkonfigurasi Background Workers dengan PM2..."
if ! command -v pm2 &> /dev/null; then
    sudo npm install -g pm2
fi

# Stop if already running
pm2 stop netmanager-queue netmanager-wa 2>/dev/null || true

# Start Laravel Queue
pm2 start artisan --name "netmanager-queue" -- interpreter php -- queue:work --sleep=3 --tries=3

# Start Node.js WhatsApp Service
cd whatsapp-service
pm2 start server.js --name "netmanager-wa"
cd ..

pm2 save
sudo pm2 startup

echo "====================================================="
echo "🎉 INSTALASI SELESAI! Sistem siap digunakan di IP STB Anda."
echo "Gunakan 'pm2 logs netmanager-wa' untuk scan QR WhatsApp."
echo "====================================================="
