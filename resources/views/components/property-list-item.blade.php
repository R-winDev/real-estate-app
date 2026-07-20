@props(['property'])

@php
    $primaryImage = $property->images->firstWhere('is_primary', true) ?? $property->images->sortBy('sort_order')->first();
@endphp

<a href="{{ route('properties.show', $property) }}" class="group card-hover overflow-hidden flex flex-row">
    <div class="relative w-48 sm:w-64 shrink-0 overflow-hidden">
        @if($primaryImage)
            <img src="{{ $primaryImage->url }}" alt="{{ $property->title }}"
                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
        @else
            <div class="w-full h-full min-h-[180px] bg-gradient-to-br from-brand-50 via-brand-100/50 to-surface-100 flex items-center justify-center">
                <svg class="w-12 h-12 text-brand-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
        @endif

        @if($property->status)
            <span class="absolute top-3 right-3 px-2 py-0.5 rounded-md text-[10px] font-bold backdrop-blur-md
                {{ $property->status?->slug === 'active' ? 'bg-emerald-500/90 text-white' : ($property->status?->slug === 'sold' ? 'bg-amber-500/90 text-white' : 'bg-surface-600/90 text-white') }}">
                {{ $property->status?->name_fa }}
            </span>
        @endif
    </div>

    <div class="flex-1 p-4 flex flex-col justify-between">
        <div>
            <div class="flex items-start justify-between gap-2 mb-1">
                <h3 class="font-bold text-[15px] text-surface-900 line-clamp-1 group-hover:text-brand-600 transition-colors duration-200">
                    {{ $property->title }}
                </h3>
                @if($property->is_sold)
                    <span class="badge-danger text-[10px] shrink-0">فروخته شده</span>
                @endif
            </div>

            <div class="flex items-center gap-1.5 text-sm text-surface-500 mb-2">
                <svg class="w-3.5 h-3.5 text-surface-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span class="truncate">{{ $property->location?->name ?? 'نامشخص' }}</span>
            </div>

            <div class="flex items-center gap-3 text-xs text-surface-500">
                @if($property->bedrooms)
                    <span class="flex items-center gap-1">{{ $property->bedrooms }} خواب</span>
                @endif
                @if($property->bathrooms)
                    <span class="flex items-center gap-1">{{ $property->bathrooms }} سرویس</span>
                @endif
                @if($property->area_total)
                    <span class="flex items-center gap-1">{{ number_format($property->area_total) }} متر مربع</span>
                @endif
                @if($property->type)
                    <span class="px-1.5 py-0.5 bg-brand-50 text-brand-700 rounded text-[10px] font-medium">{{ $property->type->name_fa }}</span>
                @endif
            </div>
        </div>

        <div class="flex items-center justify-between mt-3 pt-3 border-t border-surface-100">
            <div class="text-lg font-extrabold text-surface-900">{{ number_format($property->price) }} <span class="text-xs font-medium text-surface-400">تومان</span></div>
            <span class="text-xs text-brand-600 font-semibold flex items-center gap-1 group-hover:gap-2 transition-all duration-200">
                مشاهده جزئیات
                <svg class="w-3.5 h-3.5 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </span>
        </div>
    </div>
</a>
