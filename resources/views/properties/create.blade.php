<x-admin-layout title="ثبت ملک جدید">
    <div class="max-w-4xl mx-auto">
        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
            <div>
                <h2 class="text-xl font-bold text-neutral-800">ثبت ملک جدید</h2>
                <p class="text-sm text-neutral-500 mt-1">اطلاعات ملک را وارد کنید</p>
            </div>
            <a href="{{ route('properties.index') }}" class="btn-secondary btn-sm">
                <svg class="w-4 h-4 rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                بازگشت
            </a>
        </div>

        <form action="{{ route('properties.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Section: Basic Info --}}
            <div class="rounded-xl border border-neutral-200 bg-white overflow-hidden">
                <div class="px-6 py-4 border-b border-neutral-100">
                    <h3 class="text-sm font-semibold text-neutral-700 flex items-center gap-2">
                        <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        اطلاعات پایه
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                        <x-form-input name="title" label="عنوان ملک" />
                        <x-form-select name="status_id" label="وضعیت ملک" :options="$propertyStatuses" />
                        <x-form-select name="type_id" label="نوع ملک" :options="$propertyTypes" />
                        <x-form-select name="location_id" label="موقعیت" :options="$locations" />
                    </div>
                    <div class="mt-5">
                        <x-form-textarea name="description" label="توضیحات" />
                    </div>
                </div>
            </div>

            {{-- Section: Area & Details --}}
            <div class="rounded-xl border border-neutral-200 bg-white overflow-hidden">
                <div class="px-6 py-4 border-b border-neutral-100">
                    <h3 class="text-sm font-semibold text-neutral-700 flex items-center gap-2">
                        <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                        متراژ و جزئیات
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-5">
                        <x-form-input name="area_total" type="number" label="متراژ کل (متر مربع)" />
                        <x-form-input name="area_useful" type="number" label="متراژ مفید (متر مربع)" />
                        <x-form-input name="year_built" type="number" label="سال ساخت" />
                        <x-form-input name="bedrooms" type="number" label="تعداد اتاق خواب" />
                        <x-form-input name="bathrooms" type="number" label="تعداد سرویس بهداشتی" />
                        <x-form-input name="floor" type="number" label="طبقه" />
                        <x-form-input name="total_floors" type="number" label="تعداد کل طبقات" />
                        <x-form-input name="parking_count" type="number" label="تعداد پارکینگ" />
                        <x-form-input name="units_count" type="number" label="تعداد واحد" />
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-5 mt-5">
                        <x-form-input name="land_length" type="number" label="طول زمین (متر)" />
                        <x-form-input name="land_width" type="number" label="عرض زمین (متر)" />
                        <x-form-input name="land_area" type="number" label="مساحت زمین (متر مربع)" />
                    </div>
                </div>
            </div>

            {{-- Section: Orientation --}}
            <div class="rounded-xl border border-neutral-200 bg-white overflow-hidden">
                <div class="px-6 py-4 border-b border-neutral-100">
                    <h3 class="text-sm font-semibold text-neutral-700 flex items-center gap-2">
                        <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        جهت ساختمان
                    </h3>
                </div>
                <div class="p-6">
                    <x-form-select name="orientation" label="جهت ملک"
                        :options="['شمالی' => 'شمالی', 'جنوبی' => 'جنوبی', 'شرقی' => 'شرقی', 'غربی' => 'غربی']" />
                </div>
            </div>

            {{-- Section: Amenities --}}
            <div class="rounded-xl border border-neutral-200 bg-white overflow-hidden">
                <div class="px-6 py-4 border-b border-neutral-100">
                    <h3 class="text-sm font-semibold text-neutral-700 flex items-center gap-2">
                        <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        امکانات
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                        <x-form-checkbox name="has_parking" label="پارکینگ" />
                        <x-form-checkbox name="has_elevator" label="آسانسور" />
                        <x-form-checkbox name="has_storage" label="انباری" />
                        <x-form-checkbox name="has_balcony" label="بالکن" />
                        <x-form-checkbox name="has_garden" label="فضای سبز" />
                    </div>
                </div>
            </div>

            {{-- Section: Price & Address --}}
            <div class="rounded-xl border border-neutral-200 bg-white overflow-hidden">
                <div class="px-6 py-4 border-b border-neutral-100">
                    <h3 class="text-sm font-semibold text-neutral-700 flex items-center gap-2">
                        <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        قیمت و آدرس
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                        <x-form-input name="price" type="number" label="قیمت (تومان)" />
                        <x-form-select name="owner_id" label="صاحب ملک" :options="$users" />
                    </div>
                    <div class="mt-5">
                        <x-form-input name="address_fa" label="آدرس کامل" />
                    </div>
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex items-center gap-4">
                <button type="submit" class="btn-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    ذخیره ملک
                </button>
                <a href="{{ route('properties.index') }}" class="btn-secondary">انصراف</a>
            </div>
        </form>
    </div>
</x-admin-layout>
