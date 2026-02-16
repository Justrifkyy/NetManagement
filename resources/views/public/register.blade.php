<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran Internet</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center font-bold text-xl text-blue-600">
                <svg class="w-8 h-8 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                NetManager ISP
            </div>
            <div class="text-sm text-gray-500">Formulir Pendaftaran Online</div>
        </div>
    </div>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        
        <div class="text-center mb-10">
            <h1 class="text-3xl font-extrabold text-gray-900">Mulai Berlangganan Hari Ini</h1>
            <p class="mt-2 text-gray-600">Isi formulir di bawah untuk menjadwalkan pemasangan internet di lokasi Anda.</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm">
                <p class="font-bold">Mohon perbaiki kesalahan berikut:</p>
                <ul class="list-disc ml-5 text-sm mt-1">
                    @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('public.register.store') }}" method="POST" enctype="multipart/form-data" x-data="{ customerType: 'personal' }" class="space-y-8">
            @csrf

            <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 shadow-sm">
                <h3 class="text-blue-800 font-bold text-lg mb-2 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                    Punya Kode Sales / Marketing?
                </h3>
                <p class="text-sm text-blue-600 mb-3">Jika Anda direkomendasikan oleh tim kami, masukkan kodenya di sini agar kami bisa menugaskan mereka untuk Anda.</p>
                <input type="text" name="marketing_code" class="w-full border-blue-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5" placeholder="Contoh: SALES-01 (Kosongkan jika tidak ada)">
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h2 class="text-xl font-bold text-gray-900 border-b pb-3 mb-5">1. Identitas Diri</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status Pendaftaran</label>
                        <div class="flex space-x-4">
                            <label class="flex items-center p-3 border rounded-lg cursor-pointer w-full hover:bg-gray-50" :class="customerType == 'personal' ? 'border-blue-500 ring-1 ring-blue-500 bg-blue-50' : 'border-gray-300'">
                                <input type="radio" name="customer_type" value="personal" x-model="customerType" class="text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 font-medium">Rumah / Pribadi</span>
                            </label>
                            <label class="flex items-center p-3 border rounded-lg cursor-pointer w-full hover:bg-gray-50" :class="customerType == 'business' ? 'border-blue-500 ring-1 ring-blue-500 bg-blue-50' : 'border-gray-300'">
                                <input type="radio" name="customer_type" value="business" x-model="customerType" class="text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 font-medium">Kantor / Bisnis</span>
                            </label>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap (Sesuai KTP) <span class="text-red-500">*</span></label>
                        <input type="text" name="name" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 py-2.5">
                    </div>

                    <div class="md:col-span-2" x-show="customerType == 'business'" x-transition>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Usaha / Instansi</label>
                        <input type="text" name="business_name" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 py-2.5" placeholder="PT / CV / Toko...">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">No. WhatsApp Aktif <span class="text-red-500">*</span></label>
                        <input type="number" name="phone" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 py-2.5" placeholder="08...">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email (Opsional)</label>
                        <input type="email" name="email" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 py-2.5">
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h2 class="text-xl font-bold text-gray-900 border-b pb-3 mb-5">2. Kontak Darurat (Wajib)</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kerabat/Wali</label>
                        <input type="text" name="emergency_name" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 py-2.5">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor HP Kerabat</label>
                        <input type="number" name="emergency_phone" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 py-2.5">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Hubungan</label>
                        <select name="emergency_relation" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 py-2.5">
                            <option value="">- Pilih Hubungan -</option>
                            <option value="Orang Tua">Orang Tua (Ayah/Ibu)</option>
                            <option value="Suami/Istri">Suami / Istri</option>
                            <option value="Saudara">Saudara Kandung</option>
                            <option value="Kerabat">Kerabat Lain</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h2 class="text-xl font-bold text-gray-900 border-b pb-3 mb-5">3. Lokasi Pemasangan</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap (Jalan, No. Rumah) <span class="text-red-500">*</span></label>
                        <textarea name="address" rows="3" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">RT / RW</label>
                        <input type="text" name="rt_rw" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 py-2.5" placeholder="001/005">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kelurahan / Desa</label>
                        <input type="text" name="village" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 py-2.5">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kecamatan <span class="text-red-500">*</span></label>
                        <input type="text" name="district" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 py-2.5">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kota / Kabupaten <span class="text-red-500">*</span></label>
                        <input type="text" name="city" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 py-2.5">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Provinsi</label>
                        <input type="text" name="province" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 py-2.5">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kode Pos</label>
                        <input type="number" name="postal_code" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 py-2.5">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Patokan Lokasi (Pagar/Warna Rumah)</label>
                        <input type="text" name="landmark" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 py-2.5">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Titik Koordinat / Link Google Maps</label>
                        <input type="text" name="coordinates" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 py-2.5" placeholder="-5.12345, 119.54321">
                        <p class="text-xs text-gray-500 mt-1">Buka Google Maps, tekan lama lokasi rumah, salin angkanya.</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h2 class="text-xl font-bold text-gray-900 border-b pb-3 mb-5">4. Pilihan Layanan</h2>
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Paket Internet <span class="text-red-500">*</span></label>
                        <select name="package_id" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 py-2.5 bg-white">
                            <option value="">-- Pilih Paket --</option>
                            @foreach($packages as $pkg)
                                <option value="{{ $pkg->id }}">{{ $pkg->name }} - {{ $pkg->speed_mbps }} Mbps (Rp {{ number_format($pkg->price, 0, ',', '.') }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Waktu Pemasangan Diinginkan</label>
                        <input type="text" name="preferred_time" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 py-2.5" placeholder="Contoh: Siang Jam 2, atau Hari Minggu">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kode Promo (Jika ada)</label>
                        <input type="text" name="promo_code" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 py-2.5">
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h2 class="text-xl font-bold text-gray-900 border-b pb-3 mb-5">5. Dokumen Pendukung</h2>
                <div class="grid grid-cols-1 gap-6">
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Foto KTP (Wajib) <span class="text-red-500">*</span></label>
                        <input type="file" name="ktp_image" accept="image/*" required class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Foto Depan Rumah</label>
                        <input type="file" name="house_image" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Foto Selfie / Pelanggan</label>
                        <input type="file" name="customer_image" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>

                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent rounded-xl shadow-lg text-lg font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition transform hover:-translate-y-1">
                    Kirim Pendaftaran
                </button>
                <p class="text-center text-xs text-gray-500 mt-4">Dengan mengirim formulir ini, Anda menyetujui syarat & ketentuan layanan kami.</p>
            </div>

        </form>
    </div>

    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="max-w-3xl mx-auto px-4 text-center text-sm opacity-70">
            &copy; {{ date('Y') }} NetManager ISP System. All rights reserved.
        </div>
    </footer>

</body>
</html>