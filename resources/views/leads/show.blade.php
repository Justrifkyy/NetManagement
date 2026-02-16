<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil Pelanggan') }}
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

                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 p-6 relative">
                        <div class="absolute top-0 right-0 p-6">
                            <span
                                class="px-4 py-1 text-sm font-bold rounded-full uppercase tracking-wide
                                {{ $lead->status == 'converted' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ $lead->status }}
                            </span>
                        </div>

                        <div class="mb-6 border-b border-gray-100 pb-4">
                            <h3 class="text-2xl font-bold text-gray-800">{{ $lead->name }}</h3>
                            <p class="text-gray-500 text-sm mt-1">
                                Terdaftar sejak: <span
                                    class="font-semibold">{{ $lead->created_at->format('d F Y, H:i') }}</span>
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Kontak Utama
                                </h4>
                                <div class="flex items-center mb-2">
                                    <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                        </path>
                                    </svg>
                                    <span class="text-lg font-medium text-gray-800">{{ $lead->phone }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <span class="text-gray-600">{{ $lead->email ?? 'Email tidak diisi' }}</span>
                                </div>
                            </div>

                            <div>
                                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Informasi
                                    Keluarga</h4>
                                <p class="mb-1"><span class="text-gray-500 text-sm">Ibu Kandung:</span> <br><span
                                        class="font-medium">{{ $lead->mother_name ?? '-' }}</span></p>
                                <p><span class="text-gray-500 text-sm">Darurat:</span> <br><span
                                        class="font-medium">{{ $lead->emergency_phone ?? '-' }}
                                        ({{ $lead->emergency_relation }})</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 p-6">
                        <div class="flex items-center mb-4 text-sky-700">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <h3 class="text-lg font-bold">Detail Lokasi</h3>
                        </div>

                        <div class="space-y-4">
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Alamat
                                    Domisili / Instalasi</h4>
                                <p class="text-gray-800 font-medium">{{ $lead->address_installation }}</p>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Alamat KTP
                                    </h4>
                                    <p class="text-gray-600 text-sm">{{ $lead->address_ktp }}</p>
                                </div>
                                <div
                                    class="bg-sky-50 p-4 rounded-lg border border-sky-100 flex flex-col justify-between">
                                    <div>
                                        <h4 class="text-xs font-bold text-sky-600 uppercase tracking-wider mb-1">Titik
                                            Koordinat</h4>
                                        <p class="text-sky-800 font-mono text-sm truncate">
                                            {{ $lead->coordinates ?? '-' }}</p>
                                    </div>
                                    @if ($lead->coordinates)
                                        <a href="https://www.google.com/maps/search/?api=1&query={{ $lead->coordinates }}"
                                            target="_blank"
                                            class="mt-2 text-center bg-sky-600 hover:bg-sky-700 text-white text-xs py-2 rounded-md font-bold transition">
                                            Buka Google Maps
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Dokumen Digital</h3>

                        <div class="space-y-6">
                            <div class="group">
                                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Foto KTP</h4>
                                @if ($lead->ktp_image_path)
                                    <div
                                        class="rounded-xl overflow-hidden shadow-sm border border-gray-200 relative h-40 bg-gray-100">
                                        <img src="{{ Storage::url($lead->ktp_image_path) }}" alt="KTP"
                                            class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                        <a href="{{ Storage::url($lead->ktp_image_path) }}" target="_blank"
                                            class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 flex items-center justify-center transition duration-300">
                                            <span
                                                class="text-white font-bold opacity-0 group-hover:opacity-100 border border-white px-3 py-1 rounded">Lihat</span>
                                        </a>
                                    </div>
                                @else
                                    <div
                                        class="h-40 bg-gray-50 rounded-xl flex flex-col items-center justify-center text-gray-400 border-2 border-dashed border-gray-200">
                                        <svg class="w-8 h-8 mb-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <span class="text-xs">Tidak ada foto</span>
                                    </div>
                                @endif
                            </div>

                            <div class="group">
                                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Foto Rumah
                                </h4>
                                @if ($lead->house_image_path)
                                    <div
                                        class="rounded-xl overflow-hidden shadow-sm border border-gray-200 relative h-40 bg-gray-100">
                                        <img src="{{ Storage::url($lead->house_image_path) }}" alt="Rumah"
                                            class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                        <a href="{{ Storage::url($lead->house_image_path) }}" target="_blank"
                                            class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 flex items-center justify-center transition duration-300">
                                            <span
                                                class="text-white font-bold opacity-0 group-hover:opacity-100 border border-white px-3 py-1 rounded">Lihat</span>
                                        </a>
                                    </div>
                                @else
                                    <div
                                        class="h-40 bg-gray-50 rounded-xl flex flex-col items-center justify-center text-gray-400 border-2 border-dashed border-gray-200">
                                        <svg class="w-8 h-8 mb-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                            </path>
                                        </svg>
                                        <span class="text-xs">Tidak ada foto</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if ($lead->status !== 'converted')
                        <div class="bg-red-50 rounded-2xl p-6 border border-red-100 text-center shadow-inner">
                            <p class="text-sm text-red-600 font-semibold mb-3">Zona Berbahaya</p>
                            <form action="{{ route('marketing.leads.destroy', $lead->id) }}" method="POST"
                                onsubmit="return confirm('PERINGATAN: Data akan dihapus secara permanen. Lanjutkan?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full bg-white border border-red-300 text-red-600 hover:bg-red-600 hover:text-white font-bold py-2 rounded-lg transition text-sm">
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
