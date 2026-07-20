<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-surface-900 leading-tight">{{ $property->title }}</h2>
            @admin
                <div class="flex gap-2">
                    <a href="{{ route('properties.edit', $property) }}" class="btn-secondary btn-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        ویرایش
                    </a>
                    <form method="POST" action="{{ route('properties.destroy', $property) }}"
                          onsubmit="return confirm('آیا از حذف این ملک اطمینان دارید؟')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger btn-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            حذف
                        </button>
                    </form>
                </div>
            @endadmin
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <!-- Back Link -->
            <div class="mb-6">
                <a href="{{ route('properties.index') }}" class="inline-flex items-center gap-2 text-sm text-surface-500 hover:text-surface-700 transition-colors duration-200 group">
                    <svg class="w-4 h-4 rotate-180 transition-transform duration-200 group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    بازگشت به لیست املاک
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Image Placeholder -->
                    <div class="card overflow-hidden">
                        <div class="bg-gradient-to-br from-brand-100 via-brand-50 to-surface-100 h-72 md:h-96 flex items-center justify-center relative">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent"></div>
                            <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle, currentColor 1px, transparent 1px); background-size: 20px 20px; color: #0f766e;"></div>
                            <div class="text-center relative z-10">
                                <svg class="w-20 h-20 text-brand-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                <p class="text-brand-400 font-medium">تصویر ملک</p>
                            </div>
                        </div>
                    </div>

                    <!-- Title & Status -->
                    <div class="card p-6">
                        <div class="flex flex-wrap justify-between items-start gap-3 mb-4">
                            <h1 class="text-2xl font-extrabold text-surface-900">{{ $property->title }}</h1>
                            @if($property->status)
                                <span class="px-3 py-1.5 rounded-full text-sm font-bold
                                    {{ $property->status->slug === 'active' ? 'badge-success' : ($property->status->slug === 'sold' ? 'badge-warning' : 'badge-neutral') }}">
                                    {{ $property->status->name_fa }}
                                </span>
                            @endif
                        </div>

                        @if($property->type)
                            <span class="inline-block px-3 py-1 bg-brand-50 text-brand-700 rounded-full text-sm font-medium mb-4 border border-brand-100/60">
                                {{ $property->type->name_fa }}
                            </span>
                        @endif

                        <!-- Price -->
                        <div class="bg-gradient-to-l from-brand-50 to-brand-100/50 rounded-2xl p-5 mb-4 border border-brand-100/60">
                            <div class="text-sm text-brand-600 mb-1">قیمت</div>
                            <div class="text-3xl font-extrabold text-brand-700">{{ number_format($property->price) }} <span class="text-lg">تومان</span></div>
                        </div>

                        <!-- Description -->
                        @if($property->description)
                            <div class="mt-4">
                                <h3 class="font-bold text-surface-900 mb-2">توضیحات</h3>
                                <p class="text-surface-600 leading-relaxed">{{ $property->description }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Details Grid -->
                    <div class="card p-6">
                        <h3 class="font-bold text-surface-900 mb-4">مشخصات ملک</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            @if($property->area_total)
                                <div class="bg-surface-50 rounded-xl p-4 hover:bg-brand-50 transition-colors duration-200 border border-transparent hover:border-brand-100/60">
                                    <div class="text-xs text-surface-500 mb-1">متراژ کل</div>
                                    <div class="font-bold text-surface-900">{{ number_format($property->area_total) }} متر مربع</div>
                                </div>
                            @endif
                            @if($property->area_useful)
                                <div class="bg-surface-50 rounded-xl p-4 hover:bg-brand-50 transition-colors duration-200 border border-transparent hover:border-brand-100/60">
                                    <div class="text-xs text-surface-500 mb-1">متراژ مفید</div>
                                    <div class="font-bold text-surface-900">{{ number_format($property->area_useful) }} متر مربع</div>
                                </div>
                            @endif
                            @if($property->bedrooms)
                                <div class="bg-surface-50 rounded-xl p-4 hover:bg-brand-50 transition-colors duration-200 border border-transparent hover:border-brand-100/60">
                                    <div class="text-xs text-surface-500 mb-1">اتاق خواب</div>
                                    <div class="font-bold text-surface-900">{{ $property->bedrooms }} اتاق</div>
                                </div>
                            @endif
                            @if($property->bathrooms)
                                <div class="bg-surface-50 rounded-xl p-4 hover:bg-brand-50 transition-colors duration-200 border border-transparent hover:border-brand-100/60">
                                    <div class="text-xs text-surface-500 mb-1">سرویس بهداشتی</div>
                                    <div class="font-bold text-surface-900">{{ $property->bathrooms }}</div>
                                </div>
                            @endif
                            @if($property->year_built)
                                <div class="bg-surface-50 rounded-xl p-4 hover:bg-brand-50 transition-colors duration-200 border border-transparent hover:border-brand-100/60">
                                    <div class="text-xs text-surface-500 mb-1">سال ساخت</div>
                                    <div class="font-bold text-surface-900">{{ $property->year_built }}</div>
                                </div>
                            @endif
                            @if($property->floor)
                                <div class="bg-surface-50 rounded-xl p-4 hover:bg-brand-50 transition-colors duration-200 border border-transparent hover:border-brand-100/60">
                                    <div class="text-xs text-surface-500 mb-1">طبقه</div>
                                    <div class="font-bold text-surface-900">{{ $property->floor }} از {{ $property->total_floors }}</div>
                                </div>
                            @endif
                            @if($property->parking_count)
                                <div class="bg-surface-50 rounded-xl p-4 hover:bg-brand-50 transition-colors duration-200 border border-transparent hover:border-brand-100/60">
                                    <div class="text-xs text-surface-500 mb-1">پارکینگ</div>
                                    <div class="font-bold text-surface-900">{{ $property->parking_count }} عدد</div>
                                </div>
                            @endif
                            @if($property->orientation)
                                <div class="bg-surface-50 rounded-xl p-4 hover:bg-brand-50 transition-colors duration-200 border border-transparent hover:border-brand-100/60">
                                    <div class="text-xs text-surface-500 mb-1">جهت ملک</div>
                                    <div class="font-bold text-surface-900">{{ $property->orientation }}</div>
                                </div>
                            @endif
                            @if($property->land_area)
                                <div class="bg-surface-50 rounded-xl p-4 hover:bg-brand-50 transition-colors duration-200 border border-transparent hover:border-brand-100/60">
                                    <div class="text-xs text-surface-500 mb-1">مساحت زمین</div>
                                    <div class="font-bold text-surface-900">{{ number_format($property->land_area) }} متر مربع</div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Amenities -->
                    <div class="card p-6">
                        <h3 class="font-bold text-surface-900 mb-4">امکانات</h3>
                        <div class="flex flex-wrap gap-2">
                            @if($property->has_parking)
                                <span class="badge-success">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    پارکینگ
                                </span>
                            @endif
                            @if($property->has_elevator)
                                <span class="badge-success">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    آسانسور
                                </span>
                            @endif
                            @if($property->has_storage)
                                <span class="badge-success">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    انباری
                                </span>
                            @endif
                            @if($property->has_balcony)
                                <span class="badge-success">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    بالکن
                                </span>
                            @endif
                            @if($property->has_garden)
                                <span class="badge-success">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    فضای سبز
                                </span>
                            @endif

                            @unless($property->has_parking || $property->has_elevator || $property->has_storage || $property->has_balcony || $property->has_garden)
                                <p class="text-surface-500 text-sm">امکاناتی ثبت نشده است.</p>
                            @endunless
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Location -->
                    @if($property->location)
                        <div class="card p-6">
                            <h3 class="font-bold text-surface-900 mb-3">موقعیت</h3>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-brand-100 rounded-xl flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <div class="font-bold text-surface-900">{{ $property->location->name }}</div>
                            </div>
                        </div>
                    @endif

                    <!-- Address -->
                    @if($property->address_fa)
                        <div class="card p-6">
                            <h3 class="font-bold text-surface-900 mb-3">آدرس</h3>
                            <p class="text-surface-600 leading-relaxed">{{ $property->address_fa }}</p>
                        </div>
                    @endif

                    <!-- Owner Info -->
                    @admin
                        @if($property->owner)
                            <div class="card p-6">
                                <h3 class="font-bold text-surface-900 mb-3">مالک</h3>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-brand-500 to-brand-600 rounded-xl flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    </div>
                                    <div>
                                        <div class="font-bold text-surface-900">{{ $property->owner->name }}</div>
                                        <div class="text-sm text-surface-500">{{ $property->owner->email }}</div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endadmin

                    <!-- Quick Actions -->
                    @admin
                        <div class="card p-6">
                            <h3 class="font-bold text-surface-900 mb-3">عملیات</h3>
                            <div class="space-y-3">
                                <a href="{{ route('properties.edit', $property) }}" class="btn-primary w-full text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    ویرایش ملک
                                </a>
                                <form method="POST" action="{{ route('properties.destroy', $property) }}"
                                      onsubmit="return confirm('آیا از حذف این ملک اطمینان دارید؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-danger w-full text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        حذف ملک
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endadmin
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
