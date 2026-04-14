<x-app-layout>
    <div class="py-10 bg-blue-50 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8 px-4 sm:px-0">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-4xl font-bold text-blue-900">Registrasi Prospek Baru</h1>
                        <p class="text-blue-600 mt-1">Isikan data lengkap calon pelanggan</p>
                    </div>
                    <a href="{{ route('marketing.leads.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold">← Kembali</a>
                </div>
            </div>

            @if ($errors->any())
                <div class="mb-6 mx-4 sm:mx-0 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r">
                    <p class="font-bold mb-2">⚠️ Terdapat kesalahan:</p>
                    <ul class="list-disc ml-6 text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Container -->
            <form action="{{ route('marketing.leads.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- SECTION 1: DATA IDENTITAS CALON PELANGGAN -->
                <div class="bg-white rounded-xl shadow-lg border border-blue-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 px-6 py-4 flex items-center">
                        <div class="flex items-center justify-center w-10 h-10 bg-white/30 rounded-full mr-3">
                            <svg class="w-6 h-6 text-blue-900" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-blue-900">DATA IDENTITAS CALON PELANGGAN</h2>
                    </div>
                    <div class="p-6 space-y-6">

                        <!-- Jenis Pelanggan -->
                        <div x-data="{ customerType: '{{ old('customer_type', 'personal') }}' }">
                            <label class="block text-sm font-bold text-blue-900 mb-3">Jenis Pelanggan <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer transition" 
                                    :class="customerType == 'personal' ? 'border-yellow-400 bg-yellow-50' : 'border-blue-200 hover:border-blue-300'">
                                    <input type="radio" name="customer_type" value="personal" x-model="customerType" class="w-4 h-4 text-yellow-500">
                                    <span class="ml-3 font-semibold text-blue-900">👤 Perorangan</span>
                                </label>
                                <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer transition" 
                                    :class="customerType == 'business' ? 'border-yellow-400 bg-yellow-50' : 'border-blue-200 hover:border-blue-300'">
                                    <input type="radio" name="customer_type" value="business" x-model="customerType" class="w-4 h-4 text-yellow-500">
                                    <span class="ml-3 font-semibold text-blue-900">🏢 Bisnis / Usaha</span>
                                </label>
                            </div>
                        </div>

                        <!-- Nama Lengkap -->
                        <div>
                            <label class="block text-sm font-semibold text-blue-900 mb-2">Nama Lengkap (Sesuai KTP) <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                placeholder="Contoh: Budi Santoso">
                        </div>

                        <!-- Nama Usaha (Conditional) -->
                        <div x-data="{ customerType: '{{ old('customer_type', 'personal') }}' }" x-show="customerType == 'business'">
                            <label class="block text-sm font-semibold text-blue-900 mb-2">Nama Usaha/Instansi</label>
                            <input type="text" name="business_name" value="{{ old('business_name') }}"
                                class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                placeholder="Contoh: PT. Maju Jaya">
                        </div>

                        <!-- Grid 2 Kolom -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- No. HP Utama -->
                            <div>
                                <label class="block text-sm font-semibold text-blue-900 mb-2">Nomor HP Utama (WhatsApp) <span class="text-red-500">*</span></label>
                                <input type="text" name="phone" value="{{ old('phone') }}" required
                                    class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                    placeholder="08123456789">
                            </div>

                            <!-- No. HP Cadangan -->
                            <div>
                                <label class="block text-sm font-semibold text-blue-900 mb-2">Nomor HP Cadangan</label>
                                <input type="text" name="phone_backup" value="{{ old('phone_backup') }}"
                                    class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                    placeholder="08987654321">
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-semibold text-blue-900 mb-2">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                    placeholder="contoh@email.com">
                            </div>

                            <!-- Nama Ibu Kandung -->
                            <div>
                                <label class="block text-sm font-semibold text-blue-900 mb-2">Nama Ibu Kandung</label>
                                <input type="text" name="mother_name" value="{{ old('mother_name') }}"
                                    class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                    placeholder="Untuk verifikasi data">
                            </div>
                        </div>

                        <!-- Foto KTP / Foto Rumah / Foto Pelanggan -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-4 border-t border-blue-200">
                            <div>
                                <label class="block text-sm font-semibold text-blue-900 mb-2">📷 Foto KTP</label>
                                <input type="file" name="ktp_image" accept="image/*"
                                    class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                                <p class="text-xs text-blue-600 mt-1">Format: JPG, PNG (Max 5MB)</p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-blue-900 mb-2">🏠 Foto Rumah/Lokasi</label>
                                <input type="file" name="house_image" accept="image/*"
                                    class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                                <p class="text-xs text-blue-600 mt-1">Format: JPG, PNG (Max 5MB)</p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-blue-900 mb-2">👤 Foto Pelanggan</label>
                                <input type="file" name="customer_image" accept="image/*"
                                    class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                                <p class="text-xs text-blue-600 mt-1">Format: JPG, PNG (Max 5MB)</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION 2: DATA ALAMAT -->
                <div class="bg-white rounded-xl shadow-lg border border-blue-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 px-6 py-4 flex items-center">
                        <div class="flex items-center justify-center w-10 h-10 bg-white/30 rounded-full mr-3">
                            <svg class="w-6 h-6 text-blue-900" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-blue-900">DATA ALAMAT PEMASANGAN</h2>
                    </div>
                    <div class="p-6 space-y-6">

                        <!-- Alamat Lengkap -->
                        <div>
                            <label class="block text-sm font-semibold text-blue-900 mb-2">Alamat Lengkap <span class="text-red-500">*</span></label>
                            <textarea name="address" rows="3" required
                                class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                placeholder="Isikan alamat lengkap dimana instalasi dilakukan">{{ old('address') }}</textarea>
                        </div>

                        <!-- Alamat KTP (jika berbeda dengan lokasi instalasi) -->
                        <div>
                            <label class="block text-sm font-semibold text-blue-900 mb-2">Alamat KTP (jika berbeda)</label>
                            <textarea name="address_ktp" rows="2"
                                class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                placeholder="Isikan jika berbeda dengan alamat instalasi">{{ old('address_ktp') }}</textarea>
                        </div>

                        <!-- Grid 4 Kolom -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- RT/RW -->
                            <div>
                                <label class="block text-sm font-semibold text-blue-900 mb-2">RT/RW</label>
                                <input type="text" name="rt_rw" value="{{ old('rt_rw') }}"
                                    class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                    placeholder="Contoh: 05/08">
                            </div>

                            <!-- Kelurahan/Desa -->
                            <div>
                                <label class="block text-sm font-semibold text-blue-900 mb-2">Kelurahan/Desa <span class="text-red-500">*</span></label>
                                <input type="text" name="village" value="{{ old('village') }}" required
                                    class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                    placeholder="Contoh: Kelurahan Maju Jaya">
                            </div>

                            <!-- Kecamatan -->
                            <div>
                                <label class="block text-sm font-semibold text-blue-900 mb-2">Kecamatan <span class="text-red-500">*</span></label>
                                <input type="text" name="district" value="{{ old('district') }}" required
                                    class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                    placeholder="Contoh: Kecamatan Terusan">
                            </div>

                            <!-- Kota/Kabupaten -->
                            <div>
                                <label class="block text-sm font-semibold text-blue-900 mb-2">Kota/Kabupaten <span class="text-red-500">*</span></label>
                                <input type="text" name="city" value="{{ old('city') }}" required
                                    class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                    placeholder="Contoh: Bandung">
                            </div>

                            <!-- Provinsi -->
                            <div>
                                <label class="block text-sm font-semibold text-blue-900 mb-2">Provinsi</label>
                                <input type="text" name="province" value="{{ old('province') }}"
                                    class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                    placeholder="Contoh: Jawa Barat">
                            </div>

                            <!-- Kode Pos -->
                            <div>
                                <label class="block text-sm font-semibold text-blue-900 mb-2">Kode Pos</label>
                                <input type="text" name="postal_code" value="{{ old('postal_code') }}"
                                    class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                    placeholder="Contoh: 40127">
                            </div>
                        </div>

                        <!-- Patokan Lokasi -->
                        <div>
                            <label class="block text-sm font-semibold text-blue-900 mb-2">Patokan Lokasi</label>
                            <textarea name="landmark" rows="2"
                                class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                placeholder="Contoh: Dekat minimarket, samping rumah berwarna merah">{{ old('landmark') }}</textarea>
                        </div>

                        <!-- Titik Lokasi Google Maps -->
                        <div>
                            <label class="block text-sm font-semibold text-blue-900 mb-2">Titik Lokasi Google Maps</label>
                            <input type="text" name="coordinates" value="{{ old('coordinates') }}"
                                class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                placeholder="Contoh: -6.9147, 107.6098">
                            <p class="text-xs text-blue-600 mt-1">Diperoleh dari Google Maps (klik lokasi → salin koordinat)</p>
                        </div>
                    </div>
                </div>

                <!-- SECTION 3: DATA PAKET YANG DIPILIH -->
                <div class="bg-white rounded-xl shadow-lg border border-blue-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 px-6 py-4 flex items-center">
                        <div class="flex items-center justify-center w-10 h-10 bg-white/30 rounded-full mr-3">
                            <svg class="w-6 h-6 text-blue-900" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-blue-900">DATA PAKET YANG DIPILIH</h2>
                    </div>
                    <div class="p-6 space-y-6">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Paket Internet -->
                            <div>
                                <label class="block text-sm font-semibold text-blue-900 mb-2">Paket Internet <span class="text-red-500">*</span></label>
                                <select name="package_id" required
                                    class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                                    <option value="">-- Pilih Paket --</option>
                                    @foreach ($packages as $package)
                                        <option value="{{ $package->id }}" @selected(old('package_id') == $package->id)>
                                            {{ $package->name }} - Rp {{ number_format($package->price, 0, ',', '.') }}/bln
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Biaya Pemasangan -->
                            <div>
                                <label class="block text-sm font-semibold text-blue-900 mb-2">Biaya Pemasangan</label>
                                <input type="number" name="installation_fee" value="{{ old('installation_fee', 0) }}"
                                    class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                    placeholder="0" min="0">
                                <p class="text-xs text-blue-600 mt-1">Isikan jika ada biaya tambahan instalasi</p>
                            </div>
                        </div>

                        <!-- Promo -->
                        <div>
                            <label class="block text-sm font-semibold text-blue-900 mb-2">Kode Promo / Penawaran Khusus</label>
                            <input type="text" name="promo_code" value="{{ old('promo_code') }}"
                                class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                placeholder="Contoh: PROMO2024, HEMAT10, atau kosongkan jika tidak ada">
                        </div>
                    </div>
                </div>

                <!-- SECTION 4: DATA STATUS PROSPEK -->
                <div class="bg-white rounded-xl shadow-lg border border-blue-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 px-6 py-4 flex items-center">
                        <div class="flex items-center justify-center w-10 h-10 bg-white/30 rounded-full mr-3">
                            <svg class="w-6 h-6 text-blue-900" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-blue-900">DATA STATUS PROSPEK</h2>
                    </div>
                    <div class="p-6 space-y-6">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Status Prospek -->
                            <div>
                                <label class="block text-sm font-semibold text-blue-900 mb-2">Status Prospek <span class="text-red-500">*</span></label>
                                <select name="status" required
                                    class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                                    <option value="prospek" @selected(old('status', 'prospek') == 'prospek')>🆕 Prospek Baru</option>
                                    <option value="survey" @selected(old('status') == 'survey')>📋 Menunggu Survey</option>
                                    <option value="instalasi" @selected(old('status') == 'instalasi')>🔧 Menunggu Instalasi</option>
                                    <option value="aktif" @selected(old('status') == 'aktif')>✅ Aktif</option>
                                    <option value="batal" @selected(old('status') == 'batal')>❌ Batal</option>
                                </select>
                            </div>

                            <!-- Sumber Pelanggan -->
                            <div>
                                <label class="block text-sm font-semibold text-blue-900 mb-2">Sumber Pelanggan <span class="text-red-500">*</span></label>
                                <select name="source" required
                                    class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                                    <option value="">-- Pilih Sumber --</option>
                                    <option value="iklan" @selected(old('source') == 'iklan')>📢 Iklan (Google, FB, Instagram)</option>
                                    <option value="referensi" @selected(old('source') == 'referensi')>👥 Referensi / Teman</option>
                                    <option value="sosial_media" @selected(old('source') == 'sosial_media')>📱 Media Sosial</option>
                                    <option value="walk_in" @selected(old('source') == 'walk_in')>🏪 Kunjungan Langsung</option>
                                    <option value="telepon" @selected(old('source') == 'telepon')>☎️ Telepon Masuk</option>
                                    <option value="lainnya" @selected(old('source') == 'lainnya')>📎 Lainnya</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION 5: DATA PENJADWALAN -->
                <div class="bg-white rounded-xl shadow-lg border border-blue-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 px-6 py-4 flex items-center">
                        <div class="flex items-center justify-center w-10 h-10 bg-white/30 rounded-full mr-3">
                            <svg class="w-6 h-6 text-blue-900" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-blue-900">DATA PENJADWALAN</h2>
                    </div>
                    <div class="p-6 space-y-6">

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Tanggal Registrasi -->
                            <div>
                                <label class="block text-sm font-semibold text-blue-900 mb-2">📅 Tanggal Registrasi</label>
                                <input type="date" name="registered_date" value="{{ old('registered_date', now()->format('Y-m-d')) }}"
                                    class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                            </div>

                            <!-- Jadwal Survey -->
                            <div>
                                <label class="block text-sm font-semibold text-blue-900 mb-2">🔍 Jadwal Survey</label>
                                <input type="date" name="survey_date" value="{{ old('survey_date') }}"
                                    class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                            </div>

                            <!-- Jadwal Instalasi -->
                            <div>
                                <label class="block text-sm font-semibold text-blue-900 mb-2">⚙️ Jadwal Instalasi</label>
                                <input type="date" name="installation_date" value="{{ old('installation_date') }}"
                                    class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                            </div>
                        </div>

                        <!-- Waktu yang Diinginkan -->
                        <div>
                            <label class="block text-sm font-semibold text-blue-900 mb-2">Catatan Waktu Diinginkan Pelanggan</label>
                            <textarea name="preferred_time" rows="2"
                                class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                placeholder="Contoh: Hari kerja saja, lebih suka sore hari, dsb">{{ old('preferred_time') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- SECTION 6: CATATAN INTERNAL -->
                <div class="bg-white rounded-xl shadow-lg border border-blue-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 px-6 py-4 flex items-center">
                        <div class="flex items-center justify-center w-10 h-10 bg-white/30 rounded-full mr-3">
                            <svg class="w-6 h-6 text-blue-900" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-blue-900">CATATAN INTERNAL</h2>
                    </div>
                    <div class="p-6 space-y-6">

                        <!-- Ringkasan Komunikasi -->
                        <div>
                            <label class="block text-sm font-semibold text-blue-900 mb-2">📝 Ringkasan Komunikasi</label>
                            <textarea name="notes_summary" rows="3"
                                class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                placeholder="Ringkas percakapan dengan calon pelanggan, kesan umum, kesiapan mereka">{{ old('notes_summary') }}</textarea>
                        </div>

                        <!-- Kendala/Hambatan -->
                        <div>
                            <label class="block text-sm font-semibold text-blue-900 mb-2">⚠️ Kendala / Hambatan</label>
                            <textarea name="notes_obstacle" rows="3"
                                class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                placeholder="Kendala teknis, hambatan pembayaran, keberatan harga, dsb">{{ old('notes_obstacle') }}</textarea>
                        </div>

                        <!-- Catatan Khusus -->
                        <div>
                            <label class="block text-sm font-semibold text-blue-900 mb-2">⭐ Catatan Khusus</label>
                            <textarea name="notes_special" rows="3"
                                class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                placeholder="Info tambahan: VIP, perlu follow-up khusus, budget terbatas, urgent, dsb">{{ old('notes_special') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex flex-col md:flex-row gap-4 px-4 sm:px-0">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-yellow-400 to-yellow-500 text-blue-900 font-bold py-3 rounded-lg hover:from-yellow-500 hover:to-yellow-600 transition shadow-lg">
                        ✓ Simpan Prospek Baru
                    </button>
                    <a href="{{ route('marketing.leads.index') }}" class="flex-1 bg-white border border-blue-300 text-blue-900 font-bold py-3 rounded-lg hover:bg-blue-50 transition text-center">
                        ← Batal / Kembali
                    </a>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
