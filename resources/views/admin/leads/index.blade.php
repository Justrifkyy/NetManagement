<x-app-layout>
    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8 px-4 sm:px-0 flex flex-col md:flex-row justify-between items-start md:items-center">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900">Manajemen Lead Marketing</h2>
                    <p class="text-gray-500 mt-1">Kelola semua prospek dan lead penjualan</p>
                </div>
                <a href="{{ route('admin.leads.create') }}" class="mt-4 md:mt-0 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Buat Lead Baru
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
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pencarian Nama/No.</label>
                        <input type="text" name="search" placeholder="Nama / No. Telepon" value="{{ request('search') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-blue-500">
                            <option value="">Semua Status</option>
                            <option value="prospect" @selected(request('status') === 'prospect')>Prospek</option>
                            <option value="contacted" @selected(request('status') === 'contacted')>Sudah Dihubungi</option>
                            <option value="qualified" @selected(request('status') === 'qualified')>Qualified</option>
                            <option value="proposal_sent" @selected(request('status') === 'proposal_sent')>Penawaran Dikirim</option>
                            <option value="negotiation" @selected(request('status') === 'negotiation')>Negosiasi</option>
                            <option value="converted" @selected(request('status') === 'converted')>Konversi</option>
                            <option value="lost" @selected(request('status') === 'lost')>Hilang</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Marketing</label>
                        <select name="marketing_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-blue-500">
                            <option value="">Semua</option>
                            @foreach ($marketers as $marketer)
                                <option value="{{ $marketer->id }}" @selected(request('marketing_id') === (string)$marketer->id)>
                                    {{ $marketer->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end gap-2">
                        <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium">
                            Filter
                        </button>
                        <a href="{{ route('admin.leads.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm font-medium">
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
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Kontak</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Paket</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Marketing</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Tgl Follow-up</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($leads as $lead)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $lead->name }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        <div class="font-medium text-gray-900">{{ $lead->phone }}</div>
                                        <div class="text-xs text-gray-500">{{ $lead->email ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        @if ($lead->package)
                                            <span class="text-gray-900">{{ $lead->package->name }}</span>
                                        @else
                                            <span class="text-gray-500 text-xs">Belum dipilih</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <x-status-badge :status="$lead->status" variant="sm" />
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $lead->marketing->name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        @if ($lead->survey_date)
                                            {{ \Carbon\Carbon::parse($lead->survey_date)->format('d M Y') }}
                                        @else
                                            <span class="text-gray-500">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <div class="flex gap-2">
                                            <a href="{{ route('admin.leads.show', $lead) }}" class="text-blue-600 hover:text-blue-900 font-medium text-xs" title="Lihat Detail">👁️</a>
                                            <a href="{{ route('admin.leads.edit', $lead) }}" class="text-yellow-600 hover:text-yellow-900 font-medium text-xs" title="Edit">✏️</a>
                                            <form action="{{ route('admin.leads.destroy', $lead) }}" method="POST" class="inline" onsubmit="return confirm('Hapus lead ini?')">
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
                                        Tidak ada lead
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-6 px-4 sm:px-0">
                {{ $leads->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
