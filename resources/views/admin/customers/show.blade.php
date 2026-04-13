<x-app-layout>
    <div class="py-10 bg-slate-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8 px-4 sm:px-0">
                <a href="{{ route('admin.customers.index') }}" class="text-purple-600 hover:text-purple-900">← Kembali</a>
                <h2 class="text-3xl font-extrabold text-white mt-2">Detail Pelanggan</h2>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 px-4 sm:px-0">
                <!-- Main Info -->
                <div class="lg:col-span-2 bg-slate-900 rounded-xl shadow-sm border border-slate-800 p-6">
                    <h3 class="text-xl font-bold text-white mb-4">Informasi Pelanggan</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="text-sm font-medium text-slate-300">Kode Pelanggan</label>
                            <p class="text-white font-semibold">{{ $customer->customer_code }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-300">Nama</label>
                            <p class="text-white">{{ $customer->user->name }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-300">Email</label>
                            <p class="text-white">{{ $customer->user->email }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-300">No. KTP</label>
                            <p class="text-white">{{ $customer->nik }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-300">No. HP</label>
                            <p class="text-white">{{ $customer->phone_number }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-300">Alamat Instalasi</label>
                            <p class="text-white">{{ $customer->address_installation }}</p>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t border-slate-800">
                        <a href="{{ route('admin.customers.edit', $customer) }}" 
                            class="inline-flex items-center px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700">
                            Edit Data
                        </a>
                    </div>
                </div>

                <!-- Status & Actions -->
                <div class="space-y-6">
                    <div class="bg-slate-900 rounded-xl shadow-sm border border-slate-800 p-6">
                        <h3 class="font-bold text-white mb-4">Status Layanan</h3>
                        @if ($customer->is_isolated)
                            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                                <p class="text-red-800 font-semibold">Terisolir</p>
                            </div>
                            <form action="{{ route('admin.customers.activate', $customer) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                    Aktifkan Kembali
                                </button>
                            </form>
                        @else
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                                <p class="text-green-800 font-semibold">Aktif</p>
                            </div>
                            <form action="{{ route('admin.customers.isolate', $customer) }}" method="POST">
                                @csrf
                                <textarea name="reason" placeholder="Alasan isolir" class="w-full px-4 py-2 border border-slate-700 rounded-lg mb-2"></textarea>
                                <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700"
                                    onclick="return confirm('Isolir pelanggan ini?')">Isolir</button>
                            </form>
                        @endif
                    </div>

                    <!-- Subscriptions -->
                    <div class="bg-slate-900 rounded-xl shadow-sm border border-slate-800 p-6">
                        <h3 class="font-bold text-white mb-4">Langganan Aktif</h3>
                        <div class="space-y-2">
                            @forelse ($customer->subscriptions as $sub)
                                <div class="p-3 bg-slate-950 rounded-lg">
                                    <p class="font-semibold text-white">{{ $sub->package->name }}</p>
                                    <p class="text-sm text-slate-300">{{ $sub->package->speed_mbps }} Mbps</p>
                                </div>
                            @empty
                                <p class="text-slate-400">Tidak ada langganan</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
