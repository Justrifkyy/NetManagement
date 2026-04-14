<x-app-layout>
    <div class="py-10 bg-blue-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex flex-col md:flex-row justify-between items-center mb-8 px-4 sm:px-0">
                <div class="mb-4 md:mb-0 text-center md:text-left">
                    <h2 class="text-3xl font-bold text-blue-900">Daftar Prospek (Leads)</h2>
                    <p class="text-blue-600 mt-1">Kelola data calon pelanggan & konversi penjualan.</p>
                </div>
                <div>
                    <a href="{{ route('marketing.leads.create') }}"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-yellow-400 to-yellow-500 border border-transparent rounded-full font-bold text-blue-900 tracking-widest hover:from-yellow-500 hover:to-yellow-600 shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        Tambah Prospek Baru
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div
                    class="mb-6 mx-4 sm:mx-0 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-r shadow-sm flex items-center animate-pulse">
                    <svg class="h-6 w-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="font-semibold">{{ session('success') }}</p>
                </div>
            @endif

            <div class="hidden md:block bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-blue-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-yellow-400 to-yellow-500 text-blue-900">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Pelanggan</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Paket Minat</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Lokasi Pasang
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @php /** @var \Illuminate\Support\Collection $leads */ @endphp
                        @forelse($leads as $lead)
                            <tr class="hover:bg-blue-50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div
                                                class="h-10 w-10 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-700 font-bold text-lg border border-yellow-300 uppercase">
                                                {{ substr($lead->name, 0, 1) }}
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-blue-900">{{ $lead->name }}</div>
                                            <div class="text-xs text-blue-600">{{ $lead?->phone ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-md bg-blue-100 text-blue-800 border border-blue-200">
                                        {{ $lead->package->name ?? 'Belum Pilih' }}
                                    </span>
                                    <div class="text-xs text-blue-600 mt-1">{{ $lead->created_at->format('d M Y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-blue-800 truncate max-w-xs"
                                        title="{{ $lead->address_installation }}">
                                        {{ Str::limit($lead->address_installation, 35) }}
                                    </div>
                                    <div class="text-xs text-blue-600">{{ $lead->district ?? '-' }},
                                        {{ $lead->city ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @php
                                        $statusClasses = [
                                            'prospek' => 'bg-blue-100 text-blue-800 border-blue-200',
                                            'survey' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                            'instalasi' => 'bg-blue-100 text-blue-800 border-blue-200',
                                            'aktif' => 'bg-green-100 text-green-800 border-green-200',
                                            'batal' => 'bg-red-100 text-red-800 border-red-200',
                                            'converted' => 'bg-green-100 text-green-800 border-green-200',
                                        ];
                                        $currentClass = $statusClasses[$lead->status] ?? 'bg-blue-100 text-blue-800';
                                    @endphp
                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full border {{ $currentClass }} uppercase tracking-wide">
                                        {{ ucfirst($lead->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('marketing.leads.show', $lead->id) }}"
                                            class="p-2 bg-white border border-blue-300 rounded-lg text-blue-600 hover:bg-blue-50 hover:text-blue-700 hover:border-blue-400 transition shadow-sm"
                                            title="Lihat Detail">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </a>

                                        @if ($lead->status !== 'converted')
                                            <a href="{{ route('marketing.leads.edit', $lead->id) }}"
                                                class="p-2 bg-white border border-slate-800 rounded-lg text-slate-700 hover:bg-yellow-50 hover:text-yellow-700 hover:border-yellow-300 transition shadow-sm"
                                                title="Edit Data">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                    </path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('marketing.leads.destroy', $lead->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini secara permanen?');">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 bg-white border border-slate-800 rounded-lg text-slate-700 hover:bg-red-50 hover:text-red-700 hover:border-red-300 transition shadow-sm"
                                                    title="Hapus Data">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </form>
                                            <form action="{{ route('marketing.leads.convert', $lead->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Proses ini akan membuat akun pelanggan dan tiket instalasi. Lanjutkan?');">
                                                @csrf
                                                <button type="submit"
                                                    class="p-2 bg-sky-100 border border-sky-200 rounded-lg text-sky-700 hover:bg-sky-600 hover:text-white transition shadow-sm font-bold flex items-center"
                                                    title="Convert to Customer">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @else
                                            <div
                                                class="ml-2 flex items-center text-xs text-green-700 font-bold border border-green-200 bg-green-50 px-3 py-2 rounded-lg">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Converted
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-slate-400 mb-2" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                            </path>
                                        </svg>
                                        <p>Belum ada data prospek. Silakan tambah baru.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="md:hidden space-y-4 px-4 sm:px-0">
                @php /** @var \Illuminate\Support\Collection $leads */ @endphp
                @forelse($leads as $lead)
                    <div class="bg-slate-900 rounded-xl shadow-md border border-slate-800 overflow-hidden relative">
                        <div class="absolute top-0 right-0 p-2">
                            @php
                                $mobileStatusColor = match ($lead->status) {
                                    'converted' => 'bg-purple-100 text-purple-700',
                                    'prospek' => 'bg-slate-800 text-slate-300',
                                    'survey' => 'bg-yellow-100 text-yellow-700',
                                    'instalasi' => 'bg-blue-100 text-blue-700',
                                    default => 'bg-slate-800 text-slate-300',
                                };
                            @endphp
                            <span
                                class="px-2 py-1 text-[10px] font-bold rounded-md uppercase {{ $mobileStatusColor }}">
                                {{ $lead->status }}
                            </span>
                        </div>

                        <div class="p-4 border-b border-slate-800 flex items-center bg-slate-950">
                            <div
                                class="h-10 w-10 rounded-full bg-sky-100 flex items-center justify-center text-sky-700 font-bold text-lg border border-sky-200 uppercase">
                                {{ substr($lead->name, 0, 1) }}
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-bold text-white">{{ $lead->name }}</h4>
                                <span class="text-xs text-slate-400 block">{{ $lead->phone }}</span>
                            </div>
                        </div>

                        <div class="p-4 space-y-2">
                            <div class="flex items-center text-sm">
                                <svg class="w-4 h-4 text-blue-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                <span
                                    class="text-blue-700 font-semibold text-xs bg-blue-50 px-2 py-0.5 rounded">{{ $lead->package->name ?? 'Tanpa Paket' }}</span>
                            </div>
                            <div class="flex items-start text-sm">
                                <svg class="w-4 h-4 text-slate-400 mr-2 mt-0.5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span class="text-slate-300 truncate text-xs">{{ $lead->address_installation }}</span>
                            </div>
                        </div>

                        <div
                            class="px-4 py-3 bg-slate-950 border-t border-slate-800 grid {{ $lead->status !== 'converted' ? 'grid-cols-4' : 'grid-cols-1' }} gap-2">
                            <a href="{{ route('marketing.leads.show', $lead->id) }}"
                                class="flex items-center justify-center p-2 bg-white border border-slate-800 rounded-lg text-slate-300 hover:bg-blue-50 hover:border-blue-200 hover:text-amber-400 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                            </a>
                            @if ($lead->status !== 'converted')
                                <a href="{{ route('marketing.leads.edit', $lead->id) }}"
                                    class="flex items-center justify-center p-2 bg-white border border-slate-800 rounded-lg text-slate-300 hover:bg-yellow-50 hover:border-yellow-200 hover:text-yellow-600 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                        </path>
                                    </svg>
                                </a>
                                <form action="{{ route('marketing.leads.destroy', $lead->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus?');" class="flex">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="w-full flex items-center justify-center p-2 bg-white border border-slate-800 rounded-lg text-slate-300 hover:bg-red-50 hover:border-red-200 hover:text-red-600 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </form>
                                <form action="{{ route('marketing.leads.convert', $lead->id) }}" method="POST"
                                    onsubmit="return confirm('Convert?');" class="flex">
                                    @csrf
                                    <button type="submit"
                                        class="w-full flex items-center justify-center p-2 bg-sky-100 border border-sky-200 rounded-lg text-sky-600 hover:bg-sky-600 hover:text-white transition font-bold">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                        </svg>
                                    </button>
                                </form>
                            @else
                                <div
                                    class="col-span-3 flex items-center justify-center text-xs text-green-700 font-bold bg-green-50 rounded-lg border border-green-200">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Selesai
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10 bg-slate-900 rounded-xl border border-slate-800">
                        <p class="text-slate-400">Belum ada data prospek.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
