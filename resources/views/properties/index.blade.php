<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-xl text-neutral-950 leading-tight">جستجوی املاک</h2>
                <p class="text-sm text-neutral-500 mt-1">{{ number_format($properties->total()) }} ملک یافت شد</p>
            </div>
            <div class="flex items-center gap-3">
                @admin
                    <a href="{{ route('properties.create') }}" class="btn-primary btn-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        افزودن ملک
                    </a>
                @endadmin
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="container-wide">
            <div class="flex flex-col lg:flex-row gap-6">

                <aside class="lg:w-72 shrink-0" x-data="{ filtersOpen: false }">
                    <button @click="filtersOpen = !filtersOpen" class="lg:hidden w-full btn-secondary mb-4">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                        فیلترها
                    </button>

                    <form method="GET" action="{{ route('properties.index') }}"
                          :class="filtersOpen ? 'block' : 'hidden lg:block'"
                          class="rounded-xl border border-neutral-200 bg-white p-5 space-y-5 sticky top-20">
                        <div class="flex items-center justify-between">
                            <h3 class="font-bold text-neutral-950">فیلترها</h3>
                            <a href="{{ route('properties.index') }}" class="text-xs text-neutral-500 hover:text-primary-600 transition-colors">پاک کردن</a>
                        </div>

                        <div>
                            <label class="block mb-1.5 text-xs font-semibold text-neutral-600">جستجو</label>
                            <div class="relative">
                                <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-neutral-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                <input type="text" name="search" value="{{ request('search') }}"
                                       class="form-input pr-10 py-2.5 text-xs" placeholder="عنوان، آدرس...">
                            </div>
                        </div>

                        <div>
                            <label class="block mb-1.5 text-xs font-semibold text-neutral-600">نوع ملک</label>
                            <select name="type_id" class="form-select py-2.5 text-xs">
                                <option value="">همه انواع</option>
                                @foreach($propertyTypes as $type)
                                    <option value="{{ $type->id }}" @selected(request('type_id') == $type->id)>{{ $type->name_fa }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block mb-1.5 text-xs font-semibold text-neutral-600">موقعیت</label>
                            <select name="location_id" class="form-select py-2.5 text-xs">
                                <option value="">همه موقعیت‌ها</option>
                                @foreach($locations as $location)
                                    <option value="{{ $location->id }}" @selected(request('location_id') == $location->id)>{{ $location->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        @if(isset($propertyStatuses) && $propertyStatuses->count())
                        <div>
                            <label class="block mb-1.5 text-xs font-semibold text-neutral-600">وضعیت</label>
                            <select name="status_id" class="form-select py-2.5 text-xs">
                                <option value="">همه وضعیت‌ها</option>
                                @foreach($propertyStatuses as $status)
                                    <option value="{{ $status->id }}" @selected(request('status_id') == $status->id)>{{ $status->name_fa }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        <div>
                            <label class="block mb-1.5 text-xs font-semibold text-neutral-600">محدوده قیمت</label>
                            <div class="grid grid-cols-2 gap-2">
                                <input type="number" name="min_price" value="{{ request('min_price') }}"
                                       class="form-input py-2.5 text-xs" placeholder="از">
                                <input type="number" name="max_price" value="{{ request('max_price') }}"
                                       class="form-input py-2.5 text-xs" placeholder="تا">
                            </div>
                        </div>

                        <div>
                            <label class="block mb-1.5 text-xs font-semibold text-neutral-600">حداقل اتاق خواب</label>
                            <select name="bedrooms" class="form-select py-2.5 text-xs">
                                <option value="">همه</option>
                                @for($i = 1; $i <= 6; $i++)
                                    <option value="{{ $i }}" @selected(request('bedrooms') == $i)>{{ $i }}+</option>
                                @endfor
                            </select>
                        </div>

                        <div>
                            <label class="block mb-1.5 text-xs font-semibold text-neutral-600">مرتب‌سازی</label>
                            <select name="sort" class="form-select py-2.5 text-xs">
                                <option value="latest" @selected(request('sort') === 'latest')>جدیدترین</option>
                                <option value="price_asc" @selected(request('sort') === 'price_asc')>ارزان‌ترین</option>
                                <option value="price_desc" @selected(request('sort') === 'price_desc')>گران‌ترین</option>
                                <option value="area" @selected(request('sort') === 'area')>بزرگ‌ترین</option>
                            </select>
                        </div>

                        <button type="submit" class="btn-primary w-full py-2.5 text-xs">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            اعمال فیلترها
                        </button>
                    </form>
                </aside>

                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between mb-4 lg:mb-6">
                        <div class="flex items-center gap-2" x-data="{ view: 'grid' }">
                            <button @click="view = 'grid'; $refs.gridView.classList.remove('hidden'); $refs.listView.classList.add('hidden')"
                                    :class="view === 'grid' ? 'bg-primary-50 text-primary-600 border-primary-200' : 'bg-white text-neutral-500 border-neutral-200'"
                                    class="p-2 rounded-lg border transition-all duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                            </button>
                            <button @click="view = 'list'; $refs.listView.classList.remove('hidden'); $refs.gridView.classList.add('hidden')"
                                    :class="view === 'list' ? 'bg-primary-50 text-primary-600 border-primary-200' : 'bg-white text-neutral-500 border-neutral-200'"
                                    class="p-2 rounded-lg border transition-all duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                            </button>
                        </div>

                        <select onchange="window.location.href=this.value" class="form-select py-2 px-3 text-xs w-auto min-w-0">
                            <option value="{{ route('properties.index', array_merge(request()->query(), ['sort' => 'latest'])) }}" @selected(request('sort') === 'latest')>جدیدترین</option>
                            <option value="{{ route('properties.index', array_merge(request()->query(), ['sort' => 'price_asc'])) }}" @selected(request('sort') === 'price_asc')>ارزان‌ترین</option>
                            <option value="{{ route('properties.index', array_merge(request()->query(), ['sort' => 'price_desc'])) }}" @selected(request('sort') === 'price_desc')>گران‌ترین</option>
                            <option value="{{ route('properties.index', array_merge(request()->query(), ['sort' => 'area'])) }}" @selected(request('sort') === 'area')>بزرگ‌ترین</option>
                        </select>
                    </div>

                    @if($properties->isEmpty())
                        <div class="rounded-xl border border-neutral-200 bg-white p-12 text-center">
                            <div class="w-20 h-20 bg-neutral-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            </div>
                            <h3 class="text-xl font-bold text-neutral-700 mb-2">ملکی یافت نشد</h3>
                            <p class="text-neutral-500 mb-6 text-sm">هیچ ملکی با فیلترهای انتخابی یافت نشد. فیلترها را تغییر دهید.</p>
                            <a href="{{ route('properties.index') }}" class="btn-secondary btn-sm">پاک کردن فیلترها</a>
                        </div>
                    @else
                        <div x-ref="gridView" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                            @foreach($properties as $property)
                                <x-property-card :property="$property"/>
                            @endforeach
                        </div>

                        <div x-ref="listView" class="hidden space-y-4">
                            @foreach($properties as $property)
                                <x-property-list-item :property="$property"/>
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
        </div>
    </div>
</x-app-layout>
