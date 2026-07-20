@props(['property'])

<a href="{{ route('properties.show', $property) }}" class="group card-hover overflow-hidden">
    <!-- Image Placeholder -->
    <div class="relative bg-gradient-to-br from-brand-100 via-brand-50 to-surface-100 h-56 flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <svg class="w-16 h-16 text-brand-200 group-hover:scale-110 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
        @if($property->status)
            <span class="absolute top-3 right-3 px-3 py-1.5 rounded-full text-xs font-bold backdrop-blur-md
                {{ $property->status?->slug === 'active' ? 'bg-emerald-500/90 text-white shadow-lg shadow-emerald-500/25' : ($property->status?->slug === 'sold' ? 'bg-amber-500/90 text-white shadow-lg shadow-amber-500/25' : 'bg-surface-500/90 text-white shadow-lg shadow-surface-500/25') }}">
                {{ $property->status?->name_fa }}
            </span>
        @endif
    </div>

    <div class="p-5">
        <!-- Title -->
        <h3 class="font-bold text-base text-surface-900 mb-2 line-clamp-1 group-hover:text-brand-600 transition-colors duration-200">
            {{ $property->title }}
        </h3>

        <!-- Location -->
        <div class="flex items-center gap-1.5 text-sm text-surface-500 mb-3">
            <svg class="w-4 h-4 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <span class="truncate">{{ $property->location?->name ?? 'نامشخص' }}</span>
        </div>

        <!-- Details Row -->
        <div class="flex items-center gap-2 text-xs text-surface-500 mb-4">
            @if($property->area_total)
                <div class="flex items-center gap-1 bg-surface-50 px-2.5 py-1.5 rounded-lg">
                    <svg class="w-3.5 h-3.5 text-surface-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                    {{ number_format($property->area_total) }} متر
                </div>
            @endif
            @if($property->bedrooms)
                <div class="flex items-center gap-1 bg-surface-50 px-2.5 py-1.5 rounded-lg">
                    <svg class="w-3.5 h-3.5 text-surface-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    {{ $property->bedrooms }} خواب
                </div>
            @endif
            @if($property->type)
                <span class="px-2.5 py-1.5 bg-brand-50 text-brand-700 rounded-lg text-xs font-medium border border-brand-100/60">{{ $property->type->name_fa }}</span>
            @endif
        </div>

        <!-- Price -->
        <div class="flex items-center justify-between pt-4 border-t border-surface-100">
            <div>
                <div class="text-lg font-extrabold text-brand-700">{{ number_format($property->price) }}</div>
                <div class="text-xs text-surface-400">تومان</div>
            </div>
            <span class="text-sm text-brand-600 font-semibold flex items-center gap-1 group-hover:gap-2 transition-all duration-200">
                مشاهده
                <svg class="w-4 h-4 rotate-180 transition-transform duration-200 group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </span>
        </div>
    </div>
</a>
