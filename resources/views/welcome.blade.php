<x-app-layout>
    <section class="relative bg-gradient-to-br from-primary-700 via-primary-800 to-primary-900 text-white overflow-hidden">
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-20 -right-20 w-96 h-96 bg-accent-400/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-32 -left-32 w-80 h-80 bg-primary-400/10 rounded-full blur-3xl"></div>
            <div class="absolute inset-0 opacity-[0.04]" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 40px 40px;"></div>
        </div>

        <div class="relative container-wide section-padding pb-12 md:pb-20">
            <div class="max-w-3xl mb-10">
                <div class="inline-flex items-center gap-2.5 bg-white/10 backdrop-blur-sm rounded-full px-4 py-2 mb-6 border border-white/10">
                    <span class="w-2 h-2 bg-success-500 rounded-full animate-pulse"></span>
                    <span class="text-sm font-medium text-primary-100">بیش از {{ number_format($stats['total_properties']) }} ملک فعال</span>
                </div>

                <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold mb-4 leading-tight tracking-tight">
                    خانه رویاهایت را
                    <span class="text-accent-400">پیدا کن</span>
                </h1>

                <p class="text-base md:text-lg text-primary-200/70 leading-relaxed max-w-xl">
                    جستجوی پیشرفته در میان صدها ملک با اطلاعات معتبر و به‌روز.
                </p>
            </div>

            <form action="{{ route('properties.index') }}" method="GET"
                  class="bg-white rounded-2xl p-2 shadow-elevated-lg max-w-4xl">
                <div class="flex flex-col md:flex-row gap-2">
                    <div class="flex-1 relative">
                        <svg class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 text-neutral-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" name="search" placeholder="جستجو در عنوان، آدرس یا توضیحات..."
                               class="w-full pr-12 pl-4 py-3.5 rounded-xl border-0 bg-neutral-50 text-sm text-neutral-800 placeholder:text-neutral-400 focus:ring-2 focus:ring-primary-300 focus:bg-white transition-all duration-200">
                    </div>
                    <div class="flex gap-2">
                        <select name="type_id" class="px-4 py-3.5 rounded-xl border-0 bg-neutral-50 text-sm text-neutral-700 focus:ring-2 focus:ring-primary-300 transition-all duration-200 min-w-[140px]" style="padding-right:30px">
                            <option value="">همه انواع</option>
                            @foreach($propertyTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name_fa }}</option>
                            @endforeach
                        </select>
                        <select name="location_id" class="px-4 py-3.5 rounded-xl border-0 bg-neutral-50 text-sm text-neutral-700 focus:ring-2 focus:ring-primary-300 transition-all duration-200 min-w-[140px]" style="padding-right:30px">
                            <option value="">همه موقعیت‌ها</option>
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}">{{ $location->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-3.5 rounded-xl font-semibold text-sm transition-all duration-200 flex items-center gap-2 shrink-0 shadow-sm shadow-primary-500/20 hover:shadow-md hover:shadow-primary-500/30">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            جستجو
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    @if($propertyTypes->count())
    <section class="bg-white border-b border-neutral-100">
        <div class="container-wide py-5">
            <div class="flex items-center gap-4 overflow-x-auto pb-1" style="scrollbar-width: none;">
                <span class="text-sm font-semibold text-neutral-500 shrink-0">دسته‌بندی:</span>
                <a href="{{ route('properties.index') }}" class="shrink-0 px-4 py-2 rounded-full text-sm font-medium bg-neutral-100 text-neutral-600 hover:bg-primary-50 hover:text-primary-700 hover:border-primary-200 border border-transparent cursor-pointer transition-all duration-200">
                    همه
                </a>
                @foreach($propertyTypes as $type)
                    <a href="{{ route('properties.index', ['type_id' => $type->id]) }}"
                       class="shrink-0 px-4 py-2 rounded-full text-sm font-medium bg-neutral-100 text-neutral-600 hover:bg-primary-50 hover:text-primary-700 hover:border-primary-200 border border-transparent cursor-pointer transition-all duration-200">
                        {{ $type->name_fa }}
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if($featuredProperties->count())
    <section class="section-padding">
        <div class="container-wide">
            <div class="flex justify-between items-end mb-10">
                <div>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-neutral-950">آخرین املاک</h2>
                    <p class="text-neutral-500 mt-2 text-sm">جدیدترین املاک ثبت شده در سامانه</p>
                </div>
                <a href="{{ route('properties.index') }}" class="btn-secondary btn-sm hidden sm:inline-flex">
                    مشاهده همه
                    <svg class="w-4 h-4 icon-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($featuredProperties as $property)
                    <x-property-card :property="$property"/>
                @endforeach
            </div>

            <div class="mt-8 text-center sm:hidden">
                <a href="{{ route('properties.index') }}" class="btn-secondary">
                    مشاهده همه املاک
                    <svg class="w-4 h-4 icon-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </section>
    @endif

    <section class="section-padding bg-white">
        <div class="container-wide">
            <div class="text-center mb-14">
                <h2 class="text-2xl md:text-3xl font-extrabold text-neutral-950">چرا ما؟</h2>
                <p class="text-neutral-500 mt-3 text-sm">امکانات ویژه برای تجربه بهتر خرید و فروش ملک</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="group text-center p-8 rounded-2xl bg-gradient-to-br from-neutral-50 to-white border border-neutral-200 hover:border-primary-200 hover:shadow-soft transition-all duration-300">
                    <div class="w-14 h-14 bg-gradient-to-br from-primary-500 to-primary-600 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg shadow-primary-500/20 group-hover:scale-110 transition-all duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-neutral-950 mb-3">جستجوی پیشرفته</h3>
                    <p class="text-neutral-500 leading-relaxed text-sm">با فیلترهای پیشرفته بر اساس موقعیت، قیمت، متراژ و امکانات، ملک دلخواه خود را سریع پیدا کنید.</p>
                </div>

                <div class="group text-center p-8 rounded-2xl bg-gradient-to-br from-neutral-50 to-white border border-neutral-200 hover:border-primary-200 hover:shadow-soft transition-all duration-300">
                    <div class="w-14 h-14 bg-gradient-to-br from-accent-500 to-accent-600 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg shadow-accent-500/20 group-hover:scale-110 transition-all duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-neutral-950 mb-3">اطلاعات معتبر</h3>
                    <p class="text-neutral-500 leading-relaxed text-sm">تمامی اطلاعات املاک توسط کارشناسان ما تایید شده و با اطمینان خاطر می‌توانید تصمیم بگیرید.</p>
                </div>

                <div class="group text-center p-8 rounded-2xl bg-gradient-to-br from-neutral-50 to-white border border-neutral-200 hover:border-primary-200 hover:shadow-soft transition-all duration-300">
                    <div class="w-14 h-14 bg-gradient-to-br from-primary-500 to-primary-600 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg shadow-primary-500/20 group-hover:scale-110 transition-all duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-neutral-950 mb-3">سریع و آسان</h3>
                    <p class="text-neutral-500 leading-relaxed text-sm">ثبت و مدیریت ملک در کمتر از چند دقیقه با رابط کاربری ساده و کاربردی ما.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding bg-gradient-to-br from-primary-700 via-primary-800 to-primary-900 text-white relative overflow-hidden">
        <div class="absolute inset-0 opacity-[0.04]" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 24px 24px;"></div>
        <div class="relative container-wide text-center">
            <h2 class="text-2xl md:text-3xl font-extrabold mb-4">آماده‌اید ملک بعدی خود را پیدا کنید؟</h2>
            <p class="text-primary-200/70 mb-8 max-w-lg mx-auto">همین الان شروع به جستجو کنید یا ملک خود را ثبت نمایید.</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('properties.index') }}" class="bg-white text-primary-700 px-8 py-3.5 rounded-xl font-bold text-sm hover:bg-primary-50 transition-all duration-200 shadow-lg">
                    جستجوی املاک
                </a>
                @guest
                    <a href="{{ route('register') }}" class="bg-white/10 backdrop-blur-sm text-white border border-white/20 px-8 py-3.5 rounded-xl font-bold text-sm hover:bg-white/20 transition-all duration-200">
                        ثبت نام رایگان
                    </a>
                @endguest
            </div>
        </div>
    </section>
</x-app-layout>
