@props(['property'])

@php
    $primaryImage = $property->images->firstWhere('is_primary', true) ?? $property->images->sortBy('sort_order')->first();
@endphp

<a href="{{ route('properties.show', $property) }}" class="group card-hover overflow-hidden flex flex-col">
    <div class="relative h-56 overflow-hidden">
        @if($primaryImage)
            <img src="{{ $primaryImage->url }}" alt="{{ $property->title }}"
                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
        @else
            <img src="https://placehold.co/600x400/e2e8f0/94a3b8?text={{ urlencode('ملک') }}" alt="{{ $property->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
        @endif

        <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

        @if($property->status)
            <span class="absolute top-3 right-3 px-2.5 py-1 rounded-lg text-[11px] font-bold backdrop-blur-md
                {{ $property->status?->slug === 'active' ? 'bg-emerald-500/90 text-white shadow-lg shadow-emerald-500/20' : ($property->status?->slug === 'sold' ? 'bg-amber-500/90 text-white shadow-lg shadow-amber-500/20' : 'bg-surface-600/90 text-white shadow-lg shadow-surface-600/20') }}">
                {{ $property->status?->name_fa }}
            </span>
        @endif

        @if($property->is_sold)
            <div class="absolute inset-0 bg-surface-900/40 flex items-center justify-center">
                <span class="px-4 py-2 bg-surface-900/80 text-white rounded-lg text-sm font-bold backdrop-blur-sm">فروخته شده</span>
            </div>
        @endif
    </div>

    <div class="p-4 flex flex-col flex-1">
        <h3 class="font-bold text-[15px] text-surface-900 mb-1.5 line-clamp-1 group-hover:text-brand-600 transition-colors duration-200">
            {{ $property->title }}
        </h3>

        <div class="flex items-center gap-1.5 text-sm text-surface-500 mb-3">
            <svg class="w-3.5 h-3.5 text-surface-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <span class="truncate">{{ $property->location?->name ?? 'نامشخص' }}</span>
        </div>

        <div class="flex items-center gap-3 text-xs text-surface-500 mb-4">
            @if($property->bedrooms)
                <div class="flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 text-surface-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span>{{ $property->bedrooms }} خواب</span>
                </div>
            @endif
            @if($property->bathrooms)
                <div class="flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 text-surface-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>{{ $property->bathrooms }} سرویس</span>
                </div>
            @endif
            @if($property->area_total)
                <div class="flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 text-surface-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                    <span>{{ number_format($property->area_total) }} متر</span>
                </div>
            @endif
        </div>

        @if($property->type)
            <span class="inline-flex self-start px-2 py-0.5 bg-brand-50 text-brand-700 rounded-md text-[11px] font-medium border border-brand-100/60 mb-3">{{ $property->type->name_fa }}</span>
        @endif

        <div class="mt-auto pt-3 border-t border-surface-100 flex items-center justify-between">
            <div>
                <div class="text-lg font-extrabold text-surface-900 leading-tight">{{ number_format($property->price) }}</div>
                <div class="text-[11px] text-surface-400 font-medium">تومان</div>
            </div>
            <span class="text-xs text-brand-600 font-semibold flex items-center gap-1 group-hover:gap-2 transition-all duration-200">
                مشاهده
                <svg class="w-3.5 h-3.5 rotate-180 transition-transform duration-200 group-hover:-translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </span>
        </div>
    </div>
</a>
