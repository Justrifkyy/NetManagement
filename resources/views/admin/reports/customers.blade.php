<x-app-layout>
    <div class="py-10 bg-slate-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8 flex justify-between items-center px-4 sm:px-0">
                <div>
                    <a href="{{ route('admin.reports.index') }}" class="text-amber-400 hover:text-amber-300 font-medium">← Kembali</a>
                    <h2 class="text-3xl font-extrabold text-white mt-2">Laporan Pelanggan</h2>
                </div>
            </div>

            <div class="bg-slate-900 rounded-xl shadow-sm border border-slate-800 p-6 mb-6">
                <h3 class="text-lg font-bold text-white mb-4">Filter Laporan</h3>
                <form action="{{ route('admin.reports.customers') }}" method="GET" class="flex gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Dari Tanggal</label>
                        <input type="date" name="from_date" value="{{ $fromDate }}" class="px-4 py-2 border border-slate-700 rounded-lg bg-slate-800 text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Sampai Tanggal</label>
                        <input type="date" name="to_date" value="{{ $toDate }}" class="px-4 py-2 border border-slate-700 rounded-lg bg-slate-800 text-white">
                    </div>
                    <button type="submit" class="self-end px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700">Filter</button>
                </form>
            </div>

            <div class="bg-slate-900 rounded-xl shadow-sm border border-slate-800 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-800 bg-slate-800">
                    <h3 class="font-bold text-white text-lg">Daftar Pelanggan Baru ({{ $fromDate }} - {{ $toDate }})</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-800">
                        <thead class="bg-slate-800">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-300 uppercase">Nama</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-300 uppercase">Email</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-300 uppercase">Telepon</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-300 uppercase">Paket</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-300 uppercase">Dibuat</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                            @forelse($report as $customer)
                                <tr class="hover:bg-slate-800">
                                    <td class="px-6 py-4 whitespace-nowrap text-white font-semibold">{{ $customer->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-slate-400">{{ $customer->user->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-slate-400">{{ $customer->phone_number ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-amber-400">{{ $customer->subscriptions->first()?->package->name ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-slate-400">{{ $customer->created_at->format('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                        Tidak ada data pelanggan dalam periode ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
