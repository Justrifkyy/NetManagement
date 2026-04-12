<x-app-layout>
    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8 px-4 sm:px-0 flex flex-col md:flex-row justify-between items-start md:items-center">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900">Manajemen Pelanggan</h2>
                    <p class="text-gray-500 mt-1">Kelola status layanan, aktivasi, dan isolir pelanggan.</p>
                </div>
            </div>

            @if ($message = Session::get('success'))
                <div class="mb-4 px-4 sm:px-0">
                    <div class="rounded-xl bg-green-50 p-4 border border-green-200">
                        <p class="text-green-700">{{ $message }}</p>
                    </div>
                </div>
            @endif

            <!-- Search & Filter -->
            <div class="mb-6 px-4 sm:px-0">
                <form action="{{ route('admin.customers.index') }}" method="GET" class="flex gap-4">
                    <input type="text" name="search" placeholder="Cari pelanggan..." 
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                        value="{{ request('search') }}">
                    <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                </form>
            </div>

            <!-- Customers Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden px-4 sm:px-0">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Kode Pelanggan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">No. HP</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($customers as $customer)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $customer->customer_code }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $customer->user->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $customer->phone_number }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        @if ($customer->is_isolated)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Isolir
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Aktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium">
                                        <div class="flex gap-2">
                                            <a href="{{ route('admin.customers.show', $customer) }}" 
                                                class="text-blue-600 hover:text-blue-900">Lihat</a>
                                            <a href="{{ route('admin.customers.edit', $customer) }}" 
                                                class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                            @if (!$customer->is_isolated)
                                                <form action="{{ route('admin.customers.isolate', $customer) }}" method="POST" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="reason" value="Admin request">
                                                    <button type="submit" class="text-red-600 hover:text-red-900"
                                                        onclick="return confirm('Isolir pelanggan ini?')">Isolir</button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.customers.activate', $customer) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-green-600 hover:text-green-900"
                                                        onclick="return confirm('Aktifkan pelanggan ini?')">Aktifkan</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                        Tidak ada data pelanggan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-6 px-4 sm:px-0">
                {{ $customers->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
