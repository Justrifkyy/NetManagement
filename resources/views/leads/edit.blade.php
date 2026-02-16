<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Prospek') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-sky-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl border border-gray-100 relative">

                <div class="bg-gradient-to-r from-yellow-500 to-orange-500 h-32 flex items-center px-8">
                    <div class="text-white">
                        <h3 class="text-2xl font-bold">Edit Data Pelanggan</h3>
                        <p class="text-yellow-100 opacity-90 text-sm mt-1">Perbarui data informasi calon pelanggan.</p>
                    </div>
                    <svg class="ml-auto w-24 h-24 text-white opacity-10 absolute right-4 top-4" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>

                <div class="p-8 mt-2">
                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r shadow-sm">
                            <ul class="list-disc ml-5 text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('marketing.leads.update', $lead->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-10">
                            <div class="flex items-center mb-6 text-yellow-700 border-b border-yellow-100 pb-2">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <h4 class="text-lg font-bold">Identitas Utama</h4>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap</label>
                                    <input type="text" name="name" value="{{ old('name', $lead->name) }}"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500 py-2.5"
                                        required>
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Nama Ibu Kandung</label>
                                    <input type="text" name="mother_name"
                                        value="{{ old('mother_name', $lead->mother_name) }}"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500 py-2.5">
                                </div>
                            </div>
                        </div>

                        <div class="mb-10">
                            <div class="flex items-center mb-6 text-yellow-700 border-b border-yellow-100 pb-2">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                    </path>
                                </svg>
                                <h4 class="text-lg font-bold">Kontak & Darurat</h4>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">No. WhatsApp</label>
                                    <input type="number" name="phone" value="{{ old('phone', $lead->phone) }}"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500 py-2.5"
                                        required>
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                                    <input type="email" name="email" value="{{ old('email', $lead->email) }}"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500 py-2.5">
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">No. Darurat</label>
                                    <input type="number" name="emergency_phone"
                                        value="{{ old('emergency_phone', $lead->emergency_phone) }}"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500 py-2.5">
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Hubungan</label>
                                    <select name="emergency_relation"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500 py-2.5">
                                        <option value="{{ $lead->emergency_relation }}">
                                            {{ $lead->emergency_relation ?? '- Pilih -' }}</option>
                                        <option value="Orang Tua">Orang Tua</option>
                                        <option value="Suami/Istri">Suami/Istri</option>
                                        <option value="Saudara">Saudara Kandung</option>
                                        <option value="Kerabat">Kerabat/Teman</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-10">
                            <div class="flex items-center mb-6 text-yellow-700 border-b border-yellow-100 pb-2">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <h4 class="text-lg font-bold">Lokasi Pemasangan</h4>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Alamat KTP</label>
                                    <textarea name="address_ktp" rows="2"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500" required>{{ old('address_ktp', $lead->address_ktp) }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Alamat Pasang</label>
                                    <textarea name="address_installation" rows="2"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500" required>{{ old('address_installation', $lead->address_installation) }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Koordinat</label>
                                    <input type="text" name="coordinates"
                                        value="{{ old('coordinates', $lead->coordinates) }}"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500 py-2.5">
                                </div>
                            </div>
                        </div>

                        <div class="mb-10">
                            <div class="flex items-center mb-6 text-yellow-700 border-b border-yellow-100 pb-2">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0
