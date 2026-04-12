<x-app-layout>
    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8 px-4 sm:px-0 flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900">Manajemen Paket</h2>
                    <p class="text-gray-500 mt-1">Kelola katalog produk internet dan paket layanan.</p>
                </div>
                <a href="{{ route('admin.packages.create') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                    + Tambah Paket
                </a>
            </div>

            @if ($message = Session::get('success'))
                <div class="mb-4 px-4 sm:px-0">
                    <div class="rounded-xl bg-green-50 p-4 border border-green-200">
                        <p class="text-green-700">{{ $message }}</p>
                    </div>
                </div>
            @endif

            <!-- Packages Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 px-4 sm:px-0">
                @forelse ($packages as $package)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">{{ $package->name }}</h3>
                                <p class="text-2xl font-bold text-purple-600 mt-2">Rp {{ number_format($package->price, 0, ',', '.') }}/bulan</p>
                            </div>
                            @if ($package->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    Nonaktif
                                </span>
                            @endif
                        </div>

                        <div class="space-y-2 mb-4">
                            <p class="text-sm text-gray-700"><strong>Kecepatan:</strong> {{ $package->speed_mbps }} Mbps</p>
                            <p class="text-sm text-gray-700"><strong>Biaya Pasang:</strong> Rp {{ number_format($package->installation_fee, 0, ',', '.') }}</p>
                            @if ($package->description)
                                <p class="text-sm text-gray-600 mt-2">{{ $package->description }}</p>
                            @endif
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('admin.packages.edit', $package) }}" 
                                class="flex-1 px-3 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 text-center">
                                Edit
                            </a>
                            <form action="{{ route('admin.packages.destroy', $package) }}" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full px-3 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700"
                                    onclick="return confirm('Hapus paket ini?')">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500">Tidak ada paket</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-6 px-4 sm:px-0">
                {{ $packages->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
