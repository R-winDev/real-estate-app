<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $property->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <!-- Back link -->
            <div class="mb-6">
                <a href="{{ route('properties.index') }}"
                   class="text-blue-600 hover:underline">
                    ← بازگشت به لیست املاک
                </a>
            </div>

            <!-- Main property card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <!-- Image placeholder -->
                <div class="bg-gray-200 h-64 flex items-center justify-center">
                    <span class="text-gray-400 text-lg">تصویر ملک</span>
                </div>

                <div class="p-6">

                    <!-- Title & Status -->
                    <div class="flex justify-between items-start mb-4">
                        <h1 class="text-2xl font-bold text-gray-900">
                            {{ $property->title }}
                        </h1>
                        @if($property->status)
                            <span class="px-3 py-1 bg-blue-100 text-blue-800
                                   rounded-full text-sm font-medium">
                                {{ $property->status->name }}
                            </span>
                        @endif
                    </div>

                    <!-- Price -->
                    <div class="text-3xl font-bold text-blue-600 mb-6">
                        {{ number_format($property->price) }} تومان
                    </div>

                    <!-- Location & Type -->
                    <div class="grid grid-cols-2 gap-4 mb-6 text-gray-700">
                        @if($property->location)
                            <div><strong>📍 موقعیت:</strong>
                                {{ $property->location->name }}</div>
                        @endif
                        @if($property->type)
                            <div><strong>🏢 نوع:</strong>
                                {{ $property->type->name }}</div>
                        @endif
                    </div>

                    <!-- Description -->
                    @if($property->description)
                        <div class="mb-6">
                            <h3 class="font-semibold text-gray-900 mb-2">توضیحات</h3>
                            <p class="text-gray-600">{{ $property->description }}</p>
                        </div>
                    @endif

                    <!-- Property Details Grid -->
                    <div class="grid grid-cols-3 gap-4 mb-6 p-4
                               bg-gray-50 rounded-lg">
                        @if($property->area_total)
                            <div>
                                <span class="text-gray-500 text-sm">متراژ کل</span>
                                <p class="font-semibold">{{ $property->area_total }} متر²</p>
                            </div>
                        @endif
                        @if($property->area_useful)
                            <div>
                                <span class="text-gray-500 text-sm">متراژ مفید</span>
                                <p class="font-semibold">{{ $property->area_useful }} متر²</p>
                            </div>
                        @endif
                        @if($property->bedrooms)
                            <div>
                                <span class="text-gray-500 text-sm">اتاق خواب</span>
                                <p class="font-semibold">{{ $property->bedrooms }}</p>
                            </div>
                        @endif
                        @if($property->bathrooms)
                            <div>
                                <span class="text-gray-500 text-sm">سرویس بهداشتی</span>
                                <p class="font-semibold">{{ $property->bathrooms }}</p>
                            </div>
                        @endif
                        @if($property->year_built)
                            <div>
                                <span class="text-gray-500 text-sm">سال ساخت</span>
                                <p class="font-semibold">{{ $property->year_built }}</p>
                            </div>
                        @endif
                        @if($property->floor)
                            <div>
                                <span class="text-gray-500 text-sm">طبقه</span>
                                <p class="font-semibold">{{ $property->floor }} از {{ $property->total_floors }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Amenities (checkboxes) -->
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-900 mb-2">امکانات</h3>
                        <div class="flex flex-wrap gap-2">
                            @if($property->has_parking)
                                <span class="px-3 py-1 bg-green-100 text-green-800
                                       rounded-full text-sm">🅿️ پارکینگ</span>
                            @endif
                            @if($property->has_elevator)
                                <span class="px-3 py-1 bg-green-100 text-green-800
                                       rounded-full text-sm">🛗 آسانسور</span>
                            @endif
                            @if($property->has_storage)
                                <span class="px-3 py-1 bg-green-100 text-green-800
                                       rounded-full text-sm">📦 انباری</span>
                            @endif
                            @if($property->has_balcony)
                                <span class="px-3 py-1 bg-green-100 text-green-800
                                       rounded-full text-sm">🌇 بالکن</span>
                            @endif
                            @if($property->has_garden)
                                <span class="px-3 py-1 bg-green-100 text-green-800
                                       rounded-full text-sm">🌿 فضای سبز</span>
                            @endif
                        </div>
                    </div>

                    <!-- Address -->
                    @if($property->address_fa)
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                            <h3 class="font-semibold text-gray-900 mb-1">آدرس</h3>
                            <p class="text-gray-600">{{ $property->address_fa }}</p>
                        </div>
                    @endif

                    <!-- Owner info -->
                    @if($property->owner)
                        <div class="pt-4 border-t border-gray-200">
                            <span class="text-gray-500 text-sm">مالک:</span>
                            <span class="font-medium text-gray-900">
                                {{ $property->owner->name }}
                            </span>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
