<x-app-layout>
    <x-slot name="header">
        <h2>ایجاد ملک جدید</h2>
    </x-slot>



    <form action="{{ route('properties.store') }}" method="POST">
        @csrf
        <x-form-select name="status_id" label="وضعیت ملک" :options="$propertyStatuses" />
        <x-form-select name="type_id" label="نوع ملک" :options="$propertyTypes" />
        <x-form-select name="location_id" label="موقعیت" :options="$locations" />
        <x-form-select name="owner_id" label="صاحب ملک" :options="$users" />

        <x-form-input name="title" label="عنوان"/>
        <x-form-textarea name="description" label="توضیحات" />
        <x-form-input name="area_total" type="number" label="متراژ"/>
        <x-form-input name="area_useful" type="number" label="متراژ مفید"/>
        <x-form-input name="year_built" type="number" label="سال ساخت"/>

        <x-form-checkbox name="has_parking" label="پارکینگ"/>
        <x-form-checkbox name="has_elevator" label="آسانسور"/>
        <x-form-checkbox name="has_storage" label="انباری"/>
        <x-form-checkbox name="has_balcony" label="بالکن"/>
        <x-form-checkbox name="has_garden" label="فضای سبز"/>

        <x-form-input name="price" label="قیمت" type="number" />
        <x-form-input name="address_fa" label="آدرس"/>

        <button type="submit">ذخیره</button>
    </form>
</x-app-layout>
