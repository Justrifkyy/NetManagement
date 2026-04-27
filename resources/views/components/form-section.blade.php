@props(['submit'])

<div {{ $attributes->merge(['class' => 'md:grid md:grid-cols-3 md:gap-6 mx-4 sm:mx-0']) }}>
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
            <div class="px-4 py-5 bg-slate-900/80 backdrop-blur-md sm:p-6 shadow-xl border border-slate-800 {{ isset($actions) ? 'rounded-t-2xl' : 'rounded-2xl' }}">
                <div class="grid grid-cols-6 gap-6">
                    {{ $form }}
                </div>
            </div>

            @if (isset($actions))
                <div class="flex items-center justify-end px-4 py-4 bg-slate-800/50 border-x border-b border-slate-800 text-end sm:px-6 shadow-xl rounded-b-2xl">
                    {{ $actions }}
                </div>
            @endif
        </form>
    </div>
</div>