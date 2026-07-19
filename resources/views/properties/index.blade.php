<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-surface-900 leading-tight">لیست املاک</h2>
            @auth
                <a href="{{ route('properties.create') }}" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    افزودن ملک
                </a>
            @endauth
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Search & Filter -->
            <form method="GET" action="{{ route('properties.index') }}" class="glass rounded-2xl p-5 mb-6 shadow-glass">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <input type="text" name="search" value="{{ request('search') }}"
                               class="form-input" placeholder="جستجو عنوان...">
                    </div>
                    <div>
                        <select name="type_id" class="form-select">
                            <option value="">همه انواع</option>
                            @foreach($propertyTypes as $type)
                                <option value="{{ $type->id }}" @selected(request('type_id') == $type->id)>{{ $type->name_fa }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <select name="location_id" class="form-select">
                            <option value="">همه موقعیت‌ها</option>
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}" @selected(request('location_id') == $location->id)>{{ $location->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="btn-primary flex-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            جستجو
                        </button>
                        <a href="{{ route('properties.index') }}" class="btn-secondary">پاک کردن</a>
                    </div>
                </div>
            </form>

            <!-- Properties Grid -->
            @if($properties->isEmpty())
                <div class="card p-12 text-center">
                    <div class="w-20 h-20 bg-surface-100 rounded-3xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-surface-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-surface-700 mb-2">ملکی یافت نشد</h3>
                    <p class="text-surface-500 mb-6">هیچ ملکی با فیلترهای انتخابی یافت نشد.</p>
                    @auth
                        <a href="{{ route('properties.create') }}" class="btn-primary">ثبت ملک جدید</a>
                    @endauth
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($properties as $property)
                        <x-property-card :property="$property"/>
                    @endforeach
                </div>

                @if($properties->hasPages())
                    <div class="mt-8">
                        {{ $properties->withQueryString()->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-app-layout>
