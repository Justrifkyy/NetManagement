<x-app-layout>
    <x-slot name="header">
        {{ __('Dashboard') }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-900 overflow-hidden shadow-xl sm:rounded-lg border border-slate-800">
                <div class="p-8 text-center">
                    <h2 class="text-3xl font-black text-white mb-4">Selamat Datang di NetManagement</h2>
                    <p class="text-slate-400 text-lg mb-8">Sistem Manajemen Jaringan & Pelanggan Terpadu</p>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-slate-800 p-6 rounded-xl border border-slate-700 hover:border-amber-500 transition">
                            <div class="text-amber-500 mb-3 text-4xl">📊</div>
                            <h3 class="text-white font-bold mb-2">Dashboard Anda</h3>
                            <p class="text-slate-400 text-sm">Akses panel kontrol sesuai dengan role Anda</p>
                        </div>
                        <div class="bg-slate-800 p-6 rounded-xl border border-slate-700 hover:border-amber-500 transition">
                            <div class="text-amber-500 mb-3 text-4xl">⚙️</div>
                            <h3 class="text-white font-bold mb-2">Pengaturan Akun</h3>
                            <p class="text-slate-400 text-sm">Kelola profil dan preferensi Anda</p>
                        </div>
                        <div class="bg-slate-800 p-6 rounded-xl border border-slate-700 hover:border-amber-500 transition">
                            <div class="text-amber-500 mb-3 text-4xl">📞</div>
                            <h3 class="text-white font-bold mb-2">Bantuan & Dukungan</h3>
                            <p class="text-slate-400 text-sm">Hubungi tim support kami kapan saja</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
