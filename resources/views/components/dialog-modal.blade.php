@props(['id' => null, 'maxWidth' => null])

<x-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="px-6 py-5 bg-slate-900 border-b border-slate-800">
        <div class="text-lg font-bold text-white">
            {{ $title }}
        </div>

        <div class="mt-4 text-sm text-slate-300 leading-relaxed">
            {{ $content }}
        </div>
    </div>

    <div class="flex flex-row justify-end px-6 py-4 bg-slate-900/90 border-t border-slate-800 text-end">
        {{ $footer }}
    </div>
</x-modal>
