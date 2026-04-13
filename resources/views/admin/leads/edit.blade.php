<x-app-layout>
    <div class="py-10 bg-slate-950 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <a href="{{ route('admin.leads.index') }}" class="text-amber-400 hover:text-amber-300 font-medium">← Kembali</a>
                <h2 class="text-3xl font-extrabold text-white mt-2">Edit Lead</h2>
            </div>

            <div class="bg-slate-900 rounded-xl shadow-sm border border-slate-800 p-8">
                <form action="{{ route('admin.leads.update', $lead) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Info Pelanggan -->
                    <div class="border-b border-slate-800 pb-6">
                        <h3 class="text-lg font-bold text-white mb-4">Informasi Pelanggan</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-white mb-2">Nama Pelanggan <span class="text-red-600">*</span></label>
                                <input type="text" name="name" value="{{ $lead->name }}" required
                                    class="w-full px-4 py-3 border border-slate-700 rounded-lg bg-slate-800 text-white focus:outline-none focus:ring-2 focus:ring-amber-500">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-white mb-2">No. Telepon <span class="text-red-600">*</span></label>
                                <input type="tel" name="phone" value="{{ $lead->phone }}" required
                                    class="w-full px-4 py-3 border border-slate-700 rounded-lg bg-slate-800 text-white focus:outline-none focus:ring-2 focus:ring-amber-500">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-white mb-2">Email</label>
                                <input type="email" name="email" value="{{ $lead->email }}"
                                    class="w-full px-4 py-3 border border-slate-700 rounded-lg bg-slate-800 text-white focus:outline-none focus:ring-2 focus:ring-amber-500">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-white mb-2">Jenis Pelanggan</label>
                                <select name="customer_type"
                                    class="w-full px-4 py-3 border border-slate-700 rounded-lg bg-slate-800 text-white focus:outline-none focus:ring-2 focus:ring-amber-500">
                                    <option value="residential" @selected($lead->customer_type === 'residential')>Residensial</option>
                                    <option value="business" @selected($lead->customer_type === 'business')>Bisnis</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-white mb-2">Nama Ibu</label>
                                <input type="text" name="mother_name" value="{{ $lead->mother_name }}"
                                    class="w-full px-4 py-3 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-white mb-2">Nama Bisnis</label>
                                <input type="text" name="business_name" value="{{ $lead->business_name }}"
                                    class="w-full px-4 py-3 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500">
                            </div>
                        </div>

                        <div class="mt-6">
                            <label class="block text-sm font-semibold text-white mb-2">Alamat KTP</label>
                            <textarea name="address_ktp" rows="2"
                                class="w-full px-4 py-3 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500">{{ $lead->address_ktp }}</textarea>
                        </div>

                        <div class="mt-6">
                            <label class="block text-sm font-semibold text-white mb-2">Alamat Instalasi</label>
                            <textarea name="address_installation" rows="2"
                                class="w-full px-4 py-3 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500">{{ $lead->address_installation }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-6">
                            <div>
                                <label class="block text-sm font-semibold text-white mb-2">RT/RW</label>
                                <input type="text" name="rt_rw" value="{{ $lead->rt_rw }}"
                                    class="w-full px-4 py-3 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-white mb-2">Kelurahan</label>
                                <input type="text" name="village" value="{{ $lead->village }}"
                                    class="w-full px-4 py-3 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-white mb-2">Kecamatan</label>
                                <input type="text" name="district" value="{{ $lead->district }}"
                                    class="w-full px-4 py-3 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-white mb-2">Kota</label>
                                <input type="text" name="city" value="{{ $lead->city }}"
                                    class="w-full px-4 py-3 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500">
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Layanan -->
                    <div class="border-b border-slate-800 pb-6">
                        <h3 class="text-lg font-bold text-white mb-4">Informasi Layanan</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-white mb-2">Paket <span class="text-red-600">*</span></label>
                                <select name="package_id" required
                                    class="w-full px-4 py-3 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500">
                                    <option value="">Pilih Paket</option>
                                    @foreach ($packages as $pkg)
                                        <option value="{{ $pkg->id }}" @selected($lead->package_id === $pkg->id)>
                                            {{ $pkg->name }} - Rp. {{ number_format($pkg->price, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-white mb-2">Status</label>
                                <select name="status"
                                    class="w-full px-4 py-3 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500">
                                    <option value="prospect" @selected($lead->status === 'prospect')>Prospek</option>
                                    <option value="contacted" @selected($lead->status === 'contacted')>Sudah Dihubungi</option>
                                    <option value="qualified" @selected($lead->status === 'qualified')>Qualified</option>
                                    <option value="proposal_sent" @selected($lead->status === 'proposal_sent')>Penawaran Dikirim</option>
                                    <option value="negotiation" @selected($lead->status === 'negotiation')>Negosiasi</option>
                                    <option value="converted" @selected($lead->status === 'converted')>Konversi</option>
                                    <option value="lost" @selected($lead->status === 'lost')>Hilang</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-white mb-2">Kode Promo</label>
                                <input type="text" name="promo_code" value="{{ $lead->promo_code }}"
                                    class="w-full px-4 py-3 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-white mb-2">Sumber Lead</label>
                                <select name="source"
                                    class="w-full px-4 py-3 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500">
                                    <option value="online" @selected($lead->source === 'online')>Online</option>
                                    <option value="offline" @selected($lead->source === 'offline')>Offline</option>
                                    <option value="referral" @selected($lead->source === 'referral')>Referral</option>
                                    <option value="cold_call" @selected($lead->source === 'cold_call')>Cold Call</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                            <div>
                                <label class="block text-sm font-semibold text-white mb-2">Tanggal Survey</label>
                                <input type="date" name="survey_date" value="{{ $lead->survey_date }}"
                                    class="w-full px-4 py-3 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-white mb-2">Jam Preferred</label>
                                <input type="time" name="preferred_time" value="{{ $lead->preferred_time }}"
                                    class="w-full px-4 py-3 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500">
                            </div>
                        </div>

                        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-white mb-2">Catatan Ringkas</label>
                                <textarea name="notes_summary" rows="2"
                                    class="w-full px-4 py-3 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500">{{ $lead->notes_summary }}</textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-white mb-2">Catatan Hambatan</label>
                                <textarea name="notes_obstacle" rows="2"
                                    class="w-full px-4 py-3 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500">{{ $lead->notes_obstacle }}</textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-white mb-2">Catatan Khusus</label>
                                <textarea name="notes_special" rows="2"
                                    class="w-full px-4 py-3 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500">{{ $lead->notes_special }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-4 pt-4">
                        <button type="submit" class="px-6 py-3 bg-amber-600 text-white rounded-lg hover:bg-amber-700 font-medium">
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.leads.show', $lead) }}" class="px-6 py-3 border border-slate-700 rounded-lg hover:bg-slate-800 font-medium text-white">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
