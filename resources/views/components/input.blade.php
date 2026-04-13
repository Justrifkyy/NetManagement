@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-slate-600 bg-slate-800 text-white focus:border-amber-500 focus:ring-amber-500 rounded-md shadow-sm']) !!}>
