@props(['submit'])

<div {{ $attributes->merge(['class' => 'md:grid md:grid-cols-3 md:gap-6']) }}>
    <x-section-title>
        <x-slot name="title">
            <span class="text-xl font-extrabold text-white tracking-tight">{{ $title }}</span>
        </x-slot>
        <x-slot name="description">
            <span class="text-sm text-slate-400 font-medium">{{ $description }}</span>
        </x-slot>
    </x-section-title>

    <div class="mt-5 md:mt-0 md:col-span-2">
        <form wire:submit="{{ $submit }}">
            <div class="p-5 sm:p-6 bg-slate-900/80 backdrop-blur-md shadow-xl border border-slate-800 {{ isset($actions) ? 'rounded-t-2xl' : 'rounded-2xl' }}">
                <div class="grid grid-cols-6 gap-6">
                    {{ $form }}
                </div>
            </div>

            @if (isset($actions))
                <div class="flex items-center justify-end p-4 sm:px-6 sm:py-4 bg-slate-800/50 border-x border-b border-slate-800 text-end shadow-xl rounded-b-2xl">
                    {{ $actions }}
                </div>
            @endif
        </form>
    </div>
</div>