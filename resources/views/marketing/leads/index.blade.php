<x-app-layout>
    <div class="py-10 bg-slate-950 min-h-screen selection:bg-indigo-500/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="fade-in">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-sky-500/10 rounded-lg border border-sky-500/20">
                            <svg class="w-5 h-5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <span class="text-[10px] font-black text-sky-500 uppercase tracking-[0.2em]">Sales Pipeline</span>
                    </div>
                    <h1 class="text-4xl font-black text-white tracking-tighter">Daftar <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-400 to-indigo-400">Prospek (Leads)</span></h1>
                    <p class="text-slate-400 mt-2 font-medium">Kelola data calon pelanggan dan pantau siklus konversi penjualan Anda.</p>
                </div>
                <div class="flex-shrink-0">
                    <a href="{{ route('marketing.leads.create') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-sky-600 text-white text-xs font-black uppercase tracking-widest rounded-2xl shadow-[0_0_20px_rgba(2,132,199,0.3)] hover:bg-sky-500 hover:shadow-[0_0_30px_rgba(2,132,199,0.5)] transition-all duration-300 transform hover:-translate-y-1 w-full md:w-auto">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                        Input Prospek Baru
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div class="mb-10 p-5 bg-emerald-500/10 border border-emerald-500/20 rounded-[2rem] flex items-center gap-4 animate-fade-in shadow-lg">
                    <div class="p-2.5 bg-emerald-500 rounded-xl text-white shadow-[0_0_15px_rgba(16,185,129,0.4)]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <p class="text-emerald-400 font-bold tracking-wide">{{ session('success') }}</p>
                </div>
            @endif

            <div class="hidden md:block bg-slate-900/80 backdrop-blur-md rounded-[2.5rem] shadow-2xl border border-slate-800 overflow-hidden relative mb-10">
                <div class="absolute -left-20 -top-20 w-72 h-72 bg-sky-500/5 rounded-full blur-3xl pointer-events-none"></div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-800/50 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] border-b border-slate-800/60">
                            <tr>
                                <th class="px-8 py-5">Identitas Prospek</th>
                                <th class="px-6 py-5">Minat Layanan</th>
                                <th class="px-6 py-5">Lokasi Pemasangan</th>
                                <th class="px-6 py-5 text-center">Status Lead</th>
                                <th class="px-8 py-5 text-center">Manajemen</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/60 text-sm">
                            @php /** @var \Illuminate\Support\Collection $leads */ @endphp
                            @forelse($leads as $lead)
                                <tr class="hover:bg-slate-800/40 transition-all duration-300 group">
                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 bg-sky-500/10 rounded-2xl flex items-center justify-center text-sky-400 border border-sky-500/20 group-hover:bg-sky-500 group-hover:text-white transition-colors duration-300 font-black text-lg uppercase shadow-sm">
                                                {{ substr($lead->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-white group-hover:text-sky-400 transition-colors text-base tracking-tight">{{ $lead->name }}</div>
                                                <div class="text-[10px] text-slate-500 font-black uppercase tracking-widest mt-0.5 flex items-center gap-1">
                                                    <svg class="w-3.5 h-3.5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                                    {{ $lead->phone ?? '-' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-6">
                                        <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-slate-800 border border-slate-700 rounded-xl">
                                            <span class="text-xs font-bold text-slate-300">{{ $lead->package->name ?? 'Belum Pilih Paket' }}</span>
                                        </div>
                                        <div class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mt-2 flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            Entry: {{ $lead->created_at->format('d M Y') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-6">
                                        <div class="text-sm font-medium text-slate-300 leading-relaxed max-w-[250px] line-clamp-2" title="{{ $lead->address_installation }}">
                                            {{ $lead->address_installation }}
                                        </div>
                                        <div class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mt-1.5 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                            {{ $lead->district ?? '-' }}, {{ $lead->city ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-6 text-center">
                                        @php
                                            $statusTheme = match ($lead->status) {
                                                'prospek' => ['bg' => 'bg-blue-500/10', 'text' => 'text-blue-400', 'border' => 'border-blue-500/20', 'dot' => 'bg-blue-500'],
                                                'survey' => ['bg' => 'bg-amber-500/10', 'text' => 'text-amber-400', 'border' => 'border-amber-500/20', 'dot' => 'bg-amber-500'],
                                                'instalasi' => ['bg' => 'bg-indigo-500/10', 'text' => 'text-indigo-400', 'border' => 'border-indigo-500/20', 'dot' => 'bg-indigo-500'],
                                                'aktif', 'converted' => ['bg' => 'bg-emerald-500/10', 'text' => 'text-emerald-400', 'border' => 'border-emerald-500/20', 'dot' => 'bg-emerald-500'],
                                                'batal' => ['bg' => 'bg-rose-500/10', 'text' => 'text-rose-400', 'border' => 'border-rose-500/20', 'dot' => 'bg-rose-500'],
                                                default => ['bg' => 'bg-slate-800', 'text' => 'text-slate-400', 'border' => 'border-slate-700', 'dot' => 'bg-slate-500'],
                                            };
                                        @endphp
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest border {{ $statusTheme['bg'] }} {{ $statusTheme['text'] }} {{ $statusTheme['border'] }} shadow-inner">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $statusTheme['dot'] }}"></span>
                                            {{ $lead->status }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-6 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('marketing.leads.show', $lead->id) }}" class="p-2.5 bg-slate-800 text-slate-400 hover:text-white hover:bg-slate-700 rounded-xl transition-all border border-slate-700 shadow-sm" title="Lihat Detail">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </a>

                                            @if ($lead->status !== 'converted' && $lead->status !== 'aktif')
                                                <a href="{{ route('marketing.leads.edit', $lead->id) }}" class="p-2.5 bg-slate-800 text-amber-500/80 hover:text-white hover:bg-amber-600 rounded-xl transition-all border border-slate-700 shadow-sm" title="Edit Data">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                </a>
                                                <form action="{{ route('marketing.leads.destroy', $lead->id) }}" method="POST" onsubmit="return confirm('Data prospek ini akan dihapus permanen. Lanjutkan?');" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="p-2.5 bg-slate-800 text-rose-500/80 hover:text-white hover:bg-rose-600 rounded-xl transition-all border border-slate-700 shadow-sm" title="Hapus Data">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                                <form action="{{ route('marketing.leads.convert', $lead->id) }}" method="POST" onsubmit="return confirm('Peringatan: Proses ini akan mengkonversi prospek menjadi pelanggan aktif dan membuat tiket instalasi untuk teknisi. Lanjutkan?');" class="inline">
                                                    @csrf
                                                    <button type="submit" class="p-2.5 bg-sky-500/10 text-sky-400 hover:text-white hover:bg-sky-500 rounded-xl transition-all border border-sky-500/30 shadow-sm" title="Convert to Customer (Mulai Instalasi)">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                                    </button>
                                                </form>
                                            @else
                                                <div class="px-3 py-2 bg-emerald-500/10 border border-emerald-500/20 rounded-xl flex items-center justify-center text-[10px] text-emerald-400 font-black uppercase tracking-widest cursor-default" title="Sudah Dikonversi">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                                    Selesai
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-20 text-center">
                                        <div class="flex flex-col items-center justify-center space-y-4">
                                            <div class="w-24 h-24 bg-slate-800 rounded-3xl flex items-center justify-center text-slate-600 border border-slate-700 shadow-inner">
                                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                            </div>
                                            <div class="max-w-md mx-auto mt-2">
                                                <h5 class="text-white font-bold text-lg tracking-tight">Belum Ada Prospek</h5>
                                                <p class="text-slate-500 text-sm mt-1 leading-relaxed">Sistem belum memiliki data prospek pelanggan. Silakan klik tombol "Input Prospek Baru" untuk mulai mendata calon pelanggan.</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="md:hidden space-y-6">
                @forelse($leads as $lead)
                    <div class="bg-slate-900/80 backdrop-blur-md rounded-[2.5rem] border border-slate-800 overflow-hidden shadow-2xl relative">
                        <div class="absolute top-6 right-6">
                            @php
                                $mobileStatusTheme = match ($lead->status) {
                                    'prospek' => ['bg' => 'bg-blue-500/10', 'text' => 'text-blue-400', 'border' => 'border-blue-500/20'],
                                    'survey' => ['bg' => 'bg-amber-500/10', 'text' => 'text-amber-400', 'border' => 'border-amber-500/20'],
                                    'instalasi' => ['bg' => 'bg-indigo-500/10', 'text' => 'text-indigo-400', 'border' => 'border-indigo-500/20'],
                                    'aktif', 'converted' => ['bg' => 'bg-emerald-500/10', 'text' => 'text-emerald-400', 'border' => 'border-emerald-500/20'],
                                    'batal' => ['bg' => 'bg-rose-500/10', 'text' => 'text-rose-400', 'border' => 'border-rose-500/20'],
                                    default => ['bg' => 'bg-slate-800', 'text' => 'text-slate-400', 'border' => 'border-slate-700'],
                                };
                            @endphp
                            <span class="px-3 py-1.5 text-[9px] font-black rounded-lg uppercase tracking-widest border {{ $mobileStatusTheme['bg'] }} {{ $mobileStatusTheme['text'] }} {{ $mobileStatusTheme['border'] }}">
                                {{ $lead->status }}
                            </span>
                        </div>

                        <div class="p-8 border-b border-slate-800/60 flex items-start gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-sky-500/10 flex items-center justify-center text-sky-400 border border-sky-500/20 font-black text-2xl uppercase shrink-0 shadow-sm">
                                {{ substr($lead->name, 0, 1) }}
                            </div>
                            <div class="pt-1">
                                <h4 class="text-lg font-black text-white tracking-tight leading-none mb-1.5">{{ $lead->name }}</h4>
                                <span class="text-xs text-slate-500 font-bold font-mono tracking-widest">{{ $lead->phone ?? '-' }}</span>
                            </div>
                        </div>

                        <div class="p-8 space-y-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-slate-800 flex items-center justify-center text-slate-400 shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] text-slate-500 font-black uppercase tracking-widest mb-0.5">Minat Layanan</p>
                                    <span class="text-white font-bold text-sm">{{ $lead->package->name ?? 'Belum Ditentukan' }}</span>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-slate-800 flex items-center justify-center text-slate-400 shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] text-slate-500 font-black uppercase tracking-widest mb-0.5">Lokasi Pemasangan</p>
                                    <span class="text-slate-300 font-medium text-sm leading-snug line-clamp-2">{{ $lead->address_installation }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="p-6 bg-slate-800/30 border-t border-slate-800/60">
                            <div class="grid {{ $lead->status !== 'converted' && $lead->status !== 'aktif' ? 'grid-cols-4' : 'grid-cols-1' }} gap-3">
                                <a href="{{ route('marketing.leads.show', $lead->id) }}" class="flex items-center justify-center py-4 bg-slate-800 border border-slate-700 rounded-2xl text-slate-400 hover:text-white hover:bg-slate-700 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>
                                
                                @if ($lead->status !== 'converted' && $lead->status !== 'aktif')
                                    <a href="{{ route('marketing.leads.edit', $lead->id) }}" class="flex items-center justify-center py-4 bg-slate-800 border border-slate-700 rounded-2xl text-amber-500/80 hover:text-amber-400 hover:bg-slate-700 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('marketing.leads.destroy', $lead->id) }}" method="POST" onsubmit="return confirm('Hapus Permanen?');" class="flex">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="w-full flex items-center justify-center py-4 bg-slate-800 border border-slate-700 rounded-2xl text-rose-500/80 hover:text-rose-400 hover:bg-slate-700 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                    <form action="{{ route('marketing.leads.convert', $lead->id) }}" method="POST" onsubmit="return confirm('Konversi ke Pelanggan?');" class="flex">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center justify-center py-4 bg-sky-500/10 border border-sky-500/30 rounded-2xl text-sky-400 hover:bg-sky-500 hover:text-white transition-all shadow-sm">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                        </button>
                                    </form>
                                @else
                                    <div class="col-span-1 flex items-center justify-center py-4 text-xs text-emerald-400 font-black tracking-widest uppercase bg-emerald-500/10 rounded-2xl border border-emerald-500/20">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                        Telah Dikonversi
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-16 bg-slate-900/80 backdrop-blur-md rounded-[2.5rem] border border-slate-800 shadow-xl">
                        <p class="text-slate-500 font-medium">Belum ada data prospek.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>