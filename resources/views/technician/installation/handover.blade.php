<x-app-layout>
    <div class="py-10 bg-slate-950 min-h-screen selection:bg-emerald-500/30">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="fade-in">
                    <a href="{{ route('technician.installation.show', $installation->id) }}" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-white transition-colors mb-4 group">
                        <svg class="w-4 h-4 mr-1.5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali ke Detail Instalasi
                    </a>
                    <h1 class="text-4xl font-black text-white tracking-tighter">Finalisasi <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-200">Handover</span></h1>
                    <p class="text-slate-400 mt-2 font-medium">Instalasi: <span class="text-emerald-400 font-bold underline decoration-emerald-500/30 underline-offset-4">{{ $installation->lead->name }}</span></p>
                </div>
            </div>

            @if ($errors->any())
                <div class="mb-8 p-5 bg-rose-500/10 border border-rose-500/20 rounded-[2rem] flex items-start gap-4">
                    <div class="p-2 bg-rose-500 rounded-xl text-white shadow-[0_0_15px_rgba(225,29,72,0.4)]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div>
                        <p class="text-rose-400 font-black text-xs uppercase tracking-widest mb-2">Kendala Finalisasi:</p>
                        <ul class="list-disc ml-4 text-sm text-rose-300/80 space-y-1 font-medium">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('technician.handover.store', $installation->id) }}" method="POST" class="space-y-8">
                @csrf

                <div class="bg-slate-900/80 backdrop-blur-md rounded-[2.5rem] shadow-2xl border border-slate-800 overflow-hidden relative">
                    <div class="absolute -right-20 -top-20 w-72 h-72 bg-emerald-500/5 rounded-full blur-3xl pointer-events-none"></div>

                    <div class="bg-gradient-to-r from-emerald-600/20 to-transparent px-10 py-6 border-b border-slate-800/60 flex items-center gap-4">
                        <div class="p-2.5 bg-emerald-500 rounded-2xl shadow-[0_0_20px_rgba(16,185,129,0.3)] text-slate-950">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h2 class="text-xl font-black text-white tracking-tight uppercase">Konfirmasi Penyelesaian</h2>
                    </div>

                    <div class="p-10 space-y-10">
                        <div class="space-y-4">
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Status Aktivitas Layanan <span class="text-rose-500">*</span></label>
                            <label class="relative flex items-center p-6 cursor-pointer bg-slate-800/30 border-2 border-slate-700/50 rounded-3xl hover:bg-slate-800 transition-all duration-300 group overflow-hidden">
                                <input type="checkbox" name="internet_active_confirmation" value="1" {{ old('internet_active_confirmation', $handover->internet_active_confirmation) ? 'checked' : '' }} class="hidden peer">
                                <div class="absolute inset-0 bg-emerald-500/5 opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                                
                                <div class="w-6 h-6 rounded-lg border-2 border-slate-600 flex items-center justify-center peer-checked:border-emerald-500 peer-checked:bg-emerald-500 transition-all z-10">
                                    <svg class="w-4 h-4 text-slate-950 opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                
                                <div class="ml-4 z-10">
                                    <span class="block text-slate-200 font-bold group-hover:text-white transition-colors peer-checked:text-emerald-400 text-sm tracking-tight">Konfirmasi Internet Aktif & Stabil</span>
                                    <span class="text-[10px] text-slate-500 font-medium peer-checked:text-emerald-500/60 mt-0.5 block uppercase tracking-widest">Layanan sudah dapat digunakan pelanggan</span>
                                </div>
                            </label>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Tanggal Serah Terima <span class="text-rose-500">*</span></label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 group-focus-within:text-emerald-400 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <input type="date" name="handover_date" value="{{ old('handover_date', $handover->handover_date?->format('Y-m-d')) }}" required
                                    class="w-full pl-12 pr-4 py-4 bg-slate-800/50 border border-slate-700 text-white rounded-2xl focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all font-medium">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Catatan Akhir Teknisi Lapangan</label>
                            <textarea name="final_technician_notes" rows="4"
                                class="w-full px-5 py-4 bg-slate-800/50 border border-slate-700 text-white rounded-[1.5rem] focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all placeholder-slate-600 font-medium leading-relaxed"
                                placeholder="Tuliskan kesimpulan akhir: Kondisi pelanggan puas, material tersisa, atau saran pemeliharaan kedepannya...">{{ old('final_technician_notes', $handover->final_technician_notes) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-slate-900/50 border border-slate-800 rounded-3xl p-6 hover:border-emerald-500/30 transition-all duration-300 group">
                        <h4 class="text-xs font-black text-slate-500 uppercase tracking-[0.2em] mb-4 flex items-center gap-2 group-hover:text-emerald-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4"></path></svg>
                            Log Instalasi
                        </h4>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-slate-500 font-medium tracking-tight">Teknisi Eksekutor</span>
                                <span class="text-xs text-white font-bold tracking-tight">{{ auth()->user()->name }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-slate-500 font-medium tracking-tight">Waktu Pengerjaan</span>
                                <span class="text-xs text-white font-bold tracking-tight">{{ $installation->installation_date?->format('d M Y') ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-slate-500 font-medium tracking-tight">Media Koneksi</span>
                                <span class="text-xs px-2 py-0.5 bg-slate-800 rounded-md text-emerald-400 font-black uppercase text-[9px] tracking-widest border border-emerald-500/20">{{ $installation->connection_type ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-900/50 border border-slate-800 rounded-3xl p-6 hover:border-emerald-500/30 transition-all duration-300 group">
                        <h4 class="text-xs font-black text-slate-500 uppercase tracking-[0.2em] mb-4 flex items-center gap-2 group-hover:text-emerald-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            Konfigurasi Aktif
                        </h4>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-slate-500 font-medium tracking-tight">Placement Router</span>
                                <span class="text-xs text-white font-bold tracking-tight">{{ $installation->networkConfig->router_area ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-slate-500 font-medium tracking-tight">Access Point OLT</span>
                                <span class="text-xs text-white font-bold tracking-tight">{{ $installation->networkConfig->olt_access_point ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-slate-500 font-medium tracking-tight">Interface Port</span>
                                <span class="text-xs text-white font-bold tracking-tight">{{ $installation->networkConfig->port_interface ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row gap-4">
                    <button type="submit" class="flex-[2] px-8 py-5 bg-emerald-600 text-slate-950 font-black rounded-3xl shadow-[0_0_25px_rgba(16,185,129,0.3)] hover:bg-emerald-500 hover:shadow-[0_0_35px_rgba(16,185,129,0.5)] transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-3 text-lg tracking-tight uppercase">
                        Selesaikan Instalasi & Tutup Tiket
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </button>
                    <a href="{{ route('technician.installation.show', $installation->id) }}" class="flex-1 px-8 py-5 bg-slate-900 text-slate-400 font-bold rounded-3xl border border-slate-800 hover:bg-slate-800 hover:text-white transition-all duration-300 flex items-center justify-center gap-3 text-lg text-center">
                        Batal
                    </a>
                </div>

            </form>

            <div class="mt-12 p-6 bg-slate-900/50 border border-slate-800 rounded-3xl text-center">
                <p class="text-[10px] text-slate-500 font-black uppercase tracking-[0.3em]">
                    PT. Mandiri Global Data &bull; Quality Assurance System &bull; 2026
                </p>
            </div>
        </div>
    </div>
</x-app-layout>