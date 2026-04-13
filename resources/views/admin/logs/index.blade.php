<x-app-layout>
    <div class="py-10 bg-slate-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-white mb-8 px-4 sm:px-0">Activity Log Sistem</h2>

            <div class="bg-slate-900 rounded-xl shadow-sm border border-slate-800 p-6 px-4 sm:px-0 mb-6">
                <h3 class="font-bold mb-4">Filter Log</h3>
                <form method="GET" class="flex flex-col md:flex-row gap-4">
                    <input type="text" name="action" placeholder="Cari aksi..." 
                        class="px-4 py-2 border border-slate-700 rounded-lg"
                        value="{{ request('action') }}">
                    <input type="date" name="date_from" 
                        class="px-4 py-2 border border-slate-700 rounded-lg"
                        value="{{ request('date_from') }}">
                    <input type="date" name="date_to" 
                        class="px-4 py-2 border border-slate-700 rounded-lg"
                        value="{{ request('date_to') }}">
                    <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">Filter</button>
                    <a href="{{ route('admin.logs.index') }}" class="px-4 py-2 border border-slate-700 rounded-lg hover:bg-slate-950">Reset</a>
                </form>
            </div>

            <div class="bg-slate-900 rounded-xl shadow-sm border border-slate-800 overflow-hidden px-4 sm:px-0">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-950 border-b border-slate-800">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-300 uppercase">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-300 uppercase">Aksi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-300 uppercase">Deskripsi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-300 uppercase">Waktu</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-300 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($logs as $log)
                                <tr class="hover:bg-slate-950">
                                    <td class="px-6 py-4 text-sm font-medium text-white">{{ $log->user->name ?? 'System' }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ str_replace('_', ' ', strtoupper($log->action)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-300">{{ substr($log->description, 0, 50) }}...</td>
                                    <td class="px-6 py-4 text-sm text-slate-300">{{ $log->created_at->format('d-m-Y H:i') }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        <a href="{{ route('admin.logs.show', $log) }}" class="text-amber-400 hover:text-amber-300">Lihat Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-slate-400">Tidak ada log</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6 px-4 sm:px-0">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
