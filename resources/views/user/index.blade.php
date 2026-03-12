<x-app-layout>
    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-8 px-4 sm:px-0">
                <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Halo, {{ Auth::user()->name }}! 👋</h2>
                <p class="text-slate-500 mt-1">Selamat datang di Layanan Pelanggan NetManagement.</p>
            </div>

            @if(count($unpaidInvoices) > 0)
                <div class="mb-8 px-4 sm:px-0">
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center">
                        <div class="flex items-start mb-3 sm:mb-0">
                            <svg class="w-6 h-6 text-red-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            <div>
                                <h4 class="text-red-800 font-bold">Anda memiliki {{ count($unpaidInvoices) }} tagihan yang belum dibayar!</h4>
                                <p class="text-sm text-red-600 mt-1">Segera lakukan pembayaran untuk menghindari pemutusan layanan (Isolir).</p>
                            </div>
                        </div>
                        <a href="{{ route('client.invoices.index') }}" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-bold rounded-lg shadow transition whitespace-nowrap">
                            Lihat Tagihan
                        </a>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 px-4 sm:px-0">
                
                <div class="md:col-span-2 space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden relative">
                        @if($subscription && $subscription->status === 'active')
                            <div class="absolute top-0 right-0 bg-green-500 text-white font-bold py-1 px-4 rounded-bl-xl text-xs uppercase tracking-widest shadow-sm">
                                AKTIF
                            </div>
                        @elseif($subscription && $subscription->status === 'isolated')
                            <div class="absolute top-0 right-0 bg-red-500 text-white font-bold py-1 px-4 rounded-bl-xl text-xs uppercase tracking-widest shadow-sm">
                                TERISOLIR
                            </div>
                        @else
                            <div class="absolute top-0 right-0 bg-gray-500 text-white font-bold py-1 px-4 rounded-bl-xl text-xs uppercase tracking-widest shadow-sm">
                                BELUM AKTIF
                            </div>
                        @endif

                        <div class="p-6 md:p-8">
                            <div class="flex items-center mb-6">
                                <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-4">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest">Paket Internet Anda</h3>
                                    <h2 class="text-2xl font-black text-slate-800">{{ $subscription->package->name ?? 'Belum ada paket' }}</h2>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 border-t border-slate-100 pt-6">
                                <div>
                                    <p class="text-xs text-slate-500 uppercase font-bold mb-1">Kecepatan</p>
                                    <p class="text-lg font-bold text-slate-800">{{ $subscription->package->speed_mbps ?? 0 }} <span class="text-sm text-slate-500">Mbps</span></p>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500 uppercase font-bold mb-1">Biaya Bulanan</p>
                                    <p class="text-lg font-bold text-slate-800">Rp {{ number_format($subscription->package->price ?? 0, 0, ',', '.') }}</p>
                                </div>
                                <div class="col-span-2 mt-2">
                                    <p class="text-xs text-slate-500 uppercase font-bold mb-1">Lokasi Pemasangan</p>
                                    <p class="text-sm font-medium text-slate-700 bg-slate-50 p-3 rounded-lg border border-slate-100">
                                        {{ $customer->address_installation ?? 'Alamat belum diatur' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-slate-800 rounded-2xl shadow-sm border border-slate-700 p-6 text-white relative overflow-hidden">
                        <svg class="absolute right-0 top-0 w-32 h-32 text-slate-700 opacity-50 transform translate-x-8 -translate-y-8" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path></svg>
                        
                        <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-4 relative z-10">Data Koneksi (PPPoE)</h3>
                        
                        <div class="space-y-4 relative z-10">
                            <div>
                                <p class="text-xs text-slate-400 mb-1">Username PPPoE</p>
                                <div class="bg-slate-900 px-3 py-2 rounded border border-slate-600 font-mono text-sm text-blue-300">
                                    {{ $subscription->pppoe_username ?? 'Menunggu Aktivasi' }}
                                </div>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 mb-1">Password PPPoE</p>
                                <div class="bg-slate-900 px-3 py-2 rounded border border-slate-600 font-mono text-sm text-slate-300">
                                    ••••••••
                                </div>
                            </div>
                            <div class="pt-4 border-t border-slate-700">
                                <p class="text-xs text-slate-400 mb-1">Tanggal Pemasangan</p>
                                <p class="font-medium">{{ isset($subscription->installation_date) ? $subscription->installation_date->format('d M Y') : 'Belum dipasang' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>