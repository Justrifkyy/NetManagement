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
        <div class="px-4 py-5 sm:p-6 bg-slate-900/80 backdrop-blur-md shadow-xl border border-slate-800 sm:rounded-2xl text-slate-300">
            {{ $content }}
        </div>
    </div>
</div>