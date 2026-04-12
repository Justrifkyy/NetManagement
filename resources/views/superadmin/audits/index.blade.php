<x-app-layout>
    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-8 px-4 sm:px-0">Audit & Keamanan</h2>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 px-4 sm:px-0 mb-6">
                <h3 class="font-bold mb-4">Filter Log</h3>
                <form method="GET" class="flex flex-col md:flex-row gap-4">
                    <select name="user_id" class="px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="">Semua User</option>
                    </select>
                    <input type="text" name="action" placeholder="Cari aksi..." 
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg"
                        value="{{ request('action') }}">
                    <input type="date" name="date_from" 
                        class="px-4 py-2 border border-gray-300 rounded-lg"
                        value="{{ request('date_from') }}">
                    <input type="date" name="date_to" 
                        class="px-4 py-2 border border-gray-300 rounded-lg"
                        value="{{ request('date_to') }}">
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Filter</button>
                </form>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden px-4 sm:px-0">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Aksi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">IP Address</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Waktu</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($logs as $log)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $log->user->name ?? 'System' }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ str_replace('_', ' ', strtoupper($log->action)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $log->ip_address }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $log->created_at->format('d-m-Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">Tidak ada log</td>
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
