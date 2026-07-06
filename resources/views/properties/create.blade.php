<x-app-layout>
    <x-slot name="header">
        <h2>ایجاد ملک جدید</h2>
    </x-slot>

    <form action="{{ route('properties.store') }}" method="POST">
        @csrf
        <x-form-select name="status_id" label="وضعیت ملک" :options="$propertyStatuses" />
        <x-form-select name="type_id" label="نوع ملک" :options="$propertyTypes" />
        <x-form-select name="location_id" label="موقعیت" :options="$locations" />

        <x-form-input name="title" label="عنوان"/>
        <x-form-textarea name="description" label="توضیحات" />
        <x-form-input name="area_total" type="number" label="متراژ"/>
        <x-form-input name="area_useful" type="number" label="متراژ مفید"/>

        <x-form-input name="has_parking" type="checkbox" label="پارکینگ"/>
        <x-form-input name="has_elevator" type="checkbox" label="آسانسور"/>
        <x-form-input name="has_storage" type="checkbox" label="انباری"/>
        <x-form-input name="has_balcony" type="checkbox" label="بالکن"/>
        <x-form-input name="has_garden" type="checkbox" label="فضای سبز"/>

        <x-form-input name="price" label="قیمت" type="number" />
        <x-form-input name="address_fa" label="آدرس"/>

        <button type="submit">ذخیره</button>
    </form>
</x-app-layout>
