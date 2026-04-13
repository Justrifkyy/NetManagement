<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Dashboard Teknisi') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-sky-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl mb-8 border-l-4 border-blue-600 relative">
                <div class="p-8 relative z-10">
                    <h1 class="text-3xl font-bold text-white">Halo, {{ Auth::user()->name }}! 👋</h1>
                    <p class="text-slate-300 mt-2">Selamat bekerja. Utamakan keselamatan K3 dan kepuasan pelanggan.</p>
                </div>
                <div class="absolute right-0 top-0 h-full w-1/3 bg-gradient-to-l from-blue-50 to-transparent opacity-50">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                <div
                    class="bg-white overflow-hidden shadow-md sm:rounded-xl border border-slate-800 p-6 flex items-center justify-between group hover:shadow-lg transition">
                    <div>
                        <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">Tiket Tersedia</p>
                        <p class="text-3xl font-extrabold text-amber-400 mt-1">{{ $openTickets ?? 0 }}</p>
                        <p class="text-xs text-slate-400 mt-1">Menunggu diambil di Jobdesk</p>
                    </div>
                    <div
                        class="p-3 bg-blue-50 rounded-full text-amber-400 group-hover:bg-amber-600 group-hover:text-white transition">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                    </div>
                </div>

                <div
                    class="bg-white overflow-hidden shadow-md sm:rounded-xl border border-slate-800 p-6 flex items-center justify-between group hover:shadow-lg transition">
                    <div>
                        <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">Sedang Dikerjakan</p>
                        <p class="text-3xl font-extrabold text-yellow-500 mt-1">{{ $myActiveTasks ?? 0 }}</p>
                        <p class="text-xs text-slate-400 mt-1">Perlu update laporan</p>
                    </div>
                    <div
                        class="p-3 bg-yellow-50 rounded-full text-yellow-500 group-hover:bg-yellow-500 group-hover:text-white transition">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>

                <div
                    class="bg-white overflow-hidden shadow-md sm:rounded-xl border border-slate-800 p-6 flex items-center justify-between group hover:shadow-lg transition">
                    <div>
                        <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">Selesai Bulan Ini</p>
                        <p class="text-3xl font-extrabold text-green-600 mt-1">{{ $completedThisMonth ?? 0 }}</p>
                        <p class="text-xs text-slate-400 mt-1">Kinerja instalasi & perbaikan</p>
                    </div>
                    <div
                        class="p-3 bg-green-50 rounded-full text-green-600 group-hover:bg-green-600 group-hover:text-white transition">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <a href="{{ route('technician.tickets.index') }}"
                    class="group block bg-white overflow-hidden shadow-xl sm:rounded-2xl hover:shadow-2xl transition duration-300 border border-slate-800">
                    <div class="p-8 flex items-start">
                        <div
                            class="flex-shrink-0 p-4 bg-blue-100 text-amber-400 rounded-xl group-hover:bg-amber-600 group-hover:text-white transition duration-300">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-6">
                            <h3 class="text-xl font-bold text-white group-hover:text-amber-400 transition">Bursa Tugas
                                (Jobdesk)</h3>
                            <p class="text-slate-400 mt-2 text-sm">Lihat daftar permintaan instalasi baru dari marketing.
                                Cari lokasi terdekat dan ambil tugas (Claim Ticket).</p>
                            <span class="mt-4 inline-flex items-center text-sm font-bold text-amber-400">
                                Buka Jobdesk
                                <svg class="ml-2 w-4 h-4 transform group-hover:translate-x-1 transition" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </span>
                        </div>
                    </div>
                </a>

                <a href="{{ route('technician.process.index') }}"
                    class="group block bg-white overflow-hidden shadow-xl sm:rounded-2xl hover:shadow-2xl transition duration-300 border border-slate-800">
                    <div class="p-8 flex items-start">
                        <div
                            class="flex-shrink-0 p-4 bg-yellow-100 text-yellow-600 rounded-xl group-hover:bg-yellow-500 group-hover:text-white transition duration-300">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-6">
                            <h3 class="text-xl font-bold text-white group-hover:text-yellow-600 transition">Tugas
                                Saya (Meja Kerja)</h3>
                            <p class="text-slate-400 mt-2 text-sm">Kelola tugas yang sudah Anda ambil. Input laporan
                                instalasi, upload foto bukti, dan selesaikan pekerjaan.</p>
                            <span class="mt-4 inline-flex items-center text-sm font-bold text-yellow-600">
                                Kelola Tugas
                                <svg class="ml-2 w-4 h-4 transform group-hover:translate-x-1 transition" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </span>
                        </div>
                    </div>
                </a>

            </div>

        </div>
    </div>
</x-app-layout>
