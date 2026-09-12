@props(['for'])

@error($for)
    <p id="{{ $for }}-error" role="alert" aria-live="polite" {{ $attributes->merge(['class' => 'text-sm text-red-600']) }}>{{ $message }}</p>
@enderror
