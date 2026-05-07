<x-app-layout>
    <div class="py-10 bg-slate-950 min-h-screen selection:bg-amber-500/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="fade-in">
                    <a href="{{ route('technician.installation.index') }}" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-white transition-colors mb-4 group">
                        <svg class="w-4 h-4 mr-1.5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali ke Log Instalasi
                    </a>
                    <h1 class="text-4xl font-black text-white tracking-tighter">Rangkuman <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 to-yellow-200">Aktivasi Layanan</span></h1>
                    <p class="text-slate-400 mt-2 font-medium flex items-center gap-2">
                        <span>Pelanggan:</span>
                        <span class="text-amber-400 font-bold underline decoration-amber-500/30 underline-offset-4 tracking-tight">{{ $installation->lead->name }}</span>
                    </p>
                </div>
                
                @if($installation->handover)
                    <div class="px-5 py-3 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl flex items-center gap-3">
                        <span class="relative flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                        </span>
                        <span class="text-emerald-400 font-black uppercase tracking-widest text-[10px]">Tugas Selesai (Handover)</span>
                    </div>
                @else
                    <a href="{{ route('technician.handover.form', $installation->id) }}" class="inline-flex items-center justify-center gap-3 px-8 py-4 bg-amber-600 text-white font-black uppercase tracking-widest text-xs rounded-2xl shadow-[0_0_20px_rgba(217,119,6,0.3)] hover:bg-amber-500 hover:shadow-[0_0_30px_rgba(217,119,6,0.5)] transition-all duration-300 transform hover:-translate-y-1">
                        Selesaikan Handover
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                @endif
            </div>

            <div class="mb-10 p-2 bg-slate-900/50 backdrop-blur-md border border-slate-800 rounded-2xl flex flex-wrap gap-2 sticky top-4 z-50 shadow-xl overflow-x-auto hide-scrollbar">
                <a href="#instalasi" class="flex-1 min-w-[150px] px-6 py-3.5 bg-amber-500/10 border border-amber-500/20 text-amber-400 rounded-xl text-center font-black text-xs uppercase tracking-widest shadow-inner hover:bg-amber-500/20 transition-all">
                    1. Data Instalasi
                </a>
                <a href="#device" class="flex-1 min-w-[150px] px-6 py-3.5 bg-slate-800 border border-slate-700 text-slate-400 rounded-xl text-center font-bold text-xs uppercase tracking-widest hover:text-white transition-colors">
                    2. Perangkat
                </a>
                <a href="#network" class="flex-1 min-w-[150px] px-6 py-3.5 bg-slate-800 border border-slate-700 text-slate-400 rounded-xl text-center font-bold text-xs uppercase tracking-widest hover:text-white transition-colors">
                    3. Jaringan OLT
                </a>
                <a href="#test" class="flex-1 min-w-[150px] px-6 py-3.5 bg-slate-800 border border-slate-700 text-slate-400 rounded-xl text-center font-bold text-xs uppercase tracking-widest hover:text-white transition-colors">
                    4. Uji Koneksi
                </a>
            </div>

            <div class="grid grid-cols-1 gap-10">

                <div id="instalasi" class="bg-slate-900/80 backdrop-blur-md rounded-[2.5rem] shadow-2xl border border-slate-800 overflow-hidden relative scroll-mt-24">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-amber-500/5 rounded-full blur-3xl pointer-events-none"></div>
                    
                    <div class="bg-gradient-to-r from-amber-600/10 to-transparent px-8 py-5 border-b border-slate-800/60 flex justify-between items-center">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-amber-500 rounded-xl shadow-[0_0_15px_rgba(245,158,11,0.3)] flex items-center justify-center text-slate-950 font-black text-lg">1</div>
                            <h3 class="text-lg font-black text-white tracking-tight uppercase">Parameter Lapangan</h3>
                        </div>
                        <a href="{{ route('technician.installation.create', $installation->lead_id) }}" class="p-2 bg-slate-800 text-slate-400 hover:text-amber-400 rounded-lg transition-colors border border-slate-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </a>
                    </div>
                    
                    <div class="p-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                            <div class="space-y-1">
                                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Waktu Eksekusi</p>
                                <p class="text-lg font-bold text-white">{{ $installation->installation_date?->format('d M Y') ?? '-' }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Media Transmisi</p>
                                <p class="text-lg font-bold text-white">{{ $installation->connection_type == 'fiber' ? 'Fiber Optic (FTTH)' : 'Wireless Point-to-Point' }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Panjang Tarikan</p>
                                <p class="text-lg font-bold text-white font-mono">{{ $installation->cable_length ?? '-' }} <span class="text-sm text-slate-500 normal-case">Meter</span></p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Status Final</p>
                                <div>
                                    @if($installation->installation_status == 'berhasil')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 rounded-lg text-xs font-black uppercase tracking-widest"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Sukses</span>
                                    @elseif($installation->installation_status == 'gagal')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-rose-500/10 text-rose-400 border border-rose-500/20 rounded-lg text-xs font-black uppercase tracking-widest"><span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Gagal</span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-500/10 text-amber-500 border border-amber-500/20 rounded-lg text-xs font-black uppercase tracking-widest"><span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Draft</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-8 pt-6 border-t border-slate-800/60 grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> Lokasi Perangkat (CPE)</p>
                                <div class="bg-slate-800/30 border border-slate-700/50 p-4 rounded-2xl">
                                    <p class="text-slate-300 font-medium text-sm leading-relaxed">{{ $installation->device_placement ?? 'Belum diisi' }}</p>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg> Log Catatan Teknisi</p>
                                <div class="bg-slate-800/30 border border-slate-700/50 p-4 rounded-2xl">
                                    <p class="text-slate-300 font-medium text-sm leading-relaxed">{{ $installation->installation_notes ?? 'Tidak ada catatan log' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="device" class="bg-slate-900/80 backdrop-blur-md rounded-[2.5rem] shadow-2xl border border-slate-800 overflow-hidden relative scroll-mt-24">
                    <div class="bg-gradient-to-r from-blue-600/10 to-transparent px-8 py-5 border-b border-slate-800/60 flex justify-between items-center">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-slate-800 border border-slate-700 rounded-xl flex items-center justify-center text-slate-400 font-black text-lg">2</div>
                            <h3 class="text-lg font-black text-white tracking-tight uppercase">Hardware (CPE)</h3>
                        </div>
                        @if($installation->deviceConfig)
                            <a href="{{ route('technician.device.form', $installation->id) }}" class="p-2 bg-slate-800 text-slate-400 hover:text-blue-400 rounded-lg transition-colors border border-slate-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                        @endif
                    </div>

                    <div class="p-8">
                        @if($installation->deviceConfig)
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                                <div class="space-y-1">
                                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Kategori</p>
                                    <p class="text-sm font-bold text-white">{{ $installation->deviceConfig->device_type }}</p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Vendor</p>
                                    <p class="text-sm font-bold text-white">{{ $installation->deviceConfig->device_brand }}</p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Serial Number</p>
                                    <p class="text-sm font-bold text-blue-400 font-mono tracking-widest">{{ $installation->deviceConfig->serial_number }}</p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">MAC Address</p>
                                    <p class="text-sm font-bold text-white font-mono tracking-widest">{{ $installation->deviceConfig->mac_address }}</p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Kondisi</p>
                                    <p class="text-sm font-bold text-emerald-400 uppercase tracking-wider text-[10px] mt-1">{{ str_replace('_', ' ', $installation->deviceConfig->device_condition) }}</p>
                                </div>
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center py-10">
                                <div class="w-16 h-16 bg-slate-800/50 border border-slate-700 border-dashed rounded-full flex items-center justify-center text-slate-500 mb-4">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path></svg>
                                </div>
                                <p class="text-slate-400 font-medium mb-6">Database Hardware (CPE) kosong.</p>
                                <a href="{{ route('technician.device.form', $installation->id) }}" class="px-6 py-3 bg-amber-600/10 text-amber-500 border border-amber-500/20 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-amber-600 hover:text-white transition-all shadow-sm">
                                    + Registrasi Perangkat
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <div id="network" class="bg-slate-900/80 backdrop-blur-md rounded-[2.5rem] shadow-2xl border border-slate-800 overflow-hidden relative scroll-mt-24">
                    <div class="bg-gradient-to-r from-indigo-600/10 to-transparent px-8 py-5 border-b border-slate-800/60 flex justify-between items-center">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-slate-800 border border-slate-700 rounded-xl flex items-center justify-center text-slate-400 font-black text-lg">3</div>
                            <h3 class="text-lg font-black text-white tracking-tight uppercase">Topologi Jaringan</h3>
                        </div>
                        @if($installation->networkConfig)
                            <a href="{{ route('technician.network.form', $installation->id) }}" class="p-2 bg-slate-800 text-slate-400 hover:text-indigo-400 rounded-lg transition-colors border border-slate-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                        @endif
                    </div>

                    <div class="p-8">
                        @if($installation->networkConfig)
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                                <div class="space-y-1">
                                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Router Induk</p>
                                    <p class="text-sm font-bold text-white font-mono uppercase">{{ $installation->networkConfig->router_area }}</p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Interface Port</p>
                                    <p class="text-sm font-bold text-white font-mono">{{ $installation->networkConfig->port_interface }}</p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">VLAN ID</p>
                                    <p class="text-sm font-bold text-indigo-400 font-mono">{{ $installation->networkConfig->vlan_id ?? 'Untagged' }}</p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">OLT / AP Point</p>
                                    <p class="text-sm font-bold text-white font-mono uppercase">{{ $installation->networkConfig->olt_access_point }}</p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Protokol</p>
                                    <p class="text-sm font-black text-amber-400 uppercase tracking-widest mt-1 text-[10px] border border-amber-500/20 px-2 py-0.5 rounded inline-block bg-amber-500/10">{{ $installation->networkConfig->connection_mode }}</p>
                                </div>
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center py-10">
                                <div class="w-16 h-16 bg-slate-800/50 border border-slate-700 border-dashed rounded-full flex items-center justify-center text-slate-500 mb-4">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                </div>
                                <p class="text-slate-400 font-medium mb-6">Setup Infrastruktur Jaringan belum dikonfigurasi.</p>
                                <a href="{{ route('technician.network.form', $installation->id) }}" class="px-6 py-3 bg-amber-600/10 text-amber-500 border border-amber-500/20 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-amber-600 hover:text-white transition-all shadow-sm">
                                    + Input Topologi
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <div id="test" class="bg-slate-900/80 backdrop-blur-md rounded-[2.5rem] shadow-2xl border border-slate-800 overflow-hidden relative scroll-mt-24">
                    <div class="bg-gradient-to-r from-emerald-600/10 to-transparent px-8 py-5 border-b border-slate-800/60 flex justify-between items-center">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-slate-800 border border-slate-700 rounded-xl flex items-center justify-center text-slate-400 font-black text-lg">4</div>
                            <h3 class="text-lg font-black text-white tracking-tight uppercase">Quality of Service (QoS)</h3>
                        </div>
                        @if($installation->connectionTest)
                            <a href="{{ route('technician.connection-test.form', $installation->id) }}" class="p-2 bg-slate-800 text-slate-400 hover:text-emerald-400 rounded-lg transition-colors border border-slate-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                        @endif
                    </div>

                    <div class="p-8">
                        @if($installation->connectionTest)
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                                <div class="bg-slate-800/50 border border-slate-700/50 p-4 rounded-2xl text-center">
                                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Status Link</p>
                                    @if($installation->connectionTest->connection_status == 'berhasil')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 rounded-lg text-xs font-black uppercase tracking-widest"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Online</span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-rose-500/10 text-rose-400 border border-rose-500/20 rounded-lg text-xs font-black uppercase tracking-widest"><span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Offline</span>
                                    @endif
                                </div>
                                <div class="bg-slate-800/50 border border-slate-700/50 p-4 rounded-2xl text-center">
                                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1 flex items-center justify-center gap-1"><svg class="w-3 h-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg> Download</p>
                                    <p class="text-2xl font-black text-white font-mono mt-1">{{ $installation->connectionTest->speed_test_download }} <span class="text-[10px] text-slate-500 font-bold uppercase tracking-widest normal-case">Mbps</span></p>
                                </div>
                                <div class="bg-slate-800/50 border border-slate-700/50 p-4 rounded-2xl text-center">
                                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1 flex items-center justify-center gap-1"><svg class="w-3 h-3 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg> Upload</p>
                                    <p class="text-2xl font-black text-white font-mono mt-1">{{ $installation->connectionTest->speed_test_upload }} <span class="text-[10px] text-slate-500 font-bold uppercase tracking-widest normal-case">Mbps</span></p>
                                </div>
                                <div class="bg-slate-800/50 border border-slate-700/50 p-4 rounded-2xl text-center">
                                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Latency / PING</p>
                                    <p class="text-2xl font-black text-white font-mono mt-1">{{ $installation->connectionTest->latency }} <span class="text-[10px] text-slate-500 font-bold uppercase tracking-widest normal-case">ms</span></p>
                                </div>
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center py-10">
                                <div class="w-16 h-16 bg-slate-800/50 border border-slate-700 border-dashed rounded-full flex items-center justify-center text-slate-500 mb-4">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                </div>
                                <p class="text-slate-400 font-medium mb-6">Hasil Speedtest dan validasi koneksi belum dilampirkan.</p>
                                <a href="{{ route('technician.connection-test.form', $installation->id) }}" class="px-6 py-3 bg-amber-600/10 text-amber-500 border border-amber-500/20 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-amber-600 hover:text-white transition-all shadow-sm">
                                    + Uji Bandwidth
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tabs = document.querySelectorAll('.sticky a');
            
            // Simple click behavior for tab styling
            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    // Reset all tabs to inactive state
                    tabs.forEach(t => {
                        t.className = 'flex-1 min-w-[150px] px-6 py-3.5 bg-slate-800 border border-slate-700 text-slate-400 rounded-xl text-center font-bold text-xs uppercase tracking-widest hover:text-white transition-colors';
                    });
                    
                    // Set active state on clicked tab
                    this.className = 'flex-1 min-w-[150px] px-6 py-3.5 bg-amber-500/10 border border-amber-500/20 text-amber-400 rounded-xl text-center font-black text-xs uppercase tracking-widest shadow-inner hover:bg-amber-500/20 transition-all';
                });
            });
        });
    </script>
</x-app-layout>