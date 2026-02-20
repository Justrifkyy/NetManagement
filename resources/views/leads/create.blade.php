<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrasi Prospek Baru') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-sky-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div
                class="bg-gradient-to-r from-sky-600 to-blue-700 rounded-t-2xl p-6 shadow-lg text-white flex justify-between items-center">
                <div>
                    <h3 class="text-2xl font-bold">Input Data Pelanggan</h3>
                    <p class="text-sky-100 text-sm mt-1">Lengkapi formulir di bawah ini dengan data valid.</p>
                </div>
                <div class="bg-white/20 p-3 rounded-full">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                        </path>
                    </svg>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl rounded-b-2xl border border-gray-100 p-8">

                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r-md">
                        <ul class="list-disc ml-8 text-sm mt-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('marketing.leads.store') }}" method="POST" enctype="multipart/form-data"
                    x-data="{ customerType: 'personal' }">
                    @csrf

                    <div class="mb-8">
                        <h4 class="text-sky-700 font-bold text-lg border-b border-gray-100 pb-2 mb-4 flex items-center">
                            <span
                                class="bg-sky-100 text-sky-700 w-6 h-6 rounded-full flex items-center justify-center text-xs mr-2">1</span>
                            Identitas & Kontak
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div class="md:col-span-2">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Jenis Pelanggan</label>
                                <div class="flex gap-4">
                                    <label
                                        class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-sky-50 transition w-full md:w-auto"
                                        :class="customerType == 'personal' ? 'border-sky-500 bg-sky-50 ring-1 ring-sky-500' :
                                            'border-gray-200'">
                                        <input type="radio" name="customer_type" value="personal"
                                            x-model="customerType" class="text-sky-600 focus:ring-sky-500">
                                        <span class="ml-2 font-semibold text-gray-700">Perorangan</span>
                                    </label>
                                    <label
                                        class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-sky-50 transition w-full md:w-auto"
                                        :class="customerType == 'business' ? 'border-sky-500 bg-sky-50 ring-1 ring-sky-500' :
                                            'border-gray-200'">
                                        <input type="radio" name="customer_type" value="business"
                                            x-model="customerType" class="text-sky-600 focus:ring-sky-500">
                                        <span class="ml-2 font-semibold text-gray-700">Bisnis / Usaha</span>
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label class="block text-gray-600 text-sm font-semibold mb-1">Nama Lengkap (Sesuai KTP)
                                    <span class="text-red-500">*</span></label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                    class="w-full border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500"
                                    placeholder="Contoh: Budi Santoso" required>
                            </div>

                            <div x-show="customerType == 'business'" x-transition>
                                <label class="block text-gray-600 text-sm font-semibold mb-1">Nama
                                    Usaha/Instansi</label>
                                <input type="text" name="business_name" value="{{ old('business_name') }}"
                                    class="w-full border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500"
                                    placeholder="Contoh: PT. Maju Jaya">
                            </div>

                            <div>
                                <label class="block text-gray-600 text-sm font-semibold mb-1">Nama Ibu Kandung</label>
                                <input type="text" name="mother_name" value="{{ old('mother_name') }}"
                                    class="w-full border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500"
                                    placeholder="Untuk verifikasi data">
                            </div>

                            <div>
                                <label class="block text-gray-600 text-sm font-semibold mb-1">No. HP Utama (WA) <span
                                        class="text-red-500">*</span></label>
                                <input type="number" name="phone" value="{{ old('phone') }}"
                                    class="w-full border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500"
                                    placeholder="08..." required>
                            </div>
                            <div>
                                <label class="block text-gray-600 text-sm font-semibold mb-1">Email (Opsional)</label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="w-full border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500"
                                    placeholder="email@contoh.com">
                            </div>
                        </div>
                    </div>

                    <div class="mb-8 bg-orange-50 p-6 rounded-xl border border-orange-100">
                        <h4
                            class="text-orange-800 font-bold text-lg border-b border-orange-200 pb-2 mb-4 flex items-center">
                            <span
                                class="bg-orange-200 text-orange-800 w-6 h-6 rounded-full flex items-center justify-center text-xs mr-2">2</span>
                            Kontak Darurat (Wajib Diisi)
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-gray-600 text-sm font-semibold mb-1">Nama Pemilik
                                    Kontak</label>
                                <input type="text" name="emergency_name" value="{{ old('emergency_name') }}"
                                    class="w-full border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500">
                            </div>
                            <div>
                                <label class="block text-gray-600 text-sm font-semibold mb-1">Nomor HP Darurat</label>
                                <input type="number" name="emergency_phone" value="{{ old('emergency_phone') }}"
                                    class="w-full border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500"
                                    placeholder="08...">
                            </div>
                            <div>
                                <label class="block text-gray-600 text-sm font-semibold mb-1">Hubungan</label>
                                <select name="emergency_relation"
                                    class="w-full border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500">
                                    <option value="">- Pilih Hubungan -</option>
                                    <option value="Orang Tua">Orang Tua</option>
                                    <option value="Suami/Istri">Suami / Istri</option>
                                    <option value="Saudara">Saudara Kandung</option>
                                    <option value="Kerabat">Kerabat Lain</option>
                                    <option value="Tetangga">Tetangga / Teman</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h4
                            class="text-sky-700 font-bold text-lg border-b border-gray-100 pb-2 mb-4 flex items-center">
                            <span
                                class="bg-sky-100 text-sky-700 w-6 h-6 rounded-full flex items-center justify-center text-xs mr-2">3</span>
                            Detail Lokasi
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                            <div>
                                <label class="block text-gray-600 text-sm font-semibold mb-1">Alamat Sesuai KTP</label>
                                <textarea name="address_ktp" rows="3"
                                    class="w-full border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500"
                                    placeholder="Jalan, No Rumah, RT/RW (Sesuai KTP)">{{ old('address_ktp') }}</textarea>
                            </div>
                            <div>
                                <label class="block text-gray-600 text-sm font-semibold mb-1">Alamat Pemasangan
                                    (Domisili) <span class="text-red-500">*</span></label>
                                <textarea name="address_installation" rows="3"
                                    class="w-full border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500" required
                                    placeholder="Lokasi perangkat akan dipasang...">{{ old('address_installation') }}</textarea>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-gray-600 text-sm font-semibold mb-1">RT / RW</label>
                                <input type="text" name="rt_rw" value="{{ old('rt_rw') }}"
                                    class="w-full border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500"
                                    placeholder="001/005">
                            </div>
                            <div>
                                <label class="block text-gray-600 text-sm font-semibold mb-1">Kelurahan / Desa</label>
                                <input type="text" name="village" value="{{ old('village') }}"
                                    class="w-full border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500">
                            </div>
                            <div>
                                <label class="block text-gray-600 text-sm font-semibold mb-1">Kecamatan <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="district" value="{{ old('district') }}"
                                    class="w-full border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500"
                                    required>
                            </div>
                            <div>
                                <label class="block text-gray-600 text-sm font-semibold mb-1">Kota / Kabupaten <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="city" value="{{ old('city') }}"
                                    class="w-full border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500"
                                    required>
                            </div>
                            <div>
                                <label class="block text-gray-600 text-sm font-semibold mb-1">Provinsi</label>
                                <input type="text" name="province" value="{{ old('province') }}"
                                    class="w-full border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500">
                            </div>
                            <div>
                                <label class="block text-gray-600 text-sm font-semibold mb-1">Kode Pos</label>
                                <input type="number" name="postal_code" value="{{ old('postal_code') }}"
                                    class="w-full border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500">
                            </div>
                            <div class="md:col-span-3">
                                <label class="block text-gray-600 text-sm font-semibold mb-1">Patokan Lokasi
                                    (Landmark)</label>
                                <input type="text" name="landmark" value="{{ old('landmark') }}"
                                    class="w-full border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500"
                                    placeholder="Contoh: Depan Masjid Al-Muhajirin, Pagar Hitam">
                            </div>
                            <div class="md:col-span-3">
                                <label class="block text-gray-600 text-sm font-semibold mb-1">Titik Koordinat (Google
                                    Maps)</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" name="coordinates" value="{{ old('coordinates') }}"
                                        class="w-full pl-10 border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500"
                                        placeholder="-5.12345, 119.54321">
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Salin koordinat lat,long dari Google Maps.</p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h4
                            class="text-sky-700 font-bold text-lg border-b border-gray-100 pb-2 mb-4 flex items-center">
                            <span
                                class="bg-sky-100 text-sky-700 w-6 h-6 rounded-full flex items-center justify-center text-xs mr-2">4</span>
                            Paket Internet
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-gray-600 text-sm font-semibold mb-1">Pilih Paket <span
                                        class="text-red-500">*</span></label>
                                <select name="package_id"
                                    class="w-full border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500"
                                    required>
                                    <option value="">-- Pilih Paket Layanan --</option>
                                    @foreach ($packages as $pkg)
                                        <option value="{{ $pkg->id }}"
                                            {{ old('package_id') == $pkg->id ? 'selected' : '' }}>
                                            {{ $pkg->name }} - {{ $pkg->speed_mbps }} Mbps (Rp
                                            {{ number_format($pkg->price, 0, ',', '.') }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-600 text-sm font-semibold mb-1">Kode Promo</label>
                                <input type="text" name="promo_code" value="{{ old('promo_code') }}"
                                    class="w-full border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500"
                                    placeholder="Jika ada">
                            </div>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h4
                            class="text-sky-700 font-bold text-lg border-b border-gray-100 pb-2 mb-4 flex items-center">
                            <span
                                class="bg-sky-100 text-sky-700 w-6 h-6 rounded-full flex items-center justify-center text-xs mr-2">5</span>
                            Status & Jadwal
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-600 text-sm font-semibold mb-1">Status Prospek</label>
                                <select name="status"
                                    class="w-full border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500">
                                    <option value="prospek">Prospek Baru</option>
                                    <option value="survey">Menunggu Survey</option>
                                    <option value="instalasi">Menunggu Instalasi</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-600 text-sm font-semibold mb-1">Sumber Pelanggan</label>
                                <select name="source"
                                    class="w-full border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500">
                                    <option value="">- Pilih Sumber -</option>
                                    <option value="Iklan">Iklan / Ads</option>
                                    <option value="Sosmed">Sosial Media</option>
                                    <option value="Referensi">Referensi Teman/Keluarga</option>
                                    <option value="Brosur">Brosur / Spanduk</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-600 text-sm font-semibold mb-1">Rencana Tanggal
                                    Survey/Pasang</label>
                                <input type="date" name="survey_date" value="{{ old('survey_date') }}"
                                    class="w-full border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500">
                            </div>
                            <div>
                                <label class="block text-gray-600 text-sm font-semibold mb-1">Waktu Diinginkan
                                    Pelanggan</label>
                                <input type="text" name="preferred_time" value="{{ old('preferred_time') }}"
                                    class="w-full border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500"
                                    placeholder="Misal: Siang jam 14.00 atau Hari Libur">
                            </div>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h4
                            class="text-sky-700 font-bold text-lg border-b border-gray-100 pb-2 mb-4 flex items-center">
                            <span
                                class="bg-sky-100 text-sky-700 w-6 h-6 rounded-full flex items-center justify-center text-xs mr-2">6</span>
                            Catatan Internal
                        </h4>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-gray-600 text-sm font-semibold mb-1">Ringkasan
                                    Komunikasi</label>
                                <textarea name="notes_summary" rows="2"
                                    class="w-full border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500"
                                    placeholder="Catatan hasil pembicaraan dengan pelanggan...">{{ old('notes_summary') }}</textarea>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-gray-600 text-sm font-semibold mb-1">Kendala /
                                        Hambatan</label>
                                    <textarea name="notes_obstacle" rows="2"
                                        class="w-full border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500"
                                        placeholder="Misal: Ragu harga, menunggu persetujuan suami...">{{ old('notes_obstacle') }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-gray-600 text-sm font-semibold mb-1">Catatan
                                        Khusus</label>
                                    <textarea name="notes_special" rows="2"
                                        class="w-full border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500"
                                        placeholder="Misal: Kabel harus rapi, ada anjing galak...">{{ old('notes_special') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h4
                            class="text-sky-700 font-bold text-lg border-b border-gray-100 pb-2 mb-4 flex items-center">
                            <span
                                class="bg-sky-100 text-sky-700 w-6 h-6 rounded-full flex items-center justify-center text-xs mr-2">7</span>
                            Dokumentasi Foto
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                            <div
                                class="border-2 border-dashed border-sky-200 rounded-xl p-4 text-center hover:bg-sky-50 transition bg-white">
                                <label class="cursor-pointer block">
                                    <span class="block text-sm font-bold text-gray-700 mb-2">Foto KTP (Wajib)</span>
                                    <div class="h-24 flex items-center justify-center mb-2">
                                        <svg class="w-10 h-10 text-sky-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                            </path>
                                        </svg>
                                    </div>
                                    <input type="file" name="ktp_image" accept="image/*"
                                        class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-2 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-sky-100 file:text-sky-700 hover:file:bg-sky-200" />
                                </label>
                            </div>

                            <div
                                class="border-2 border-dashed border-sky-200 rounded-xl p-4 text-center hover:bg-sky-50 transition bg-white">
                                <label class="cursor-pointer block">
                                    <span class="block text-sm font-bold text-gray-700 mb-2">Foto Rumah Depan</span>
                                    <div class="h-24 flex items-center justify-center mb-2">
                                        <svg class="w-10 h-10 text-sky-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                            </path>
                                        </svg>
                                    </div>
                                    <input type="file" name="house_image" accept="image/*"
                                        class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-2 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-sky-100 file:text-sky-700 hover:file:bg-sky-200" />
                                </label>
                            </div>

                            <div
                                class="border-2 border-dashed border-sky-200 rounded-xl p-4 text-center hover:bg-sky-50 transition bg-white">
                                <label class="cursor-pointer block">
                                    <span class="block text-sm font-bold text-gray-700 mb-2">Foto Pelanggan</span>
                                    <div class="h-24 flex items-center justify-center mb-2">
                                        <svg class="w-10 h-10 text-sky-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                            </path>
                                        </svg>
                                    </div>
                                    <input type="file" name="customer_image" accept="image/*"
                                        class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-2 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-sky-100 file:text-sky-700 hover:file:bg-sky-200" />
                                </label>
                            </div>

                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-4 border-t border-gray-100 pt-6">
                        <a href="{{ route('marketing.leads.index') }}"
                            class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg font-bold hover:bg-gray-200 transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-8 py-3 bg-gradient-to-r from-sky-600 to-blue-700 text-white rounded-lg font-bold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition duration-200 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                                </path>
                            </svg>
                            Simpan Data Prospek
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
