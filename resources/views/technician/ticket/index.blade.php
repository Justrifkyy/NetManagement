<x-app-layout>
    <div class="py-10 bg-slate-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8 px-4 sm:px-0 flex justify-between items-center">
                <div>
                    <h1 class="text-4xl font-bold text-red-500">🎟️ Tiket Gangguan</h1>
                    <p class="text-slate-400 mt-1">Kelola dan tangani tiket gangguan jaringan</p>
                </div>
                <a href="{{ route('technician.dashboard') }}" class="text-yellow-400 hover:text-yellow-300 font-semibold">← Kembali</a>
            </div>

            <div class="bg-slate-800 rounded-xl shadow-lg border border-slate-700 overflow-hidden mx-4 sm:mx-0 p-12 text-center">
                <p class="text-slate-400 text-lg">📭 Fitur Tiket Gangguan dalam pengembangan</p>
                <p class="text-slate-500 text-sm mt-2">Halaman ini akan menampilkan daftar tiket gangguan yang perlu ditangani</p>
            </div>
        </div>
    </div>
</x-app-layout>
