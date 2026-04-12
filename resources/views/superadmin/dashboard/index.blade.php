<x-app-layout>
    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8 px-4 sm:px-0 flex flex-col md:flex-row justify-between items-start md:items-center">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900">Dashboard Super Admin</h2>
                    <p class="text-gray-500 mt-1">Sistem teknis, statistik global, dan status layanan</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800 border border-red-200">
                        <span class="flex w-2 h-2 bg-red-600 rounded-full mr-2"></span>
                        SUPER ADMIN
                    </span>
                </div>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 px-4 sm:px-0 mb-8">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <p class="text-xs font-bold text-gray-400 uppercase">Total User</p>
                    <h3 class="text-3xl font-black text-gray-800 mt-1">{{ $stats['total_users'] }}</h3>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <p class="text-xs font-bold text-gray-400 uppercase">Staf/Pegawai</p>
                    <h3 class="text-3xl font-black text-gray-800 mt-1">{{ $stats['total_staffs'] }}</h3>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <p class="text-xs font-bold text-gray-400 uppercase">Total Pelanggan</p>
                    <h3 class="text-3xl font-black text-gray-800 mt-1">{{ $stats['total_customers'] }}</h3>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <p class="text-xs font-bold text-gray-400 uppercase">Total Pendapatan</p>
                    <h3 class="text-2xl font-black text-gray-800 mt-1">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h3>
                </div>
            </div>

            <!-- System Health & Services -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 px-4 sm:px-0 mb-8">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Status Sistem</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-700">Kesehatan Sistem</span>
                            <div class="flex items-center gap-2">
                                <div class="w-32 h-2 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-green-500" style="width: {{ $stats['system_health'] }}%"></div>
                                </div>
                                <span class="text-sm font-bold">{{ $stats['system_health'] }}%</span>
                            </div>
                        </div>
                        <div class="text-sm text-gray-600">Ukuran Database: {{ $stats['database_size'] }}</div>
                        <div class="text-sm text-gray-600">Sesi Aktif: {{ $stats['active_sessions'] }}</div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Status Layanan Pihak Ketiga</h3>
                    <div class="space-y-2">
                        @foreach ($servicesStatus as $service => $status)
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-700 capitalize">{{ str_replace('_', ' ', $service) }}</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ ucfirst($status) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Recent Audit Logs -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 px-4 sm:px-0">
                <h3 class="font-bold text-gray-900 mb-4">Audit Log Terbaru</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Aksi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Waktu</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($recentLogs as $log)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-3 text-gray-900 font-medium">{{ $log->user->name }}</td>
                                    <td class="px-6 py-3 text-gray-700">{{ $log->action }}</td>
                                    <td class="px-6 py-3 text-gray-600">{{ $log->created_at->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-8 text-center text-gray-500">Belum ada log</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
