<x-admin-layout title="افزودن موقعیت">
    <div class="max-w-xl">
        {{-- Page Header --}}
        <div class="mb-6">
            <h2 class="text-xl font-bold text-neutral-800">افزودن موقعیت</h2>
            <p class="text-sm text-neutral-500 mt-1">موقعیت جدید در سیستم ثبت کنید</p>
        </div>

        {{-- Form Card --}}
        <div class="rounded-xl border border-neutral-200 bg-white overflow-hidden">
            <form method="POST" action="{{ route('admin.locations.store') }}">
                @csrf

                {{-- Section: Location Info --}}
                <div class="px-6 py-4 border-b border-neutral-100">
                    <h3 class="text-sm font-semibold text-neutral-700 flex items-center gap-2">
                        <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        اطلاعات موقعیت
                    </h3>
                </div>
                <div class="p-6 space-y-5">
                    <x-form-input name="name" :value="old('name')" label="نام" required />

                    <x-form-input name="slug" :value="old('slug')" label="پیوند یکتا" optional dir="ltr" placeholder="خودکار">
                        <x-slot name="helper">در صورت خالی گذاشتن، به صورت خودکار تولید می‌شود</x-slot>
                    </x-form-input>

                    <x-form-select name="parent_id" label="والد" :options="$parentLocations->pluck('name', 'id')->prepend('بدون والد', '')" :selected="old('parent_id')" />
                </div>

                {{-- Section: Coordinates --}}
                <div class="px-6 py-4 border-t border-neutral-100 border-b border-neutral-100">
                    <h3 class="text-sm font-semibold text-neutral-700 flex items-center gap-2">
                        <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                        مختصات جغرافیایی
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4">
                        <x-form-input name="latitude" :value="old('latitude')" label="عرض جغرافیایی" type="number" step="any" dir="ltr" />
                        <x-form-input name="longitude" :value="old('longitude')" label="طول جغرافیایی" type="number" step="any" dir="ltr" />
                    </div>
                </div>

                {{-- Actions --}}
                <div class="px-6 py-4 border-t border-neutral-100 bg-neutral-50/50 flex items-center gap-3">
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        ذخیره
                    </button>
                    <a href="{{ route('admin.locations.index') }}" class="btn-secondary">انصراف</a>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
