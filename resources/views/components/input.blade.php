@props(['disabled' => false])

@php($name = $attributes->get('name'))

<input
    {{ $disabled ? 'disabled' : '' }}
    @if ($name && $errors->has($name))
        aria-invalid="true"
        aria-describedby="{{ $name }}-error"
    @endif
    {!! $attributes->merge(['class' => 'border-slate-600 bg-slate-800 text-white focus:border-amber-500 focus:ring-amber-500 rounded-md shadow-sm']) !!}
>
