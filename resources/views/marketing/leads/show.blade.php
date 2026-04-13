<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Detail Lengkap Prospek') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-sky-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6 px-2 flex justify-between items-center">
                <a href="{{ route('marketing.leads.index') }}"
                    class="flex items-center text-sky-600 hover:text-sky-800 font-semibold transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Daftar
                </a>

                @if ($lead->status !== 'converted')
                    <div class="flex space-x-3">
                        <a href="{{ route('marketing.leads.edit', $lead->id) }}"
                            class="flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-bold rounded-lg shadow transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                </path>
                            </svg>
                            Edit Data
                        </a>
                    </div>
                @endif
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white overflow-hidden shadow-md sm:rounded-xl border border-slate-800 p-6 relative">
                        <div class="absolute top-4 right-4">
                            <span
                                class="px-3 py-1 text-sm font-bold rounded-full uppercase tracking-wide {{ $lead->status == 'converted' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ $lead->status }}
                            </span>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-sky-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Identitas Pelanggan
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <span class="block text-xs text-slate-400 uppercase">Nama Lengkap</span>
                                <span class="text-lg font-semibold text-white">{{ $lead->name }}</span>
                            </div>
                            <div>
                                <span class="block text-xs text-slate-400 uppercase">Jenis Pelanggan</span>
                                <span class="font-medium">{{ ucfirst($lead->customer_type) }}
                                    {{ $lead->business_name ? '(' . $lead->business_name . ')' : '' }}</span>
                            </div>
                            <div>
                                <span class="block text-xs text-slate-400 uppercase">Ibu Kandung</span>
                                <span class="font-medium">{{ $lead->mother_name ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="block text-xs text-slate-400 uppercase">Terdaftar Sejak</span>
                                <span class="font-medium">{{ $lead->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                        <hr class="my-4 border-slate-800">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <span class="block text-xs text-slate-400 uppercase">No. WhatsApp</span>
                                <span class="text-lg font-bold text-green-600">{{ $lead->phone }}</span>
                            </div>
                            <div>
                                <span class="block text-xs text-slate-400 uppercase">Email</span>
                                <span class="font-medium">{{ $lead->email ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="block text-xs text-slate-400 uppercase">Kontak Darurat</span>
                                <span class="font-medium">{{ $lead->emergency_name }}
                                    ({{ $lead->emergency_relation }})</span>
                                <span class="block text-sm text-slate-400">{{ $lead->emergency_phone }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-md sm:rounded-xl border border-slate-800 p-6">
                        <h3 class="text-lg font-bold text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-sky-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Lokasi Pemasangan
                        </h3>
                        <div class="space-y-4">
                            <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-100">
                                <span class="block text-xs text-yellow-600 font-bold uppercase mb-1">Alamat Pemasangan
                                    (Domisili)</span>
                                <p class="text-white font-medium">{{ $lead->address_installation }}</p>
                            </div>
                            <div class="bg-slate-950 p-4 rounded-lg border border-slate-800">
                                <span class="block text-xs text-slate-400 font-bold uppercase mb-1">Alamat Sesuai
                                    KTP</span>
                                <p class="text-slate-300 text-sm">
                                    {{ $lead->address_ktp ?? 'Sama dengan alamat pasang / Tidak diisi' }}</p>
                            </div>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div><span class="block text-slate-400 text-xs">RT/RW</span> {{ $lead->rt_rw ?? '-' }}
                                </div>
                                <div><span class="block text-slate-400 text-xs">Kelurahan</span>
                                    {{ $lead->village ?? '-' }}</div>
                                <div><span class="block text-slate-400 text-xs">Kecamatan</span>
                                    {{ $lead->district ?? '-' }}</div>
                                <div><span class="block text-slate-400 text-xs">Kota/Kab</span> {{ $lead->city ?? '-' }}
                                </div>
                                <div><span class="block text-slate-400 text-xs">Provinsi</span>
                                    {{ $lead->province ?? '-' }}</div>
                                <div><span class="block text-slate-400 text-xs">Kode Pos</span>
                                    {{ $lead->postal_code ?? '-' }}</div>
                            </div>
                            <div
                                class="bg-sky-50 p-4 rounded-lg border border-sky-100 flex flex-col sm:flex-row justify-between items-center">
                                <div class="mb-2 sm:mb-0">
                                    <span class="block text-xs text-sky-600 font-bold uppercase mb-1">Koordinat Google
                                        Maps</span>
                                    <p class="text-sky-800 font-mono text-sm">
                                        {{ $lead->coordinates ?? 'Belum ada koordinat' }}</p>
                                </div>
                                @if ($lead->coordinates)
                                    <a href="https://www.google.com/maps/search/?api=1&query={{ $lead->coordinates }}"
                                        target="_blank"
                                        class="px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold rounded-lg transition">Buka
                                        Maps</a>
                                @endif
                            </div>
                            <div class="text-sm">
                                <span class="block text-slate-400 text-xs">Patokan / Landmark</span>
                                <p class="text-slate-300">{{ $lead->landmark ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-md sm:rounded-xl border border-slate-800 p-6">
                        <h3 class="text-lg font-bold text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-sky-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                </path>
                            </svg>
                            Paket & Jadwal
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-blue-50 p-4 rounded-xl border border-blue-100">
                                <span class="block text-xs text-blue-500 uppercase font-bold mb-1">Paket Dipilih</span>
                                <p class="text-xl font-bold text-blue-800">
                                    {{ $lead->package->name ?? 'Tidak ada paket' }}</p>
                                <p class="text-sm text-amber-400">{{ $lead->package->speed_mbps ?? 0 }} Mbps - Rp
                                    {{ number_format($lead->package->price ?? 0, 0, ',', '.') }}</p>
                                @if ($lead->promo_code)
                                    <span
                                        class="mt-2 inline-block px-2 py-1 bg-yellow-200 text-yellow-800 text-xs font-bold rounded">Promo:
                                        {{ $lead->promo_code }}</span>
                                @endif
                            </div>
                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between border-b border-slate-800 pb-2">
                                    <span class="text-slate-400">Jadwal Survey</span>
                                    <span
                                        class="font-bold">{{ $lead->survey_date ? $lead->survey_date->format('d M Y') : '-' }}</span>
                                </div>
                                <div class="flex justify-between border-b border-slate-800 pb-2">
                                    <span class="text-slate-400">Jadwal Instalasi</span>
                                    <span
                                        class="font-bold">{{ $lead->installation_date ? $lead->installation_date->format('d M Y') : '-' }}</span>
                                </div>
                                <div class="flex justify-between border-b border-slate-800 pb-2">
                                    <span class="text-slate-400">Waktu Diinginkan</span>
                                    <span class="font-bold">{{ $lead->preferred_time ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-400">Sumber Info</span>
                                    <span class="font-bold">{{ $lead->source ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white overflow-hidden shadow-md sm:rounded-xl border border-slate-800 p-6">
                        <h3 class="text-lg font-bold text-white mb-4 border-b pb-2">Catatan Tim</h3>
                        <div class="space-y-4">
                            <div>
                                <span class="block text-xs font-bold text-slate-400 uppercase">Ringkasan
                                    Komunikasi</span>
                                <p class="text-sm bg-slate-950 p-2 rounded mt-1">{{ $lead->notes_summary ?? '-' }}</p>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-red-400 uppercase">Kendala / Hambatan</span>
                                <p class="text-sm bg-red-50 p-2 rounded mt-1 text-red-700">
                                    {{ $lead->notes_obstacle ?? '-' }}</p>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-slate-400 uppercase">Catatan Khusus</span>
                                <p class="text-sm bg-yellow-50 p-2 rounded mt-1">{{ $lead->notes_special ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-md sm:rounded-xl border border-slate-800 p-6">
                        <h3 class="text-lg font-bold text-white mb-4 border-b pb-2">Dokumen Digital</h3>
                        <div class="space-y-4">
                            <div>
                                <span class="block text-xs font-bold text-slate-400 uppercase mb-2">Foto KTP</span>
                                @if ($lead->ktp_image_path)
                                    <a href="{{ Storage::url($lead->ktp_image_path) }}" target="_blank"
                                        class="block group relative h-40 rounded-lg overflow-hidden border border-slate-800">
                                        <img src="{{ Storage::url($lead->ktp_image_path) }}"
                                            class="w-full h-full object-cover transition group-hover:scale-105">
                                        <div
                                            class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition flex items-center justify-center">
                                            <span
                                                class="text-white font-bold opacity-0 group-hover:opacity-100">Lihat</span>
                                        </div>
                                    </a>
                                @else
                                    <div
                                        class="h-20 bg-slate-800 rounded-lg flex items-center justify-center text-xs text-slate-400">
                                        Tidak ada foto</div>
                                @endif
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-slate-400 uppercase mb-2">Foto Rumah</span>
                                @if ($lead->house_image_path)
                                    <a href="{{ Storage::url($lead->house_image_path) }}" target="_blank"
                                        class="block group relative h-40 rounded-lg overflow-hidden border border-slate-800">
                                        <img src="{{ Storage::url($lead->house_image_path) }}"
                                            class="w-full h-full object-cover transition group-hover:scale-105">
                                        <div
                                            class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition flex items-center justify-center">
                                            <span
                                                class="text-white font-bold opacity-0 group-hover:opacity-100">Lihat</span>
                                        </div>
                                    </a>
                                @else
                                    <div
                                        class="h-20 bg-slate-800 rounded-lg flex items-center justify-center text-xs text-slate-400">
                                        Tidak ada foto</div>
                                @endif
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-slate-400 uppercase mb-2">Foto
                                    Pelanggan</span>
                                @if ($lead->customer_image_path)
                                    <a href="{{ Storage::url($lead->customer_image_path) }}" target="_blank"
                                        class="block group relative h-40 rounded-lg overflow-hidden border border-slate-800">
                                        <img src="{{ Storage::url($lead->customer_image_path) }}"
                                            class="w-full h-full object-cover transition group-hover:scale-105">
                                        <div
                                            class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition flex items-center justify-center">
                                            <span
                                                class="text-white font-bold opacity-0 group-hover:opacity-100">Lihat</span>
                                        </div>
                                    </a>
                                @else
                                    <div
                                        class="h-20 bg-slate-800 rounded-lg flex items-center justify-center text-xs text-slate-400">
                                        Tidak ada foto</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if ($lead->status !== 'converted')
                        <div class="bg-red-50 p-4 rounded-xl border border-red-100 text-center">
                            <form action="{{ route('marketing.leads.destroy', $lead->id) }}" method="POST"
                                onsubmit="return confirm('Yakin hapus data ini permanen?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-xs font-bold text-red-600 hover:text-red-800 uppercase tracking-widest">
                                    Hapus Data Permanen
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
