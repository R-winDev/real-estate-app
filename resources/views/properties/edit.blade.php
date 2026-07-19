<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-surface-900 leading-tight">ویرایش ملک: {{ $property->title }}</h2>
            <a href="{{ route('properties.show', $property) }}" class="btn-secondary text-sm">
                <svg class="w-4 h-4 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                بازگشت
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="card p-6 sm:p-8">

                <form action="{{ route('properties.update', $property) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <!-- Section: Basic Info -->
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-surface-900 mb-4 pb-2 border-b border-surface-100">اطلاعات پایه</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6">
                            <x-form-input name="title" label="عنوان ملک" :value="$property->title" />
                            <x-form-select name="status_id" label="وضعیت ملک"
                                           :options="$propertyStatuses" :selected="$property->status_id" />
                            <x-form-select name="type_id" label="نوع ملک"
                                           :options="$propertyTypes" :selected="$property->type_id" />
                            <x-form-select name="location_id" label="موقعیت"
                                           :options="$locations" :selected="$property->location_id" />
                        </div>
                        <div class="mt-4">
                            <x-form-textarea name="description" label="توضیحات" :value="$property->description" />
                        </div>
                    </div>

                    <!-- Section: Area & Details -->
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-surface-900 mb-4 pb-2 border-b border-surface-100">متراژ و جزئیات</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6">
                            <x-form-input name="area_total" type="number" label="متراژ کل (متر مربع)" :value="$property->area_total" />
                            <x-form-input name="area_useful" type="number" label="متراژ مفید (متر مربع)" :value="$property->area_useful" />
                            <x-form-input name="year_built" type="number" label="سال ساخت" :value="$property->year_built" />
                            <x-form-input name="bedrooms" type="number" label="تعداد اتاق خواب" :value="$property->bedrooms" />
                            <x-form-input name="bathrooms" type="number" label="تعداد سرویس بهداشتی" :value="$property->bathrooms" />
                            <x-form-input name="floor" type="number" label="طبقه" :value="$property->floor" />
                            <x-form-input name="total_floors" type="number" label="تعداد کل طبقات" :value="$property->total_floors" />
                            <x-form-input name="parking_count" type="number" label="تعداد پارکینگ" :value="$property->parking_count" />
                            <x-form-input name="units_count" type="number" label="تعداد واحد" :value="$property->units_count" />
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 mt-4">
                            <x-form-input name="land_length" type="number" label="طول زمین (متر)" :value="$property->land_length" />
                            <x-form-input name="land_width" type="number" label="عرض زمین (متر)" :value="$property->land_width" />
                            <x-form-input name="land_area" type="number" label="مساحت زمین (متر مربع)" :value="$property->land_area" />
                        </div>
                    </div>

                    <!-- Section: Orientation -->
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-surface-900 mb-4 pb-2 border-b border-surface-100">جهت ساختمان</h3>
                        <x-form-select name="orientation" label="جهت ملک"
                            :options="[' شمالی' => 'شمالی', 'جنوبی' => 'جنوبی', 'شرقی' => 'شرقی', 'غربی' => 'غربی']"
                            :selected="$property->orientation" />
                    </div>

                    <!-- Section: Amenities -->
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-surface-900 mb-4 pb-2 border-b border-surface-100">امکانات</h3>
                        <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                            <x-form-checkbox name="has_parking" label="پارکینگ" :checked="$property->has_parking" />
                            <x-form-checkbox name="has_elevator" label="آسانسور" :checked="$property->has_elevator" />
                            <x-form-checkbox name="has_storage" label="انباری" :checked="$property->has_storage" />
                            <x-form-checkbox name="has_balcony" label="بالکن" :checked="$property->has_balcony" />
                            <x-form-checkbox name="has_garden" label="فضای سبز" :checked="$property->has_garden" />
                        </div>
                    </div>

                    <!-- Section: Price & Address -->
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-surface-900 mb-4 pb-2 border-b border-surface-100">قیمت و آدرس</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6">
                            <x-form-input name="price" type="number" label="قیمت (تومان)" :value="$property->price" />
                            <x-form-select name="owner_id" label="صاحب ملک"
                                           :options="$users" :selected="$property->owner_id" />
                        </div>
                        <div class="mt-4">
                            <x-form-input name="address_fa" label="آدرس کامل" :value="$property->address_fa" />
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="flex items-center gap-4 pt-4 border-t border-surface-100">
                        <button type="submit" class="btn-primary">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            بروزرسانی ملک
                        </button>
                        <a href="{{ route('properties.show', $property) }}" class="btn-secondary">انصراف</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
