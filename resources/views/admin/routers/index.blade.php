<x-app-layout>
    <div class="py-10 bg-slate-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8 px-4 sm:px-0 flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-extrabold text-white">Manajemen Perangkat Jaringan</h2>
                    <p class="text-slate-400 mt-1">Kelola router, OLT, dan perangkat jaringan lainnya.</p>
                </div>
                <a href="{{ route('admin.routers.create') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg">
                    + Tambah Perangkat
                </a>
            </div>

            <div class="bg-slate-900 rounded-xl shadow-sm border border-slate-800 overflow-hidden px-4 sm:px-0">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-950 border-b border-slate-800">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-300 uppercase">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-300 uppercase">Lokasi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-300 uppercase">IP Address</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-300 uppercase">Tipe</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-300 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-300 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($routers as $router)
                                <tr class="hover:bg-slate-950">
                                    <td class="px-6 py-4 text-sm font-medium text-white">{{ $router->name }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-300">{{ $router->location }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-300">{{ $router->ip_address }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-300">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $router->type }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        @if ($router->is_active)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-800 text-white">
                                                Nonaktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <div class="flex gap-2">
                                            <a href="{{ route('admin.routers.edit', $router) }}" class="text-amber-400">Edit</a>
                                            <form action="{{ route('admin.routers.destroy', $router) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600" onclick="return confirm('Hapus?')">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-slate-400">Tidak ada perangkat</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6 px-4 sm:px-0">
                {{ $routers->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
