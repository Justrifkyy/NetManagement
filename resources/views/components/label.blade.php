@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-bold text-sm text-slate-300']) }}>
    {{ $value ?? $slot }}
</label>
