<x-app-layout>
    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-8 px-4 sm:px-0">Integrasi Layanan Pihak Ketiga</h2>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 px-4 sm:px-0">
                @forelse ($integrations as $integration)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h3 class="font-bold text-lg text-gray-900 mb-4">{{ $integration->service_name }}</h3>
                        <div class="space-y-2 mb-4">
                            <p class="text-sm text-gray-600"><strong>API Key:</strong> •••••••••••</p>
                            @if ($integration->webhook_url)
                                <p class="text-sm text-gray-600"><strong>Webhook:</strong> Terkonfigurasi</p>
                            @endif
                            <p class="text-sm mt-2">
                                @if ($integration->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Aktif</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Nonaktif</span>
                                @endif
                            </p>
                        </div>
                        <div class="flex gap-2">
                            <button onclick="testConnection({{ $integration->id }})" class="flex-1 px-3 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">Test</button>
                            <button onclick="editIntegration({{ $integration->id }})" class="flex-1 px-3 py-2 bg-yellow-600 text-white text-sm rounded-lg hover:bg-yellow-700">Edit</button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500">Belum ada integrasi</p>
                    </div>
                @endforelse
            </div>

            <!-- Add New Integration -->
            <div class="mt-8 bg-white rounded-xl shadow-sm border border-gray-200 p-6 px-4 sm:px-0">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Tambah Integrasi Baru</h3>
                
                <form action="{{ route('admin.integrations.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Layanan <span class="text-red-600">*</span></label>
                        <select name="service_name" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <option value="">Pilih Layanan</option>
                            @foreach ($availableServices as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">API Key <span class="text-red-600">*</span></label>
                            <input type="password" name="api_key" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">API Secret</label>
                            <input type="password" name="api_secret"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Webhook URL</label>
                        <input type="url" name="webhook_url" placeholder="https://..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>

                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" value="1" class="rounded">
                            <span class="ml-2 text-sm font-medium text-gray-700">Aktifkan Integrasi</span>
                        </label>
                    </div>

                    <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                        Tambah Integrasi
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
