<x-app-layout>
    <div class="py-10 bg-slate-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8 px-4 sm:px-0 flex flex-col md:flex-row justify-between items-start md:items-center">
                <div>
                    <h2 class="text-3xl font-black text-white">Manajemen Lead Marketing</h2>
                    <p class="text-slate-400 mt-1">Kelola semua prospek dan lead penjualan</p>
                </div>
                <a href="{{ route('admin.leads.create') }}" class="mt-4 md:mt-0 px-4 py-2 bg-amber-500 text-slate-900 font-bold rounded-lg hover:bg-amber-400 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Buat Lead Baru
                </a>
            </div>

            @if (session('success'))
                <div class="mb-4 px-4 sm:px-0 rounded-xl bg-green-900/20 p-4 border border-green-800">
                    <p class="text-green-400">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Filters -->
            <div class="bg-slate-900 rounded-xl shadow-lg border border-slate-800 p-6 mb-6 px-4 sm:px-0">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-300 mb-1">Pencarian Nama/No.</label>
                        <input type="text" name="search" placeholder="Nama / No. Telepon" value="{{ request('search') }}"
                            class="w-full px-3 py-2 border border-slate-700 bg-slate-800 text-white rounded-lg text-sm focus:outline-none focus:ring-amber-500">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-300 mb-1">Status</label>
                        <select name="status" class="w-full px-3 py-2 border border-slate-700 bg-slate-800 text-white rounded-lg text-sm focus:outline-none focus:ring-amber-500">
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
                        <label class="block text-sm font-bold text-slate-300 mb-1">Marketing</label>
                        <select name="marketing_id" class="w-full px-3 py-2 border border-slate-700 bg-slate-800 text-white rounded-lg text-sm focus:outline-none focus:ring-amber-500">
                            <option value="">Semua</option>
                            @foreach ($marketers as $marketer)
                                <option value="{{ $marketer->id }}" @selected(request('marketing_id') === (string)$marketer->id)>
                                    {{ $marketer->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end gap-2">
                        <button type="submit" class="flex-1 px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 text-sm font-medium">
                            Filter
                        </button>
                        <a href="{{ route('admin.leads.index') }}" class="px-4 py-2 border border-slate-700 bg-slate-800 rounded-lg hover:bg-slate-700 text-slate-300 text-sm font-bold">
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
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-300 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-300 uppercase tracking-wider">Kontak</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-300 uppercase tracking-wider">Paket</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-300 uppercase tracking-wider">Marketing</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-300 uppercase tracking-wider">Tgl Follow-up</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-300 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @php /** @var \Illuminate\Support\Collection $leads */ @endphp
                            @forelse ($leads as $lead)
                                <tr class="hover:bg-slate-950 transition">
                                    <td class="px-6 py-4 text-sm font-medium text-white">{{ $lead->name }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        <div class="font-medium text-white">{{ $lead?->phone ?? '-' }}</div>
                                        <div class="text-xs text-slate-400">{{ $lead?->email ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        @if ($lead->package)
                                            <span class="text-white">{{ $lead->package->name }}</span>
                                        @else
                                            <span class="text-slate-400 text-xs">Belum dipilih</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <x-status-badge :status="$lead->status" variant="sm" />
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-300">{{ $lead->marketing->name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-300">
                                        @if ($lead->survey_date)
                                            {{ \Carbon\Carbon::parse($lead->survey_date)->format('d M Y') }}
                                        @else
                                            <span class="text-slate-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <div class="flex gap-2">
                                            <a href="{{ route('admin.leads.show', $lead) }}" class="text-amber-400 hover:text-amber-300 font-medium text-xs" title="Lihat Detail">👁️</a>
                                            <a href="{{ route('admin.leads.edit', $lead) }}" class="text-yellow-600 hover:text-yellow-900 font-medium text-xs" title="Edit">Edit</a>
                                            <form action="{{ route('admin.leads.destroy', $lead) }}" method="POST" class="inline" onsubmit="return confirm('Hapus lead ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 font-medium text-xs" title="Hapus">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-slate-400">
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
                @if($leads instanceof \Illuminate\Pagination\Paginator)
                    {{ $leads->links() }}
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
