<x-app-layout>
    <div class="py-10 bg-sky-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex flex-col md:flex-row justify-between items-center mb-8 px-4 sm:px-0">
                <div class="mb-4 md:mb-0 text-center md:text-left">
                    <h2 class="text-3xl font-bold text-gray-800">Daftar Prospek (Leads)</h2>
                    <p class="text-gray-500 mt-1">Kelola data calon pelanggan & konversi.</p>
                </div>
                <div>
                    <a href="{{ route('marketing.leads.create') }}"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-sky-500 to-blue-600 border border-transparent rounded-full font-bold text-white tracking-widest hover:from-sky-600 hover:to-blue-700 shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Tambah Prospek
                    </a>
                </div>
            </div>

            @if(session('success'))
            <div class="mb-6 mx-4 sm:mx-0 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-r shadow-sm flex items-center">
                <svg class="h-6 w-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p>{{ session('success') }}</p>
            </div>
            @endif

            <div class="hidden md:block bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-sky-600 to-blue-600">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Pelanggan</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Kontak</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Lokasi</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($leads as $lead)
                        <tr class="hover:bg-sky-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-sky-100 flex items-center justify-center text-sky-700 font-bold text-lg border border-sky-200">
                                            {{ substr($lead->name, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-bold text-gray-900">{{ $lead->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $lead->created_at->format('d M Y') }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 font-medium">{{ $lead->phone }}</div>
                                <div class="text-xs text-gray-400">Darurat: {{ $lead->emergency_phone ?? '-' }}</div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-700 truncate max-w-xs" title="{{ $lead->address_installation }}">
                                    {{ Str::limit($lead->address_installation, 30) }}
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $lead->status === 'converted' ? 'bg-green-100 text-green-800 border border-green-200' : '' }}
                                    {{ $lead->status === 'new' ? 'bg-blue-100 text-blue-800 border border-blue-200' : '' }}
                                    {{ $lead->status === 'follow_up' ? 'bg-yellow-100 text-yellow-800 border border-yellow-200' : '' }}">
                                    {{ ucfirst($lead->status) }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    
                                    <a href="{{ route('marketing.leads.show', $lead->id) }}" class="p-2 bg-gray-100 text-gray-600 rounded-full hover:bg-blue-100 hover:text-blue-600 transition" title="Lihat Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>

                                    @if($lead->status !== 'converted')
                                        <a href="{{ route('marketing.leads.edit', $lead->id) }}" class="p-2 bg-gray-100 text-gray-600 rounded-full hover:bg-yellow-100 hover:text-yellow-600 transition" title="Edit Data">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </a>

                                        <form action="{{ route('marketing.leads.destroy', $lead->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini secara permanen?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 bg-gray-100 text-gray-600 rounded-full hover:bg-red-100 hover:text-red-600 transition" title="Hapus Data">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>

                                        <form action="{{ route('marketing.leads.convert', $lead->id) }}" method="POST" onsubmit="return confirm('Proses ini akan membuat akun pelanggan dan tiket instalasi. Lanjutkan?');">
                                            @csrf
                                            <button type="submit" class="p-2 bg-sky-100 text-sky-600 rounded-full hover:bg-sky-600 hover:text-white transition shadow-sm" title="Convert to Customer">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                            </button>
                                        </form>
                                    @else
                                        <div class="ml-2 flex items-center text-xs text-green-600 font-bold border border-green-200 bg-green-50 px-2 py-1 rounded">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Selesai
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500">Belum ada data prospek.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="md:hidden space-y-4 px-4 sm:px-0">
                @forelse($leads as $lead)
                <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
                    <div class="p-4 border-b border-gray-50 flex justify-between items-center bg-gray-50">
                        <div class="flex items-center">
                            <div class="h-8 w-8 rounded-full bg-sky-100 flex items-center justify-center text-sky-700 font-bold text-sm border border-sky-200">
                                {{ substr($lead->name, 0, 1) }}
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-bold text-gray-800">{{ $lead->name }}</h4>
                                <span class="text-xs text-gray-500">{{ $lead->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <span class="px-2 py-1 text-xs font-bold rounded-full 
                            {{ $lead->status === 'converted' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $lead->status === 'new' ? 'bg-blue-100 text-blue-700' : '' }}
                            {{ $lead->status === 'follow_up' ? 'bg-yellow-100 text-yellow-700' : '' }}">
                            {{ ucfirst($lead->status) }}
                        </span>
                    </div>
                    
                    <div class="p-4 space-y-2">
                        <div class="flex items-start text-sm">
                            <svg class="w-4 h-4 text-gray-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span class="text-gray-600">{{ $lead->phone }}</span>
                        </div>
                        <div class="flex items-start text-sm">
                            <svg class="w-4 h-4 text-gray-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span class="text-gray-600 truncate">{{ $lead->address_installation }}</span>
                        </div>
                    </div>

                    <div class="px-4 py-3 bg-gray-50 border-t border-gray-100 grid {{ $lead->status !== 'converted' ? 'grid-cols-4' : 'grid-cols-1' }} gap-2">
                        <a href="{{ route('marketing.leads.show', $lead->id) }}" class="flex items-center justify-center p-2 bg-white border border-gray-200 rounded-lg text-gray-600 hover:bg-blue-50 hover:border-blue-200 hover:text-blue-600 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </a>

                        @if($lead->status !== 'converted')
                            <a href="{{ route('marketing.leads.edit', $lead->id) }}" class="flex items-center justify-center p-2 bg-white border border-gray-200 rounded-lg text-gray-600 hover:bg-yellow-50 hover:border-yellow-200 hover:text-yellow-600 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </a>
                            <form action="{{ route('marketing.leads.destroy', $lead->id) }}" method="POST" onsubmit="return confirm('Hapus?');" class="flex">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-full flex items-center justify-center p-2 bg-white border border-gray-200 rounded-lg text-gray-600 hover:bg-red-50 hover:border-red-200 hover:text-red-600 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                            <form action="{{ route('marketing.leads.convert', $lead->id) }}" method="POST" onsubmit="return confirm('Convert?');" class="flex">
                                @csrf
                                <button type="submit" class="w-full flex items-center justify-center p-2 bg-sky-100 border border-sky-200 rounded-lg text-sky-600 hover:bg-sky-600 hover:text-white transition font-bold">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
                @empty
                <div class="text-center py-10 bg-white rounded-xl border border-gray-100">
                    <p class="text-gray-500">Belum ada data prospek.</p>
                </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>