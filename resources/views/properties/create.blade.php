<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-surface-900 leading-tight">ثبت ملک جدید</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="card p-6 sm:p-8">

                <form action="{{ route('properties.store') }}" method="POST">
                    @csrf

                    <!-- Section: Basic Info -->
                    <div class="mb-8">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-8 h-8 bg-brand-100 rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <h3 class="text-lg font-bold text-surface-900">اطلاعات پایه</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6">
                            <x-form-input name="title" label="عنوان ملک" />
                            <x-form-select name="status_id" label="وضعیت ملک" :options="$propertyStatuses" />
                            <x-form-select name="type_id" label="نوع ملک" :options="$propertyTypes" />
                            <x-form-select name="location_id" label="موقعیت" :options="$locations" />
                        </div>
                        <div class="mt-2">
                            <x-form-textarea name="description" label="توضیحات" />
                        </div>
                    </div>

                    <!-- Section: Area & Details -->
                    <div class="mb-8">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-8 h-8 bg-brand-100 rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                            </div>
                            <h3 class="text-lg font-bold text-surface-900">متراژ و جزئیات</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6">
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
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 mt-2">
                            <x-form-input name="land_length" type="number" label="طول زمین (متر)" />
                            <x-form-input name="land_width" type="number" label="عرض زمین (متر)" />
                            <x-form-input name="land_area" type="number" label="مساحت زمین (متر مربع)" />
                        </div>
                    </div>

                    <!-- Section: Orientation -->
                    <div class="mb-8">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-8 h-8 bg-brand-100 rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            </div>
                            <h3 class="text-lg font-bold text-surface-900">جهت ساختمان</h3>
                        </div>
                        <x-form-select name="orientation" label="جهت ملک"
                            :options="['شمالی' => 'شمالی', 'جنوبی' => 'جنوبی', 'شرقی' => 'شرقی', 'غربی' => 'غربی']" />
                    </div>

                    <!-- Section: Amenities -->
                    <div class="mb-8">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-8 h-8 bg-brand-100 rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <h3 class="text-lg font-bold text-surface-900">امکانات</h3>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                            <x-form-checkbox name="has_parking" label="پارکینگ" />
                            <x-form-checkbox name="has_elevator" label="آسانسور" />
                            <x-form-checkbox name="has_storage" label="انباری" />
                            <x-form-checkbox name="has_balcony" label="بالکن" />
                            <x-form-checkbox name="has_garden" label="فضای سبز" />
                        </div>
                    </div>

                    <!-- Section: Price & Address -->
                    <div class="mb-8">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-8 h-8 bg-brand-100 rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <h3 class="text-lg font-bold text-surface-900">قیمت و آدرس</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6">
                            <x-form-input name="price" type="number" label="قیمت (تومان)" />
                            <x-form-select name="owner_id" label="صاحب ملک" :options="$users" />
                        </div>
                        <div class="mt-2">
                            <x-form-input name="address_fa" label="آدرس کامل" />
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="flex items-center gap-4 pt-6 border-t border-surface-100">
                        <button type="submit" class="btn-primary">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            ذخیره ملک
                        </button>
                        <a href="{{ route('properties.index') }}" class="btn-secondary">انصراف</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
