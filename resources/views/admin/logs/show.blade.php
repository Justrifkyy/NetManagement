<x-app-layout>
    <div class="py-10 bg-slate-950 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Back Button --}}
            <div class="mb-6 px-4 sm:px-0">
                <a href="{{ route('admin.logs.index') }}" class="inline-flex items-center text-sm font-semibold text-slate-400 hover:text-white transition-colors group">
                    <svg class="w-4 h-4 mr-1.5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Activity Log
                </a>
            </div>

            {{-- Header --}}
            <div class="mb-6 px-4 sm:px-0">
                <h2 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-white to-slate-400 tracking-tight">Detail Log Aktivitas</h2>
                <p class="text-slate-400 mt-1 font-mono text-sm">#{{ $log->id }}</p>
            </div>

            <div class="space-y-6">

                {{-- Main Info Card --}}
                <div class="bg-slate-900/80 backdrop-blur-md rounded-2xl shadow-xl border border-slate-800 overflow-hidden">
                    <div class="px-6 py-4 bg-slate-800/50 border-b border-slate-700/50 flex items-center gap-3">
                        <div class="p-1.5 bg-sky-500/10 rounded-lg border border-sky-500/20">
                            <svg class="w-4 h-4 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        </div>
                        <h3 class="font-bold text-white text-base">Informasi Log</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Waktu --}}
                        <div>
                            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Waktu Kejadian</span>
                            <p class="mt-1.5 text-white font-mono font-bold">{{ $log->created_at->format('d F Y, H:i:s') }}</p>
                            <p class="text-slate-500 text-xs mt-0.5">{{ $log->created_at->diffForHumans() }}</p>
                        </div>

                        {{-- User --}}
                        <div>
                            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Dilakukan Oleh</span>
                            @if($log->user)
                                <p class="mt-1.5 text-white font-bold">{{ $log->user->name }}</p>
                                <p class="text-slate-400 text-sm">{{ $log->user->email }}</p>
                                <span class="inline-block mt-1 px-2 py-0.5 bg-blue-500/10 text-blue-400 border border-blue-500/20 rounded text-xs font-bold uppercase">{{ $log->user->role }}</span>
                            @else
                                <p class="mt-1.5 text-rose-400 font-bold italic">System / Otomatis</p>
                            @endif
                        </div>

                        {{-- Aksi --}}
                        <div>
                            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi / Modul</span>
                            @php
                                $actionStr = strtolower($log->action);
                                $actionColor = 'slate';
                                if (str_contains($actionStr, 'create') || str_contains($actionStr, 'store') || str_contains($actionStr, 'add')) {
                                    $actionColor = 'emerald';
                                } elseif (str_contains($actionStr, 'update') || str_contains($actionStr, 'edit') || str_contains($actionStr, 'modify')) {
                                    $actionColor = 'amber';
                                } elseif (str_contains($actionStr, 'delete') || str_contains($actionStr, 'remove') || str_contains($actionStr, 'destroy')) {
                                    $actionColor = 'rose';
                                } elseif (str_contains($actionStr, 'login') || str_contains($actionStr, 'auth')) {
                                    $actionColor = 'sky';
                                } else {
                                    $actionColor = 'indigo';
                                }
                            @endphp
                            <div class="mt-1.5">
                                <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-black tracking-wider bg-{{ $actionColor }}-500/10 text-{{ $actionColor }}-400 border border-{{ $actionColor }}-500/20 uppercase">
                                    {{ str_replace('_', ' ', $log->action) }}
                                </span>
                            </div>
                        </div>

                        {{-- IP Address --}}
                        <div>
                            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">IP Address</span>
                            <p class="mt-1.5 text-white font-mono font-bold">{{ $log->ip_address ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Deskripsi Card --}}
                <div class="bg-slate-900/80 backdrop-blur-md rounded-2xl shadow-xl border border-slate-800 overflow-hidden">
                    <div class="px-6 py-4 bg-slate-800/50 border-b border-slate-700/50 flex items-center gap-3">
                        <div class="p-1.5 bg-amber-500/10 rounded-lg border border-amber-500/20">
                            <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                        </div>
                        <h3 class="font-bold text-white text-base">Deskripsi Aktivitas</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-slate-300 leading-relaxed">{{ $log->description ?? 'Tidak ada deskripsi.' }}</p>
                    </div>
                </div>

                {{-- Detail JSON Card --}}
                @if($log->details)
                    <div class="bg-slate-900/80 backdrop-blur-md rounded-2xl shadow-xl border border-slate-800 overflow-hidden">
                        <div class="px-6 py-4 bg-slate-800/50 border-b border-slate-700/50 flex items-center gap-3">
                            <div class="p-1.5 bg-emerald-500/10 rounded-lg border border-emerald-500/20">
                                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                            </div>
                            <h3 class="font-bold text-white text-base">Data Detail (JSON)</h3>
                        </div>
                        <div class="p-6">
                            @php
                                $details = is_string($log->details) ? json_decode($log->details, true) : $log->details;
                            @endphp
                            @if(is_array($details))
                                <div class="space-y-2">
                                    @foreach($details as $key => $value)
                                        <div class="flex items-start gap-3 py-2 border-b border-slate-800/60 last:border-0">
                                            <span class="font-mono text-xs text-sky-400 font-bold pt-0.5 shrink-0 min-w-[120px]">{{ $key }}</span>
                                            <span class="text-slate-300 text-sm break-all">
                                                @if(is_array($value) || is_object($value))
                                                    <pre class="text-xs text-slate-400 bg-slate-800 rounded p-2 overflow-x-auto">{{ json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                                @else
                                                    {{ $value }}
                                                @endif
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <pre class="text-xs text-slate-400 bg-slate-800/50 rounded-xl p-4 overflow-x-auto leading-relaxed border border-slate-700">{{ json_encode($details, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- User Agent Card --}}
                @if($log->user_agent)
                    <div class="bg-slate-900/80 backdrop-blur-md rounded-2xl shadow-xl border border-slate-800 overflow-hidden">
                        <div class="px-6 py-4 bg-slate-800/50 border-b border-slate-700/50 flex items-center gap-3">
                            <div class="p-1.5 bg-slate-700/50 rounded-lg border border-slate-600/30">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <h3 class="font-bold text-white text-base">User Agent (Browser / Perangkat)</h3>
                        </div>
                        <div class="p-6">
                            <p class="text-slate-400 text-sm font-mono break-all leading-relaxed">{{ $log->user_agent }}</p>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
