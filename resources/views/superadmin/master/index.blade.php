<x-app-layout>
    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-8 px-4 sm:px-0">Data Master Sistem</h2>

            <!-- Master Areas -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8 px-4 sm:px-0">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Master Area</h3>

                    <div class="space-y-2 mb-6 max-h-64 overflow-y-auto">
                        @forelse ($masterAreas as $area)
                            <div class="flex justify-between items-center p-2 bg-gray-50 rounded">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $area->name }}</p>
                                    <p class="text-xs text-gray-600">{{ $area->code }}</p>
                                </div>
                                <form action="#" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:text-red-900 text-sm" onclick="return confirm('Hapus?')">Hapus</button>
                                </form>
                            </div>
                        @empty
                            <p class="text-gray-500 text-sm">Belum ada master area</p>
                        @endforelse
                    </div>

                    <form action="{{ route('superadmin.master.storeArea') }}" method="POST" class="space-y-3">
                        @csrf
                        <input type="text" name="name" placeholder="Nama Area" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                        <input type="text" name="code" placeholder="Kode Unik" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                        <button type="submit" class="w-full px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm">
                            Tambah Area
                        </button>
                    </form>
                </div>

                <!-- Master Marketing -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Master Marketing</h3>

                    <div class="space-y-2 mb-6 max-h-64 overflow-y-auto">
                        @forelse ($masterMarketings as $marketing)
                            <div class="flex justify-between items-center p-2 bg-gray-50 rounded">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $marketing->name }}</p>
                                    <p class="text-xs text-gray-600">{{ $marketing->code }}</p>
                                </div>
                                <form action="#" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:text-red-900 text-sm" onclick="return confirm('Hapus?')">Hapus</button>
                                </form>
                            </div>
                        @empty
                            <p class="text-gray-500 text-sm">Belum ada master marketing</p>
                        @endforelse
                    </div>

                    <form action="{{ route('superadmin.master.storeMarketing') }}" method="POST" class="space-y-3">
                        @csrf
                        <input type="text" name="name" placeholder="Nama Marketing" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                        <input type="text" name="code" placeholder="Kode" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                        <input type="text" name="phone" placeholder="No. HP" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                        <button type="submit" class="w-full px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm">
                            Tambah Marketing
                        </button>
                    </form>
                </div>
            </div>

            <!-- Master Technician -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 px-4 sm:px-0">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Master Teknisi</h3>

                <div class="overflow-x-auto mb-6">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="px-4 py-2 text-left">Nama</th>
                                <th class="px-4 py-2 text-left">No. HP</th>
                                <th class="px-4 py-2 text-left">Area</th>
                                <th class="px-4 py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($masterTechnicians as $tech)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3">{{ $tech->name }}</td>
                                    <td class="px-4 py-3">{{ $tech->phone }}</td>
                                    <td class="px-4 py-3">{{ $tech->area->name }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <form action="#" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-red-600 text-sm" onclick="return confirm('Hapus?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-6 text-center text-gray-500">Belum ada teknisi</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <form action="{{ route('superadmin.master.storeTechnician') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-3">
                    @csrf
                    <input type="text" name="name" placeholder="Nama Teknisi" required
                        class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    <input type="text" name="phone" placeholder="No. HP" required
                        class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    <select name="area_id" required
                        class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                        <option value="">Pilih Area</option>
                        @foreach ($masterAreas as $area)
                            <option value="{{ $area->id }}">{{ $area->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm">
                        Tambah
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
