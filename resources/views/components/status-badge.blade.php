@props(['status', 'variant' => 'md'])

@php
    // @tailwindcss ignore  
    $sizeClasses = [
        'sm' => 'px-2.5 py-0.5 text-xs',
        'md' => 'px-3 py-1 text-sm',
        'lg' => 'px-4 py-2 text-base',
    ];

    $statusColors = [
        'prospect' => 'bg-slate-800 text-white',
        'contacted' => 'bg-blue-100 text-blue-800',
        'qualified' => 'bg-indigo-100 text-indigo-800',
        'proposal_sent' => 'bg-purple-100 text-purple-800',
        'negotiation' => 'bg-yellow-100 text-yellow-800',
        'converted' => 'bg-green-100 text-green-800',
        'lost' => 'bg-red-100 text-red-800',
    ];

    $colorClass = $statusColors[$status] ?? 'bg-slate-800 text-white';
    $sizeClass = $sizeClasses[$variant] ?? $sizeClasses['md'];
@endphp

<span class="inline-flex items-center rounded-full font-medium {{ $sizeClass }} {{ $colorClass }}">
    {{ ucfirst(str_replace('_', ' ', $status)) }}
</span>
