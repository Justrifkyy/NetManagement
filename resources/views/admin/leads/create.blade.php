<x-app-layout>
    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <a href="{{ route('admin.leads.index') }}" class="text-blue-600 hover:text-blue-900 font-medium">← Kembali</a>
                <h2 class="text-3xl font-extrabold text-gray-900 mt-2">Buat Lead Baru</h2>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                <form action="{{ route('admin.leads.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Info Pelanggan -->
                    <div class="border-b border-gray-200 pb-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Pelanggan</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Nama Pelanggan <span class="text-red-600">*</span></label>
                                <input type="text" name="name" required placeholder="Nama lengkap"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">No. Telepon <span class="text-red-600">*</span></label>
                                <input type="tel" name="phone" required placeholder="08XXXX"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('phone') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Email</label>
                                <input type="email" name="email" placeholder="email@example.com"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Jenis Pelanggan</label>
                                <select name="customer_type"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Pilih Jenis</option>
                                    <option value="residential">Residensial</option>
                                    <option value="business">Bisnis</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Nama Ibu</label>
                                <input type="text" name="mother_name" placeholder="Nama ibu pelanggan"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Nama Bisnis</label>
                                <input type="text" name="business_name" placeholder="Nama bisnis (jika ada)"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        <div class="mt-6">
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Alamat KTP</label>
                            <textarea name="address_ktp" rows="2" placeholder="Alamat sesuai KTP"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>

                        <div class="mt-6">
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Alamat Instalasi</label>
                            <textarea name="address_installation" rows="2" placeholder="Alamat instalasi internet"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">RT/RW</label>
                                <input type="text" name="rt_rw" placeholder="01/02"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Kelurahan</label>
                                <input type="text" name="village"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Kecamatan</label>
                                <input type="text" name="district"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Kota</label>
                                <input type="text" name="city"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Layanan -->
                    <div class="border-b border-gray-200 pb-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Layanan</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Paket <span class="text-red-600">*</span></label>
                                <select name="package_id" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Pilih Paket</option>
                                    @foreach ($packages as $pkg)
                                        <option value="{{ $pkg->id }}">{{ $pkg->name }} - Rp. {{ number_format($pkg->price, 0, ',', '.') }}</option>
                                    @endforeach
                                </select>
                                @error('package_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Status</label>
                                <select name="status"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="prospect">Prospek</option>
                                    <option value="contacted">Sudah Dihubungi</option>
                                    <option value="qualified">Qualified</option>
                                    <option value="proposal_sent">Penawaran Dikirim</option>
                                    <option value="negotiation">Negosiasi</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Kode Promo</label>
                                <input type="text" name="promo_code" placeholder="Kode promo (jika ada)"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Sumber Lead</label>
                                <select name="source"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Pilih Sumber</option>
                                    <option value="online">Online</option>
                                    <option value="offline">Offline</option>
                                    <option value="referral">Referral</option>
                                    <option value="cold_call">Cold Call</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Tanggal Survey</label>
                                <input type="date" name="survey_date"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Jam Preferred</label>
                                <input type="time" name="preferred_time"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Catatan Ringkas</label>
                                <textarea name="notes_summary" rows="2"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Catatan Hambatan</label>
                                <textarea name="notes_obstacle" rows="2"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Catatan Khusus</label>
                                <textarea name="notes_special" rows="2"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-4 pt-4">
                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                            Buat Lead
                        </button>
                        <a href="{{ route('admin.leads.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 font-medium">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
