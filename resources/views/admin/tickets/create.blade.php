<x-app-layout>
    <div class="py-10 bg-slate-950 min-h-screen selection:bg-purple-500/30">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <a href="{{ route('admin.tickets.index') }}" class="inline-flex items-center text-sm font-semibold text-slate-400 hover:text-white transition-colors mb-4 group">
                    <svg class="w-4 h-4 mr-1.5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Batal
                </a>
                <h2 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-white to-slate-400 tracking-tight">Buat Tiket Baru</h2>
            </div>

            <div class="bg-slate-900/80 backdrop-blur-md rounded-2xl shadow-xl border border-slate-800 p-6 sm:p-8">
                <form action="{{ route('admin.tickets.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-300 mb-2">Pelanggan <span class="text-rose-500">*</span></label>
                            <select name="customer_id" required class="w-full px-4 py-3 bg-slate-800/50 text-slate-100 border border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500 transition-all appearance-none cursor-pointer">
                                <option value="" disabled selected class="bg-slate-800 text-slate-500">Pilih Pelanggan Terdaftar</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" class="bg-slate-800">{{ $customer->user->name }} - {{ $customer->phone_number }}</option>
                                @endforeach
                            </select>
                            @error('customer_id') <p class="text-rose-400 text-xs font-medium mt-1.5">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-300 mb-2">Tipe Tiket <span class="text-rose-500">*</span></label>
                            <select name="type" required class="w-full px-4 py-3 bg-slate-800/50 text-slate-100 border border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500 transition-all appearance-none cursor-pointer">
                                <option value="" disabled selected class="bg-slate-800 text-slate-500">Pilih Tipe Pekerjaan</option>
                                <option value="survey" class="bg-slate-800">Survey Lokasi</option>
                                <option value="installation" class="bg-slate-800">Instalasi Baru</option>
                                <option value="repair" class="bg-slate-800">Perbaikan / Gangguan</option>
                            </select>
                            @error('type') <p class="text-rose-400 text-xs font-medium mt-1.5">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-300 mb-2">Subjek Pekerjaan <span class="text-rose-500">*</span></label>
                        <input type="text" name="subject" required placeholder="Contoh: Survey Lokasi Pemasangan Baru, atau Kabel Putus..."
                            class="w-full px-4 py-3 bg-slate-800/50 text-slate-100 border border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500 transition-all placeholder-slate-500">
                        @error('subject') <p class="text-rose-400 text-xs font-medium mt-1.5">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-300 mb-2">Status Awal <span class="text-rose-500">*</span></label>
                            <select name="status" required class="w-full px-4 py-3 bg-slate-800/50 text-slate-100 border border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500 transition-all appearance-none cursor-pointer">
                                <option value="open" class="bg-slate-800">Buka (Open)</option>
                                <option value="assigned" class="bg-slate-800">Langsung Tugaskan</option>
                                <option value="in_progress" class="bg-slate-800">Sedang Dikerjakan</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-300 mb-2">Tugaskan ke Teknisi (Opsional)</label>
                            <select name="technician_id" class="w-full px-4 py-3 bg-slate-800/50 text-slate-100 border border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500 transition-all appearance-none cursor-pointer">
                                <option value="" class="bg-slate-800">Belum Ditugaskan / Biarkan Kosong</option>
                                @foreach ($technicians as $tech)
                                    <option value="{{ $tech->id }}" class="bg-slate-800">{{ $tech->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-300 mb-2">Catatan Tambahan untuk Teknisi (Opsional)</label>
                        <textarea name="notes" rows="4" placeholder="Detail lokasi rumah, waktu janji temu pelanggan..."
                            class="w-full px-4 py-3 bg-slate-800/50 text-slate-100 border border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500 transition-all placeholder-slate-500 resize-y"></textarea>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-slate-800/60 mt-8">
                        <button type="submit" class="px-8 py-3 bg-purple-600 text-white font-bold rounded-xl hover:bg-purple-500 shadow-[0_0_15px_rgba(147,51,234,0.3)] hover:shadow-[0_0_20px_rgba(147,51,234,0.5)] transition-all duration-200">
                            Terbitkan Tiket
                        </button>
                        <a href="{{ route('admin.tickets.index') }}" class="px-8 py-3 bg-slate-800 text-slate-300 font-bold rounded-xl border border-slate-700 hover:bg-slate-700 hover:text-white transition-all text-center">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>