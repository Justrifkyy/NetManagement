<x-app-layout>
    <div class="py-16 bg-slate-950 min-h-screen flex items-center justify-center">
        <div class="max-w-lg mx-auto px-6 text-center">
            {{-- Animated Icon --}}
            <div class="flex items-center justify-center mb-8">
                <div class="relative">
                    <div class="w-24 h-24 rounded-full bg-amber-500/10 border-2 border-amber-500/30 flex items-center justify-center animate-pulse">
                        <svg class="w-12 h-12 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="absolute -top-1 -right-1 flex h-5 w-5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-5 w-5 bg-amber-500"></span>
                    </span>
                </div>
            </div>

            {{-- Text Content --}}
            <h1 class="text-3xl font-black text-white mb-4 tracking-tight">Akun Sedang Diproses</h1>
            <p class="text-slate-400 text-lg leading-relaxed mb-8">
                Halo, <strong class="text-white">{{ Auth::user()->name }}</strong>! 👋<br>
                Akun Anda sudah terdaftar, namun profil layanan internet Anda belum diaktifkan oleh Admin.
            </p>

            {{-- Info Card --}}
            <div class="bg-slate-900/80 border border-slate-800 rounded-2xl p-6 mb-8 text-left space-y-4">
                <div class="flex items-start gap-3">
                    <div class="p-1.5 bg-emerald-500/10 rounded-lg border border-emerald-500/20 mt-0.5 shrink-0">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div>
                        <p class="font-bold text-white text-sm">Pendaftaran Berhasil</p>
                        <p class="text-slate-400 text-sm mt-0.5">Data Anda sudah tercatat di sistem kami.</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="p-1.5 bg-amber-500/10 rounded-lg border border-amber-500/20 mt-0.5 shrink-0">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="font-bold text-white text-sm">Menunggu Verifikasi Admin</p>
                        <p class="text-slate-400 text-sm mt-0.5">Tim kami sedang memverifikasi dan memproses aktivasi layanan Anda.</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="p-1.5 bg-slate-700/50 rounded-lg border border-slate-600 mt-0.5 shrink-0">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    </div>
                    <div>
                        <p class="font-bold text-white text-sm">Butuh Bantuan?</p>
                        <p class="text-slate-400 text-sm mt-0.5">Hubungi tim support kami untuk informasi lebih lanjut terkait status pendaftaran Anda.</p>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('dashboard') }}" class="px-6 py-3 bg-slate-800 text-slate-300 font-bold rounded-xl border border-slate-700 hover:bg-slate-700 hover:text-white transition-all text-center">
                    Muat Ulang Halaman
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-rose-600/20 text-rose-400 font-bold rounded-xl border border-rose-500/30 hover:bg-rose-600/30 transition-all">
                        Keluar dari Akun
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
