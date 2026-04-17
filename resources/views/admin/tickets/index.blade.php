<x-app-layout>
    <div class="py-10 bg-slate-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8 px-4 sm:px-0 flex flex-col md:flex-row justify-between items-start md:items-center">
                <div>
                    <h2 class="text-3xl font-extrabold text-white">Manajemen Tiket Teknisi</h2>
                    <p class="text-slate-400 mt-1">Kelola semua tiket survey, instalasi, dan perbaikan</p>
                </div>
                <a href="{{ route('admin.tickets.create') }}" class="mt-4 md:mt-0 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Buat Tiket Baru
                </a>
            </div>

            @if (session('success'))
                <div class="mb-6 mx-4 sm:mx-0 bg-green-900/50 border border-green-500 text-green-300 p-4 rounded-lg">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <!-- Filters -->
            <div class="bg-slate-900 rounded-xl shadow-sm border border-slate-800 p-6 mb-6 px-4 sm:px-0">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1">Status</label>
                        <select name="status" class="w-full px-3 py-2 border border-slate-700 rounded-lg text-sm focus:outline-none focus:ring-purple-500">
                            <option value="">Semua Status</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1">Tipe</label>
                        <select name="type" class="w-full px-3 py-2 border border-slate-700 rounded-lg text-sm focus:outline-none focus:ring-purple-500">
                            <option value="">Semua Tipe</option>
                            @foreach ($types as $type)
                                <option value="{{ $type }}" @selected(request('type') === $type)>{{ ucfirst($type) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1">Pelanggan</label>
                        <select name="customer_id" class="w-full px-3 py-2 border border-slate-700 rounded-lg text-sm focus:outline-none focus:ring-purple-500">
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
                        <a href="{{ route('admin.tickets.index') }}" class="px-4 py-2 border border-slate-700 rounded-lg hover:bg-slate-950 text-sm font-medium">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Table -->
            <div class="bg-slate-900 rounded-xl shadow-sm border border-slate-800 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-950 border-b border-slate-800">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-300 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-300 uppercase tracking-wider">Pelanggan</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-300 uppercase tracking-wider">Tipe</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-300 uppercase tracking-wider">Subjek</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-300 uppercase tracking-wider">Teknisi</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-300 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($tickets as $ticket)
                                <tr class="hover:bg-slate-950 transition">
                                    <td class="px-6 py-4 text-sm font-medium text-white">#{{ $ticket->id }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        <div class="font-medium text-white">{{ $ticket->customer->user->name }}</div>
                                        <div class="text-xs text-slate-400">{{ $ticket->customer->phone_number }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium @switch($ticket->type)
                                            @case('survey') bg-blue-900 text-blue-200 @break
                                            @case('installation') bg-green-900 text-green-200 @break
                                            @case('troubleshoot') bg-amber-900 text-amber-200 @break
                                            @default bg-slate-700 text-slate-100
                                        @endswitch">
                                            {{ ucfirst($ticket->type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-300">{{ $ticket->subject }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium @switch($ticket->status)
                                            @case('open') bg-red-900 text-red-200 @break
                                            @case('assigned') bg-blue-900 text-blue-200 @break
                                            @case('in_progress') bg-amber-900 text-amber-200 @break
                                            @case('resolved') bg-green-900 text-green-200 @break
                                            @case('closed') bg-slate-700 text-slate-100 @break
                                        @endswitch">
                                            {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        @if ($ticket->technician)
                                            <span class="text-white">{{ $ticket->technician->name }}</span>
                                        @else
                                            <span class="text-slate-400 text-xs">Belum ditugaskan</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <div class="flex gap-2">
                                            <a href="{{ route('admin.tickets.show', $ticket) }}" class="text-cyan-400 hover:text-cyan-300 font-medium text-xs" title="Lihat Detail">👁️</a>
                                            <a href="{{ route('admin.tickets.edit', $ticket) }}" class="text-purple-400 hover:text-purple-300 font-medium text-xs" title="Edit">Edit</a>
                                            <form action="{{ route('admin.tickets.destroy', $ticket) }}" method="POST" class="inline" onsubmit="return confirm('Hapus tiket ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-400 hover:text-red-300 font-medium text-xs" title="Hapus">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-slate-400">
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
