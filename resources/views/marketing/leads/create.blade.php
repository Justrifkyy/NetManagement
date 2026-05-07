<x-app-layout>
    <div class="py-10 bg-slate-950 min-h-screen selection:bg-sky-500/30">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="fade-in">
                    <a href="{{ route('marketing.leads.index') }}" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-white transition-colors mb-4 group">
                        <svg class="w-4 h-4 mr-1.5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali ke Pipeline
                    </a>
                    <h1 class="text-4xl font-black text-white tracking-tighter">Entry <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-400 to-indigo-400">Prospek Baru</span></h1>
                    <p class="text-slate-400 mt-2 font-medium">Lengkapi parameter data calon pelanggan untuk inisiasi proses survey.</p>
                </div>
            </div>

            @if ($errors->any())
                <div class="mb-8 p-5 bg-rose-500/10 border border-rose-500/20 rounded-[2rem] flex items-start gap-4">
                    <div class="p-2 bg-rose-500 rounded-xl text-white shadow-[0_0_15px_rgba(225,29,72,0.4)]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div>
                        <p class="text-rose-400 font-black text-xs uppercase tracking-widest mb-2">Terdapat Kendala Input:</p>
                        <ul class="list-disc ml-4 text-sm text-rose-300/80 space-y-1 font-medium">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('marketing.leads.store') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                @csrf

                <div class="bg-slate-900/80 backdrop-blur-md rounded-[2.5rem] shadow-2xl border border-slate-800 overflow-hidden relative">
                    <div class="absolute -right-20 -top-20 w-72 h-72 bg-sky-500/5 rounded-full blur-3xl pointer-events-none"></div>
                    <div class="bg-gradient-to-r from-sky-600/20 to-transparent px-10 py-6 border-b border-slate-800/60 flex items-center gap-4">
                        <div class="p-2.5 bg-sky-500 rounded-2xl shadow-[0_0_20px_rgba(14,165,233,0.3)] text-slate-950">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <h2 class="text-xl font-black text-white tracking-tight uppercase">Data Identitas Pelanggan</h2>
                    </div>

                    <div class="p-10 space-y-8">
                        <div x-data="{ customerType: '{{ old('customer_type', 'personal') }}' }" class="space-y-4">
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Kategori Akun <span class="text-rose-500">*</span></label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="relative flex items-center p-5 cursor-pointer bg-slate-800/30 border-2 rounded-2xl transition-all duration-300 group overflow-hidden"
                                    :class="customerType == 'personal' ? 'border-sky-500 bg-sky-500/5' : 'border-slate-700 hover:border-slate-600'">
                                    <input type="radio" name="customer_type" value="personal" x-model="customerType" class="hidden">
                                    <div class="w-5 h-5 rounded-full border-2 border-slate-600 flex items-center justify-center" :class="customerType == 'personal' ? 'border-sky-500' : ''">
                                        <div class="w-2.5 h-2.5 rounded-full bg-sky-500 transition-opacity" :class="customerType == 'personal' ? 'opacity-100' : 'opacity-0'"></div>
                                    </div>
                                    <span class="ml-4 font-bold uppercase text-xs tracking-widest transition-colors" :class="customerType == 'personal' ? 'text-sky-400' : 'text-slate-400'">Perorangan (Residensial)</span>
                                </label>
                                <label class="relative flex items-center p-5 cursor-pointer bg-slate-800/30 border-2 rounded-2xl transition-all duration-300 group overflow-hidden"
                                    :class="customerType == 'business' ? 'border-sky-500 bg-sky-500/5' : 'border-slate-700 hover:border-slate-600'">
                                    <input type="radio" name="customer_type" value="business" x-model="customerType" class="hidden">
                                    <div class="w-5 h-5 rounded-full border-2 border-slate-600 flex items-center justify-center" :class="customerType == 'business' ? 'border-sky-500' : ''">
                                        <div class="w-2.5 h-2.5 rounded-full bg-sky-500 transition-opacity" :class="customerType == 'business' ? 'opacity-100' : 'opacity-0'"></div>
                                    </div>
                                    <span class="ml-4 font-bold uppercase text-xs tracking-widest transition-colors" :class="customerType == 'business' ? 'text-sky-400' : 'text-slate-400'">Bisnis / Instansi (Corporate)</span>
                                </label>
                            </div>

                            <div x-show="customerType == 'business'" class="mt-6 space-y-2 animate-fade-in">
                                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Nama Usaha / Perusahaan</label>
                                <input type="text" name="business_name" value="{{ old('business_name') }}" placeholder="PT. Nama Perusahaan"
                                    class="w-full px-5 py-4 bg-slate-800/50 border border-slate-700 text-white rounded-2xl focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition-all">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Nama Lengkap (Sesuai KTP) <span class="text-rose-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" required placeholder="Masukkan nama lengkap pelanggan"
                                class="w-full px-5 py-4 bg-slate-800/50 border border-slate-700 text-white rounded-2xl focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition-all font-bold">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] ml-1">WhatsApp Utama <span class="text-rose-500">*</span></label>
                                <input type="text" name="phone" value="{{ old('phone') }}" required placeholder="0812..."
                                    class="w-full px-5 py-4 bg-slate-800/50 border border-slate-700 text-white rounded-2xl focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition-all font-mono tracking-wider">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Nomor Cadangan</label>
                                <input type="text" name="phone_backup" value="{{ old('phone_backup') }}" placeholder="08..."
                                    class="w-full px-5 py-4 bg-slate-800/50 border border-slate-700 text-white rounded-2xl focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition-all font-mono tracking-wider">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="pelanggan@email.com"
                                    class="w-full px-5 py-4 bg-slate-800/50 border border-slate-700 text-white rounded-2xl focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Nama Ibu Kandung</label>
                                <input type="text" name="mother_name" value="{{ old('mother_name') }}" placeholder="Untuk verifikasi keamanan"
                                    class="w-full px-5 py-4 bg-slate-800/50 border border-slate-700 text-white rounded-2xl focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition-all">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6 border-t border-slate-800/60">
                            <div class="space-y-2">
                                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Berkas Identitas (KTP)</label>
                                <div class="relative group">
                                    <input type="file" name="ktp_image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                    <div class="p-4 bg-slate-800/50 border-2 border-dashed border-slate-700 rounded-2xl flex flex-col items-center justify-center group-hover:border-sky-500/50 transition-colors">
                                        <svg class="w-6 h-6 text-slate-500 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                                        <span class="text-[10px] font-bold text-slate-500 uppercase">Upload KTP</span>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Dokumentasi Lokasi</label>
                                <div class="relative group">
                                    <input type="file" name="house_image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                    <div class="p-4 bg-slate-800/50 border-2 border-dashed border-slate-700 rounded-2xl flex flex-col items-center justify-center group-hover:border-sky-500/50 transition-colors">
                                        <svg class="w-6 h-6 text-slate-500 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                        <span class="text-[10px] font-bold text-slate-500 uppercase">Foto Lokasi</span>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Foto Calon Pelanggan</label>
                                <div class="relative group">
                                    <input type="file" name="customer_image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                    <div class="p-4 bg-slate-800/50 border-2 border-dashed border-slate-700 rounded-2xl flex flex-col items-center justify-center group-hover:border-sky-500/50 transition-colors">
                                        <svg class="w-6 h-6 text-slate-500 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        <span class="text-[10px] font-bold text-slate-500 uppercase">Upload Wajah</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-900/80 backdrop-blur-md rounded-[2.5rem] shadow-2xl border border-slate-800 overflow-hidden relative">
                    <div class="bg-gradient-to-r from-indigo-600/20 to-transparent px-10 py-6 border-b border-slate-800/60 flex items-center gap-4">
                        <div class="p-2.5 bg-indigo-500 rounded-2xl shadow-[0_0_20px_rgba(79,70,229,0.3)] text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <h2 class="text-xl font-black text-white tracking-tight uppercase">Penempatan Lokasi</h2>
                    </div>
                    <div class="p-10 space-y-8">
                        <div class="space-y-2">
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Alamat Pemasangan <span class="text-rose-500">*</span></label>
                            <textarea name="address" rows="3" required placeholder="Isikan alamat lengkap penarikan jaringan"
                                class="w-full px-5 py-4 bg-slate-800/50 border border-slate-700 text-white rounded-2xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all">{{ old('address') }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            <div class="space-y-2">
                                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">RT/RW</label>
                                <input type="text" name="rt_rw" value="{{ old('rt_rw') }}" placeholder="00/00"
                                    class="w-full px-5 py-4 bg-slate-800/50 border border-slate-700 text-white rounded-2xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Kelurahan <span class="text-rose-500">*</span></label>
                                <input type="text" name="village" value="{{ old('village') }}" required
                                    class="w-full px-5 py-4 bg-slate-800/50 border border-slate-700 text-white rounded-2xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Kecamatan <span class="text-rose-500">*</span></label>
                                <input type="text" name="district" value="{{ old('district') }}" required
                                    class="w-full px-5 py-4 bg-slate-800/50 border border-slate-700 text-white rounded-2xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all">
                            </div>
                        </div>

                        <div class="space-y-2 text-center sm:text-left">
                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Titik Koordinat (Google Maps)</label>
                            <input type="text" name="coordinates" value="{{ old('coordinates') }}" placeholder="-6.123, 106.123"
                                class="w-full px-5 py-4 bg-slate-800/50 border border-slate-700 text-sky-400 rounded-2xl focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition-all font-mono tracking-widest">
                        </div>
                    </div>
                </div>

                <div class="bg-slate-900/80 backdrop-blur-md rounded-[2.5rem] shadow-2xl border border-slate-800 overflow-hidden">
                    <div class="bg-gradient-to-r from-amber-600/20 to-transparent px-10 py-6 border-b border-slate-800/60 flex items-center gap-4">
                        <div class="p-2.5 bg-amber-500 rounded-2xl shadow-[0_0_20px_rgba(245,158,11,0.3)] text-slate-950">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <h2 class="text-xl font-black text-white tracking-tight uppercase">Paket Layanan</h2>
                    </div>
                    <div class="p-10 space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Pilih Produk <span class="text-rose-500">*</span></label>
                                <select name="package_id" required class="w-full px-5 py-4 bg-slate-800/50 border border-slate-700 text-white rounded-2xl focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 appearance-none cursor-pointer font-bold">
                                    <option value="" class="bg-slate-900">-- Klik untuk memilih paket --</option>
                                    @foreach ($packages as $package)
                                        <option value="{{ $package->id }}" @selected(old('package_id') == $package->id) class="bg-slate-900">
                                            {{ $package->name }} - Rp {{ number_format($package->price, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Biaya Registrasi/OTC</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none font-bold text-slate-500">Rp</div>
                                    <input type="number" name="installation_fee" value="{{ old('installation_fee', 0) }}"
                                        class="w-full pl-12 pr-5 py-4 bg-slate-800/50 border border-slate-700 text-amber-400 rounded-2xl focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition-all font-bold">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-900/80 backdrop-blur-md rounded-[2.5rem] shadow-2xl border border-slate-800 overflow-hidden relative">
                    <div class="p-10">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Inisiasi Status <span class="text-rose-500">*</span></label>
                                <select name="status" required class="w-full px-5 py-4 bg-slate-800/50 border border-slate-700 text-white rounded-2xl focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 font-bold">
                                    <option value="prospek" @selected(old('status', 'prospek') == 'prospek')>New Prospect</option>
                                    <option value="survey" @selected(old('status') == 'survey')>Ready to Survey</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Lead Source <span class="text-rose-500">*</span></label>
                                <select name="source" required class="w-full px-5 py-4 bg-slate-800/50 border border-slate-700 text-white rounded-2xl focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 font-bold">
                                    <option value="" class="bg-slate-900">-- Pilih Sumber --</option>
                                    <option value="iklan" class="bg-slate-900">Digital Ads (FB/IG/Google)</option>
                                    <option value="referensi" class="bg-slate-900">Referensi Teman</option>
                                    <option value="sosial_media" class="bg-slate-900">Organic Social Media</option>
                                    <option value="walk_in" class="bg-slate-900">Walk-in Customer</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row gap-4">
                    <button type="submit" class="flex-[2] px-8 py-5 bg-sky-600 text-white font-black rounded-3xl shadow-[0_0_25px_rgba(14,165,233,0.3)] hover:bg-sky-500 hover:shadow-[0_0_35px_rgba(14,165,233,0.5)] transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-3 text-lg tracking-tight uppercase">
                        Selesaikan & Simpan Prospek
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                    <a href="{{ route('marketing.leads.index') }}" class="flex-1 px-8 py-5 bg-slate-900 text-slate-400 font-bold rounded-3xl border border-slate-800 hover:bg-slate-800 hover:text-white transition-all duration-300 flex items-center justify-center text-lg text-center leading-none">
                        Batal
                    </a>
                </div>

            </form>

            <div class="mt-12 text-center">
                <p class="text-[10px] font-black text-slate-600 uppercase tracking-[0.3em]">
                    Quality Sales Input &bull; PT. Mandiri Global Data &bull; 2026
                </p>
            </div>
        </div>
    </div>
</x-app-layout>