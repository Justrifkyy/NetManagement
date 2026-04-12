<x-app-layout>
    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8 px-4 sm:px-0 flex flex-col md:flex-row justify-between items-start md:items-center">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900">Manajemen Tiket Teknisi</h2>
                    <p class="text-gray-500 mt-1">Kelola semua tiket survey, instalasi, dan perbaikan</p>
                </div>
                <a href="{{ route('admin.tickets.create') }}" class="mt-4 md:mt-0 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Buat Tiket Baru
                </a>
            </div>

            @if (session('success'))
                <div class="mb-4 px-4 sm:px-0 rounded-xl bg-green-50 p-4 border border-green-200">
                    <p class="text-green-700">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Filters -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6 px-4 sm:px-0">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-purple-500">
                            <option value="">Semua Status</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipe</label>
                        <select name="type" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-purple-500">
                            <option value="">Semua Tipe</option>
                            @foreach ($types as $type)
                                <option value="{{ $type }}" @selected(request('type') === $type)>{{ ucfirst($type) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pelanggan</label>
                        <select name="customer_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-purple-500">
                            <option value="">Semua Pelanggan</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}" @selected(request('customer_id') === (string)$customer->id)>
                                    {{ $customer->user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end gap-2">
                        <button type="submit" class="flex-1 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 text-sm font-medium">
                            Filter
                        </button>
                        <a href="{{ route('admin.tickets.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm font-medium">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Pelanggan</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Tipe</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Subjek</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Teknisi</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($tickets as $ticket)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">#{{ $ticket->id }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        <div class="font-medium text-gray-900">{{ $ticket->customer->user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $ticket->customer->phone_number }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium @switch($ticket->type)
                                            @case('survey') bg-blue-100 text-blue-800 @break
                                            @case('installation') bg-green-100 text-green-800 @break
                                            @case('troubleshoot') bg-yellow-100 text-yellow-800 @break
                                            @default bg-gray-100 text-gray-800
                                        @endswitch">
                                            {{ ucfirst($ticket->type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $ticket->subject }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium @switch($ticket->status)
                                            @case('open') bg-red-100 text-red-800 @break
                                            @case('assigned') bg-blue-100 text-blue-800 @break
                                            @case('in_progress') bg-yellow-100 text-yellow-800 @break
                                            @case('resolved') bg-green-100 text-green-800 @break
                                            @case('closed') bg-gray-100 text-gray-800 @break
                                        @endswitch">
                                            {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        @if ($ticket->technician)
                                            <span class="text-gray-900">{{ $ticket->technician->name }}</span>
                                        @else
                                            <span class="text-gray-500 text-xs">Belum ditugaskan</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <div class="flex gap-2">
                                            <a href="{{ route('admin.tickets.show', $ticket) }}" class="text-blue-600 hover:text-blue-900 font-medium text-xs" title="Lihat Detail">👁️</a>
                                            <a href="{{ route('admin.tickets.edit', $ticket) }}" class="text-yellow-600 hover:text-yellow-900 font-medium text-xs" title="Edit">✏️</a>
                                            <form action="{{ route('admin.tickets.destroy', $ticket) }}" method="POST" class="inline" onsubmit="return confirm('Hapus tiket ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 font-medium text-xs" title="Hapus">🗑️</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                        Tidak ada tiket
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-6 px-4 sm:px-0">
                {{ $tickets->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
