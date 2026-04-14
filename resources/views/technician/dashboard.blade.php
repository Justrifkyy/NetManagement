<x-app-layout>
    <div class="py-10 bg-slate-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-10 px-4 sm:px-0">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-4xl font-bold text-yellow-400">🔧 Dashboard Teknisi</h1>
                        <p class="text-slate-400 mt-1">Kelola pekerjaan instalasi dan maintenance jaringan</p>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10 px-4 sm:px-0">
                <!-- Tugas Hari Ini -->
                <div class="bg-slate-800 border border-yellow-400 rounded-xl shadow-lg p-6 hover:shadow-xl transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-400 text-sm font-semibold">📋 Tugas Hari Ini</p>
                            <p class="text-4xl font-bold text-yellow-400 mt-2">{{ $today_tasks }}</p>
                        </div>
                        <div class="w-16 h-16 bg-yellow-400/10 rounded-full flex items-center justify-center border border-yellow-400/30">
                            <span class="text-2xl">📅</span>
                        </div>
                    </div>
                    <a href="{{ route('technician.installation.index') }}" class="text-yellow-400 hover:text-yellow-300 text-sm mt-4 inline-block">Lihat Semua →</a>
                </div>

                <!-- Instalasi Pending -->
                <div class="bg-slate-800 border border-yellow-400 rounded-xl shadow-lg p-6 hover:shadow-xl transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-400 text-sm font-semibold">⏳ Instalasi Pending</p>
                            <p class="text-4xl font-bold text-yellow-400 mt-2">{{ $pending_installations }}</p>
                        </div>
                        <div class="w-16 h-16 bg-yellow-400/10 rounded-full flex items-center justify-center border border-yellow-400/30">
                            <span class="text-2xl">Link</span>
                        </div>
                    </div>
                    <a href="{{ route('technician.installation.index') }}" class="text-yellow-400 hover:text-yellow-300 text-sm mt-4 inline-block">Lihat Semua →</a>
                </div>

                <!-- Tiket Gangguan -->
                <div class="bg-slate-800 border border-red-500 rounded-xl shadow-lg p-6 hover:shadow-xl transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-400 text-sm font-semibold">Tiket Gangguan</p>
                            <p class="text-4xl font-bold text-red-500 mt-2">{{ $trouble_tickets }}</p>
                        </div>
                        <div class="w-16 h-16 bg-red-500/10 rounded-full flex items-center justify-center border border-red-500/30">
                            <span class="text-2xl">⚠️</span>
                        </div>
                    </div>
                    <a href="{{ route('technician.ticket.index') }}" class="text-red-500 hover:text-red-400 text-sm mt-4 inline-block">Lihat Semua →</a>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="px-4 sm:px-0 mb-10">
                <h3 class="text-xl font-bold text-yellow-400 mb-6 flex items-center">
                    <span class="w-8 h-8 bg-yellow-400 text-slate-900 rounded-full flex items-center justify-center mr-3 font-bold">⚡</span>
                    Aksi Cepat
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <a href="{{ route('technician.survey.index') }}" class="bg-gradient-to-r from-yellow-500 to-yellow-400 text-slate-900 font-bold py-3 px-6 rounded-lg hover:from-yellow-600 hover:to-yellow-500 transition text-center shadow-lg">
                        🔍 Lihat Survey
                    </a>
                    <a href="{{ route('technician.installation.index') }}" class="bg-gradient-to-r from-yellow-500 to-yellow-400 text-slate-900 font-bold py-3 px-6 rounded-lg hover:from-yellow-600 hover:to-yellow-500 transition text-center shadow-lg">
                        🔨 Lihat Instalasi
                    </a>
                    <a href="{{ route('technician.ticket.index') }}" class="bg-gradient-to-r from-red-600 to-red-500 text-white font-bold py-3 px-6 rounded-lg hover:from-red-700 hover:to-red-600 transition text-center shadow-lg">
                        🎟️ Gangguan
                    </a>
                    <a href="{{ route('technician.profile') }}" class="bg-slate-700 border border-yellow-400 text-yellow-400 font-bold py-3 px-6 rounded-lg hover:bg-slate-600 transition text-center">
                        Profil
                    </a>
                </div>
            </div>

            <!-- Menu Utama -->
            <div class="px-4 sm:px-0">
                <h3 class="text-xl font-bold text-yellow-400 mb-6 flex items-center">
                    <span class="w-8 h-8 bg-yellow-400 text-slate-900 rounded-full flex items-center justify-center mr-3 font-bold">📌</span>
                    Menu Utama
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Survey Section -->
                    <div class="bg-slate-800 border border-slate-700 rounded-xl p-6 hover:border-yellow-400 transition">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h4 class="text-lg font-bold text-yellow-400">🔍 SURVEY</h4>
                                <p class="text-slate-400 text-sm mt-1">Kelola hasil survey lokasi calon pelanggan</p>
                            </div>
                            <span class="text-3xl">📋</span>
                        </div>
                        <ul class="space-y-2 mt-4 text-sm">
                            <li><a href="{{ route('technician.survey.index') }}" class="text-yellow-300 hover:text-yellow-200">→ Daftar Survey</a></li>
                            <li><a href="{{ route('technician.survey.index') }}" class="text-yellow-300 hover:text-yellow-200">→ Form Hasil Survey</a></li>
                            <li><a href="{{ route('technician.survey.index') }}" class="text-yellow-300 hover:text-yellow-200">→ Detail Survey</a></li>
                        </ul>
                    </div>

                    <!-- Installation Section -->
                    <div class="bg-slate-800 border border-slate-700 rounded-xl p-6 hover:border-yellow-400 transition">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h4 class="text-lg font-bold text-yellow-400">🔨 INSTALASI</h4>
                                <p class="text-slate-400 text-sm mt-1">Form dan pencatatan proses instalasi jaringan</p>
                            </div>
                            <span class="text-3xl">⚙️</span>
                        </div>
                        <ul class="space-y-2 mt-4 text-sm">
                            <li><a href="{{ route('technician.installation.index') }}" class="text-yellow-300 hover:text-yellow-200">→ Daftar Instalasi</a></li>
                            <li><a href="{{ route('technician.installation.index') }}" class="text-yellow-300 hover:text-yellow-200">→ Tambah Instalasi</a></li>
                            <li><a href="{{ route('technician.installation.index') }}" class="text-yellow-300 hover:text-yellow-200">→ Detail Instalasi</a></li>
                        </ul>
                    </div>

                    <!-- Trouble Tickets -->
                    <div class="bg-slate-800 border border-slate-700 rounded-xl p-6 hover:border-red-500 transition">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h4 class="text-lg font-bold text-red-500">GANGGUAN</h4>
                                <p class="text-slate-400 text-sm mt-1">Penanganan tiket gangguan dan maintenance</p>
                            </div>
                            <span class="text-3xl">🎟️</span>
                        </div>
                        <ul class="space-y-2 mt-4 text-sm">
                            <li><a href="{{ route('technician.ticket.index') }}" class="text-red-300 hover:text-red-200">→ Daftar Tiket</a></li>
                            <li><a href="{{ route('technician.ticket.index') }}" class="text-red-300 hover:text-red-200">→ Update Status</a></li>
                            <li><a href="{{ route('technician.ticket.index') }}" class="text-red-300 hover:text-red-200">→ Riwayat Penanganan</a></li>
                        </ul>
                    </div>

                    <!-- Account -->
                    <div class="bg-slate-800 border border-slate-700 rounded-xl p-6 hover:border-yellow-400 transition">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h4 class="text-lg font-bold text-yellow-400">👤 AKUN</h4>
                                <p class="text-slate-400 text-sm mt-1">Kelola profil dan keamanan akun</p>
                            </div>
                            <span class="text-3xl">⚙️</span>
                        </div>
                        <ul class="space-y-2 mt-4 text-sm">
                            <li><a href="{{ route('technician.profile') }}" class="text-yellow-300 hover:text-yellow-200">→ Profil Teknisi</a></li>
                            <li><a href="{{ route('technician.password') }}" class="text-yellow-300 hover:text-yellow-200">→ Ganti Password</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
