@props(['property'])

@php
    $primaryImage = $property->images->firstWhere('is_primary', true) ?? $property->images->sortBy('sort_order')->first();
    $isRental = $property->listing_type === 'rental';
@endphp

<a href="{{ route('properties.show', $property) }}" class="group rounded-xl border border-neutral-200 bg-white overflow-hidden flex flex-row cursor-pointer hover:shadow-card-hover hover:border-neutral-300 transition-all duration-300">
    <div class="relative w-48 sm:w-64 shrink-0 overflow-hidden min-h-[180px]">
        @if($primaryImage)
            <img src="{{ $primaryImage->url }}" alt="{{ $property->title }}"
                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
        @else
            @php
                $typeSlug = match($property->type?->name_fa) {
                    'آپارتمان' => 'apartment',
                    'ویلا' => 'villa',
                    'مغازه' => 'shop',
                    'زمین' => 'land',
                    default => 'apartment',
                };
            @endphp
            <img src="{{ asset("images/properties/{$typeSlug}/{$typeSlug}.png") }}" alt="{{ $property->title }}"
                 class="w-full h-full object-cover min-h-[180px]">
        @endif

        @if($property->status)
            @if($property->status?->slug === 'available_for_rent')
                <span class="absolute top-3 right-3 px-2 py-0.5 rounded-md text-[10px] font-bold bg-accent-500 text-white shadow-lg shadow-accent-500/25">{{ $property->status?->name_fa }}</span>
            @elseif($property->status?->slug === 'rented_out')
                <span class="absolute top-3 right-3 px-2 py-0.5 rounded-md text-[10px] font-bold bg-warning-500 text-white shadow-lg shadow-warning-500/25">{{ $property->status?->name_fa }}</span>
            @elseif($property->status?->slug === 'unsold')
                <span class="absolute top-3 right-3 px-2 py-0.5 rounded-md text-[10px] font-bold bg-success-500 text-white shadow-lg shadow-success-500/25">{{ $property->status?->name_fa }}</span>
            @elseif($property->status?->slug === 'sold')
                <span class="absolute top-3 right-3 px-2 py-0.5 rounded-md text-[10px] font-bold bg-danger-500 text-white shadow-lg shadow-danger-500/25">{{ $property->status?->name_fa }}</span>
            @else
                <span class="absolute top-3 right-3 px-2 py-0.5 rounded-md text-[10px] font-bold bg-neutral-600 text-white shadow-lg shadow-neutral-600/25">{{ $property->status?->name_fa }}</span>
            @endif
        @endif

    </div>

    <div class="flex-1 p-4 flex flex-col justify-between">
        <div>
            <div class="flex items-start justify-between gap-2 mb-1">
                <h3 class="font-bold text-[15px] text-neutral-950 line-clamp-1 group-hover:text-primary-600 transition-colors duration-200">
                    {{ $property->title }}
                </h3>
                @if($property->is_sold)
                    <span class="badge-danger text-[10px] shrink-0">فروخته شده</span>
                @endif
            </div>

            <div class="flex items-center gap-1.5 text-sm text-neutral-500 mb-2">
                <svg class="w-3.5 h-3.5 text-neutral-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span class="truncate">{{ $property->location?->name ?? 'نامشخص' }}</span>
            </div>

            <div class="flex items-center gap-3 text-xs text-neutral-500">
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
                    <span class="px-1.5 py-0.5 bg-primary-50 text-primary-700 rounded text-[10px] font-medium">{{ $property->type->name_fa }}</span>
                @endif
            </div>
        </div>

        <div class="flex items-center justify-between mt-3 pt-3 border-t border-neutral-100">
            @if($isRental)
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-1.5">
                        <span class="text-[9px] text-accent-600 font-bold bg-accent-50 px-1.5 py-0.5 rounded">رهن</span>
                        <span class="text-sm font-bold text-neutral-950">{{ number_format($property->deposit_amount ?? 0) }}</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="text-[9px] text-primary-600 font-bold bg-primary-50 px-1.5 py-0.5 rounded">اجاره</span>
                        <span class="text-sm font-bold text-primary-700">{{ number_format($property->rent_amount ?? 0) }}</span>
                        <span class="text-[9px] text-neutral-400 font-medium">ماهانه</span>
                    </div>
                </div>
            @else
                <div class="text-lg font-extrabold text-neutral-950">{{ number_format($property->price) }} <span class="text-xs font-medium text-neutral-400">تومان</span></div>
            @endif
            <span class="text-xs text-accent-600 font-semibold flex items-center gap-1 group-hover:gap-2 transition-all duration-200">
                مشاهده جزئیات
                <svg class="w-3.5 h-3.5 icon-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </span>
        </div>
    </div>
</a>
