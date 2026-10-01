@props(['title' => __('Konfirmasi Password'), 'content' => __('Demi keamanan Anda, silakan masukkan password akun Anda untuk melanjutkan tindakan ini.'), 'button' => __('Konfirmasi')])

@php
    $confirmableId = md5($attributes->wire('then'));
@endphp

<span
    {{ $attributes->wire('then') }}
    x-data
    x-ref="span"
    x-on:click="$wire.startConfirmingPassword('{{ $confirmableId }}')"
    x-on:password-confirmed.window="setTimeout(() => $event.detail.id === '{{ $confirmableId }}' && $refs.span.dispatchEvent(new CustomEvent('then', { bubbles: false })), 250);"
>
    {{ $slot }}
</span>

@once
<x-dialog-modal wire:model.live="confirmingPassword">
    <x-slot name="title">
        <span class="text-white font-bold">{{ $title }}</span>
    </x-slot>

    <x-slot name="content">
        <p class="text-slate-400 mb-4">{{ $content }}</p>

        <div class="mt-4" x-data="{}" x-on:confirming-password.window="setTimeout(() => $refs.confirmable_password.focus(), 250)">
            <input type="password" 
                class="mt-1 block w-full px-4 py-3 bg-slate-800/50 border border-slate-700 text-slate-100 rounded-xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all placeholder-slate-500 text-sm" 
                placeholder="{{ __('Masukkan Password Akun Anda') }}" 
                autocomplete="current-password"
                x-ref="confirmable_password"
                wire:model="confirmablePassword"
                wire:keydown.enter="confirmPassword" />

            <x-input-error for="confirmable_password" class="mt-2 text-rose-400" />
        </div>
    </x-slot>

    <x-slot name="footer">
        <button type="button" wire:click="stopConfirmingPassword" wire:loading.attr="disabled" 
            class="px-6 py-2.5 bg-slate-800 text-slate-300 font-bold rounded-xl border border-slate-700 hover:bg-slate-700 hover:text-white transition-all disabled:opacity-50">
            {{ __('Batal') }}
        </button>

        <button type="button" dusk="confirm-password-button" wire:click="confirmPassword" wire:loading.attr="disabled" 
            class="ms-3 px-6 py-2.5 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-500 shadow-[0_0_15px_rgba(79,70,229,0.3)] transition-all disabled:opacity-50">
            {{ $button }}
        </button>
    </x-slot>
</x-dialog-modal>
@endonce
