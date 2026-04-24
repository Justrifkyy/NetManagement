<x-app-layout>
    <div class="py-10 bg-slate-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-white mb-8 px-4 sm:px-0">Laporan & Log Sistem</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 px-4 sm:px-0">
                <a href="{{ route('admin.reports.index') }}" class="bg-slate-900 rounded-xl shadow-sm border border-slate-800 p-6 hover:shadow-md transition">
                    <h3 class="font-bold text-lg text-white mb-2">Laporan Pelanggan</h3>
                    <p class="text-slate-300 mb-4">Data rekap pelanggan baru, aktif, dan isolir dalam periode tertentu</p>
                    <a href="{{ route('admin.reports.customers') }}" class="inline-block px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 text-sm">Lihat Laporan</a>
                </a>

                <a href="{{ route('admin.reports.arrears') }}" class="bg-slate-900 rounded-xl shadow-sm border border-slate-800 p-6 hover:shadow-md transition">
                    <h3 class="font-bold text-lg text-white mb-2">Laporan Tunggakan</h3>
                    <p class="text-slate-300 mb-4">Daftar pelanggan dengan tagihan yang belum lunas</p>
                    <a href="{{ route('admin.reports.arrears') }}" class="inline-block px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 text-sm">Lihat Laporan</a>
                </a>

                <a href="{{ route('admin.logs.index') }}" class="bg-slate-900 rounded-xl shadow-sm border border-slate-800 p-6 hover:shadow-md transition">
                    <h3 class="font-bold text-lg text-white mb-2">Log Aktivasi</h3>
                    <p class="text-slate-300 mb-4">Riwayat pelanggan yang diaktifkan dalam sistem</p>
                    <a href="{{ route('admin.logs.index') }}" class="inline-block px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 text-sm">Lihat Log</a>
                </a>

                <a href="{{ route('admin.logs.index') }}" class="bg-slate-900 rounded-xl shadow-sm border border-slate-800 p-6 hover:shadow-md transition">
                    <h3 class="font-bold text-lg text-white mb-2">Log Isolasi</h3>
                    <p class="text-slate-300 mb-4">Riwayat pelanggan yang diisolir beserta alasannya</p>
                    <a href="{{ route('admin.logs.index') }}" class="inline-block px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 text-sm">Lihat Log</a>
                </a>

                <a href="{{ route('admin.reports.index') }}" class="bg-slate-900 rounded-xl shadow-sm border border-slate-800 p-6 hover:shadow-md transition">
                    <h3 class="font-bold text-lg text-white mb-2">Laporan Pendapatan</h3>
                    <p class="text-slate-300 mb-4">Total pendapatan dari pembayaran invoice dalam periode tertentu</p>
                    <a href="{{ route('admin.reports.index') }}" class="inline-block px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 text-sm">Lihat Laporan</a>
                </a>

                <a href="{{ route('admin.logs.index') }}" class="bg-slate-900 rounded-xl shadow-sm border border-slate-800 p-6 hover:shadow-md transition">
                    <h3 class="font-bold text-lg text-white mb-2">Activity Log</h3>
                    <p class="text-slate-300 mb-4">Log semua aktivitas yang dilakukan di dalam sistem</p>
                    <a href="{{ route('admin.logs.index') }}" class="inline-block px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 text-sm">Lihat Log</a>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
