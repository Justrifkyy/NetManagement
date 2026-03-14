<x-app-layout>
    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            @php
                /** @var \App\Models\Customer $customer */
                /** @var \App\Models\Subscription $subscription */
                
                $unpaidCount = count($unpaidInvoices ?? []);
                $totalUnpaid = 0;
                $nearestDueDate = null;

                if ($unpaidCount > 0) {
                    foreach ($unpaidInvoices as $inv) {
                        $totalUnpaid += $inv->amount;
                        if (!$nearestDueDate || $inv->due_date < $nearestDueDate) {
                            $nearestDueDate = $inv->due_date;
                        }
                    }
                }
            @endphp

            <div class="mb-8 px-4 sm:px-0 flex flex-col md:flex-row justify-between items-start md:items-center">
                <div>
                    <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Halo, {{ Auth::user()->name }}! 👋</h2>
                    <p class="text-slate-500 mt-1">Selamat datang di Ringkasan Layanan NetManagement Anda.</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-white border border-slate-200 shadow-sm text-slate-600">
                        ID Pelanggan: <span class="text-blue-600 ml-1 font-mono">{{ $customer->customer_code ?? 'Menunggu Aktivasi' }}</span>
                    </span>
                </div>
            </div>

            @if($unpaidCount > 0)
                <div class="mb-8 px-4 sm:px-0">
                    <div class="bg-red-50 border-l-4 border-red-500 p-5 rounded-r-xl shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center">
                        <div class="flex items-start mb-4 sm:mb-0">
                            <div class="p-2 bg-red-100 rounded-full mr-4 mt-1">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-red-800 font-bold text-lg">Peringatan Pembayaran</h4>
                                <p class="text-sm text-red-600 mt-1">Anda memiliki <strong>{{ $unpaidCount }} tagihan</strong> sebesar <strong>Rp {{ number_format($totalUnpaid, 0, ',', '.') }}</strong> yang belum dibayar. Segera lakukan pembayaran agar layanan internet Anda tidak terputus.</p>
                            </div>
                        </div>
                        <a href="{{ route('client.billing.index') }}" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl shadow-md transition whitespace-nowrap">
                            Bayar Sekarang
                        </a>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 px-4 sm:px-0 mb-8">
                
                <div class="bg-white rounded-2xl p-6 shadow-sm border {{ isset($subscription) && $subscription->status === 'active' ? 'border-green-200' : 'border-red-200' }} flex flex-col">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-3 {{ isset($subscription) && $subscription->status === 'active' ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }} rounded-xl">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="px-3 py-1 text-xs font-bold rounded-full {{ isset($subscription) && $subscription->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} uppercase">
                            {{ isset($subscription) && $subscription->status === 'active' ? 'Koneksi Aktif' : 'Terisolir' }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Status Internet</p>
                        <h3 class="text-2xl font-black {{ isset($subscription) && $subscription->status === 'active' ? 'text-green-600' : 'text-red-600' }} mt-1">
                            {{ isset($subscription) && $subscription->status === 'active' ? 'Online' : 'Offline' }}
                        </h3>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-blue-100 flex flex-col">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <span class="text-xs font-bold text-slate-400 uppercase">{{ $subscription->package->speed_mbps ?? 0 }} Mbps</span>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Paket Saat Ini</p>
                        <h3 class="text-xl font-black text-slate-800 mt-1 truncate" title="{{ $subscription->package->name ?? 'Belum ada paket' }}">
                            {{ $subscription->package->name ?? 'Belum ada paket' }}
                        </h3>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border {{ $unpaidCount > 0 ? 'border-orange-200' : 'border-slate-200' }} flex flex-col">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-3 {{ $unpaidCount > 0 ? 'bg-orange-50 text-orange-600' : 'bg-slate-50 text-slate-600' }} rounded-xl">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Status Tagihan</p>
                        @if($unpaidCount > 0)
                            <h3 class="text-2xl font-black text-orange-600 mt-1">{{ $unpaidCount }} Tunggakan</h3>
                        @else
                            <h3 class="text-2xl font-black text-slate-800 mt-1">Lunas Semua</h3>
                        @endif
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 flex flex-col">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        @if($nearestDueDate && \Carbon\Carbon::parse($nearestDueDate)->isPast())
                            <span class="px-2 py-1 text-xs font-bold bg-red-100 text-red-700 rounded-md">Terlewat</span>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Jatuh Tempo Terdekat</p>
                        <h3 class="text-xl font-black {{ $nearestDueDate && \Carbon\Carbon::parse($nearestDueDate)->isPast() ? 'text-red-600' : 'text-slate-800' }} mt-1">
                            @if($nearestDueDate)
                                {{ \Carbon\Carbon::parse($nearestDueDate)->format('d M Y') }}
                            @else
                                Tgl {{ $subscription->billing_due_date ?? 5 }} Depan
                            @endif
                        </h3>
                    </div>
                </div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 px-4 sm:px-0">
                <div class="bg-white shadow-sm rounded-2xl border border-slate-200 p-6">
                    <h3 class="font-bold text-slate-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Lokasi Pemasangan Layanan
                    </h3>
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                        <p class="text-sm font-medium text-slate-700">{{ $customer->address_installation ?? 'Alamat belum tersedia.' }}</p>
                    </div>
                    <div class="mt-4 text-sm text-slate-500">
                        <p><strong>Tanggal Pasang:</strong> {{ isset($subscription->installation_date) ? \Carbon\Carbon::parse($subscription->installation_date)->format('d F Y') : '-' }}</p>
                    </div>
                </div>

                <div class="bg-slate-800 shadow-sm rounded-2xl border border-slate-700 p-6 text-white relative overflow-hidden">
                    <svg class="absolute right-0 top-0 w-32 h-32 text-slate-700 opacity-30 transform translate-x-8 -translate-y-8" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path></svg>
                    
                    <h3 class="font-bold text-slate-200 mb-4 flex items-center relative z-10">
                        <svg class="w-5 h-5 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Data Koneksi Teknis (PPPoE)
                    </h3>
                    
                    <div class="space-y-4 relative z-10">
                        <div>
                            <p class="text-xs text-slate-400 uppercase tracking-wider mb-1">Username PPPoE</p>
                            <div class="bg-slate-900 px-4 py-2 rounded-lg border border-slate-600 font-mono text-sm text-blue-300">
                                {{ $subscription->pppoe_username ?? 'Belum ada' }}
                            </div>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 uppercase tracking-wider mb-1">Password PPPoE</p>
                            <div class="bg-slate-900 px-4 py-2 rounded-lg border border-slate-600 font-mono text-sm text-slate-300">
                                ••••••••
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>