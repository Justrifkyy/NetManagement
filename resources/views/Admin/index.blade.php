<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin / Owner') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h1>Selamat Datang, Super Admin!</h1>
                <p>Di sini Anda bisa melihat laporan keuangan dan kelola user.</p>
            </div>
        </div>
    </div>
</x-app-layout>