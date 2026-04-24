<x-app-layout>
    <div class="py-8 bg-slate-950 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center">
                <div>
                    <h1 class="text-4xl font-bold text-white">Dashboard Super Admin</h1>
                    <p class="text-slate-400 mt-1 text-lg">Sistem teknis, statistik global, dan analisis mendalam</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-gradient-to-r from-purple-600 to-purple-800 text-white border border-purple-500/50">
                        <span class="flex w-2 h-2 bg-purple-300 rounded-full mr-3 animate-pulse"></span>
                        SUPER ADMIN PANEL
                    </span>
                </div>
            </div>

            <!-- Key Statistics -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-gradient-to-br from-blue-600/10 to-blue-600/5 rounded-xl p-6 border border-blue-500/30 hover:border-blue-500/60 transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-blue-400 uppercase tracking-wider">Total User</p>
                            <h3 class="text-3xl font-black text-white mt-2">{{ $stats['total_users'] }}</h3>
                        </div>
                        <div class="p-3 bg-blue-500/20 rounded-lg">
                            <svg class="w-8 h-8 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-amber-600/10 to-amber-600/5 rounded-xl p-6 border border-amber-500/30 hover:border-amber-500/60 transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-amber-400 uppercase tracking-wider">Staf/Pegawai</p>
                            <h3 class="text-3xl font-black text-white mt-2">{{ $stats['total_staffs'] }}</h3>
                        </div>
                        <div class="p-3 bg-amber-500/20 rounded-lg">
                            <svg class="w-8 h-8 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-green-600/10 to-green-600/5 rounded-xl p-6 border border-green-500/30 hover:border-green-500/60 transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-green-400 uppercase tracking-wider">Total Pelanggan</p>
                            <h3 class="text-3xl font-black text-white mt-2">{{ $stats['total_customers'] }}</h3>
                        </div>
                        <div class="p-3 bg-green-500/20 rounded-lg">
                            <svg class="w-8 h-8 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-red-600/10 to-red-600/5 rounded-xl p-6 border border-red-500/30 hover:border-red-500/60 transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-red-400 uppercase tracking-wider">Total Pendapatan</p>
                            <h3 class="text-2xl font-black text-white mt-2">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h3>
                        </div>
                        <div class="p-3 bg-red-500/20 rounded-lg">
                            <svg class="w-8 h-8 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8.16 2.75a.75.75 0 00-.328 1.456l3.492 1.746-4.8-1.2a.75.75 0 10-.368 1.456l6 1.5a.75.75 0 00.368-.056l2-1a.75.75 0 10-.672-1.344l-1.185.592-3.492-1.746a.75.75 0 00-.615-.178zM2.75 9.25a.75.75 0 000 1.5h14.5a.75.75 0 000-1.5H2.75z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row 1 -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- User by Role Chart -->
                <div class="bg-slate-900 rounded-xl border border-slate-800 p-6 hover:border-slate-700 transition shadow-lg">
                    <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" />
                        </svg>
                        Distribusi User Berdasarkan Role
                    </h3>
                    <div style="position: relative; height: 300px;">
                        <canvas id="userRoleChart"></canvas>
                    </div>
                </div>

                <!-- Subscription Status Chart -->
                <div class="bg-slate-900 rounded-xl border border-slate-800 p-6 hover:border-slate-700 transition shadow-lg">
                    <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v2a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a2 2 0 002 2h8a2 2 0 002-2V6H6v1z" clip-rule="evenodd" />
                        </svg>
                        Status Langganan
                    </h3>
                    <div style="position: relative; height: 300px;">
                        <canvas id="subscriptionChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Charts Row 2 -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Revenue Trend Chart -->
                <div class="bg-slate-900 rounded-xl border border-slate-800 p-6 hover:border-slate-700 transition shadow-lg">
                    <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" />
                        </svg>
                        Tren Pendapatan (12 Bulan Terakhir)
                    </h3>
                    <div style="position: relative; height: 300px;">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>

                <!-- User Growth Chart -->
                <div class="bg-slate-900 rounded-xl border border-slate-800 p-6 hover:border-slate-700 transition shadow-lg">
                    <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                        </svg>
                        Pertumbuhan User (7 Hari Terakhir)
                    </h3>
                    <div style="position: relative; height: 300px;">
                        <canvas id="userGrowthChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- System Status Row -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- System Health -->
                <div class="bg-slate-900 rounded-xl border border-slate-800 p-6 hover:border-slate-700 transition shadow-lg">
                    <h3 class="font-bold text-white mb-6 text-lg">Status Sistem</h3>
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm text-slate-300">Kesehatan Sistem</span>
                                <span class="text-sm font-bold text-green-400">{{ $stats['system_health'] }}%</span>
                            </div>
                            <div class="w-full h-3 bg-slate-800 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-green-500 to-green-400" style="width: {{ $stats['system_health'] }}%"></div>
                            </div>
                        </div>
                        <div class="pt-4 space-y-3 border-t border-slate-700">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-slate-400">Database Size</span>
                                <span class="text-sm font-semibold text-slate-200">{{ $stats['database_size'] }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-slate-400">Active Sessions</span>
                                <span class="text-sm font-semibold text-slate-200">{{ $stats['active_sessions'] }} sesi</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-slate-400">Last Updated</span>
                                <span class="text-sm font-semibold text-slate-200">{{ now()->format('H:i:s') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Services Status -->
                <div class="bg-slate-900 rounded-xl border border-slate-800 p-6 hover:border-slate-700 transition shadow-lg">
                    <h3 class="font-bold text-white mb-6 text-lg">Status Layanan Pihak Ketiga</h3>
                    <div class="space-y-3">
                        @foreach ($servicesStatus as $service => $status)
                            <div class="flex justify-between items-center p-3 bg-slate-800/50 rounded-lg border border-slate-700/50">
                                <span class="text-sm text-slate-300 font-medium capitalize">{{ str_replace('_', ' ', $service) }}</span>
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full {{ $status === 'operational' || $status === 'connected' || $status === 'active' ? 'bg-green-500 animate-pulse' : 'bg-red-500' }}"></div>
                                    <span class="text-xs font-semibold {{ $status === 'operational' || $status === 'connected' || $status === 'active' ? 'text-green-400' : 'text-red-400' }} uppercase">
                                        {{ ucfirst($status) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Recent Audit Logs -->
            <div class="bg-slate-900 rounded-xl border border-slate-800 p-6 hover:border-slate-700 transition shadow-lg">
                <h3 class="text-lg font-bold text-white mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 000-2H6a6 6 0 100 12H4a1 1 0 100 2 2 2 0 01-2-2V5zm15 7a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd" />
                    </svg>
                    Audit Log Terbaru
                </h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-slate-700">
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-300 uppercase tracking-wider">User</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-300 uppercase tracking-wider">Aksi</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-300 uppercase tracking-wider">Waktu</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700">
                            @forelse ($recentLogs as $log)
                                <tr class="hover:bg-slate-800/50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-amber-500 to-amber-600 flex items-center justify-center flex-shrink-0">
                                                <span class="text-white font-bold text-xs">{{ substr($log->user->name, 0, 1) }}</span>
                                            </div>
                                            <span class="font-medium text-white">{{ $log->user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-slate-300">{{ $log->action }}</td>
                                    <td class="px-6 py-4 text-slate-400 text-xs">{{ $log->created_at->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-8 text-center text-slate-400">Belum ada activity log</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Chart.js Configuration
        Chart.defaults.color = '#94a3b8';
        Chart.defaults.borderColor = '#334155';
        Chart.defaults.font.family = "'Figtree', system-ui, sans-serif";

        // 1. User by Role Chart (Doughnut)
        const userRoleCtx = document.getElementById('userRoleChart');
        if (userRoleCtx) {
            new Chart(userRoleCtx, {
                type: 'doughnut',
                data: {
                    labels: @json($userRoleChart['labels']),
                    datasets: [{
                        data: @json($userRoleChart['data']),
                        backgroundColor: @json($userRoleChart['backgroundColor']),
                        borderColor: '#1e293b',
                        borderWidth: 2,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 15,
                                font: { size: 12, weight: 'bold' }
                            }
                        }
                    }
                }
            });
        }

        // 2. Subscription Status Chart (Pie)
        const subscriptionCtx = document.getElementById('subscriptionChart');
        if (subscriptionCtx) {
            new Chart(subscriptionCtx, {
                type: 'pie',
                data: {
                    labels: @json($subscriptionChart['labels']),
                    datasets: [{
                        data: @json($subscriptionChart['data']),
                        backgroundColor: @json($subscriptionChart['backgroundColor']),
                        borderColor: '#1e293b',
                        borderWidth: 2,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 15,
                                font: { size: 12, weight: 'bold' }
                            }
                        }
                    }
                }
            });
        }

        // 3. Revenue Trend Chart (Line)
        const revenueCtx = document.getElementById('revenueChart');
        if (revenueCtx) {
            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: @json($revenueChart['labels']),
                    datasets: [{
                        label: 'Pendapatan',
                        data: @json($revenueChart['data']),
                        backgroundColor: @json($revenueChart['backgroundColor']),
                        borderColor: @json($revenueChart['borderColor']),
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#8b5cf6',
                        pointBorderColor: '#1e293b',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            labels: {
                                padding: 15,
                                font: { size: 12, weight: 'bold' }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });
        }

        // 4. User Growth Chart (Bar)
        const userGrowthCtx = document.getElementById('userGrowthChart');
        if (userGrowthCtx) {
            new Chart(userGrowthCtx, {
                type: 'bar',
                data: {
                    labels: @json($userGrowthChart['labels']),
                    datasets: [{
                        label: 'User Baru',
                        data: @json($userGrowthChart['data']),
                        backgroundColor: @json($userGrowthChart['backgroundColor']),
                        borderColor: @json($userGrowthChart['borderColor']),
                        borderWidth: 2,
                        borderRadius: 8,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            labels: {
                                padding: 15,
                                font: { size: 12, weight: 'bold' }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                        }
                    }
                }
            });
        }
    </script>
    @endpush
</x-app-layout>
