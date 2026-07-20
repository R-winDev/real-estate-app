<x-app-layout>
        <!-- Hero Section -->
        <section class="relative bg-gradient-to-br from-brand-700 via-brand-800 to-surface-900 text-white overflow-hidden">
            <!-- Animated background blobs -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute -top-20 -right-20 w-96 h-96 bg-brand-400/15 rounded-full blur-3xl animate-float"></div>
                <div class="absolute -bottom-32 -left-32 w-80 h-80 bg-brand-300/10 rounded-full blur-3xl animate-float-slow"></div>
                <div class="absolute top-1/2 right-1/3 w-64 h-64 bg-brand-500/10 rounded-full blur-3xl animate-float-slower"></div>
                <!-- Grid pattern -->
                <div class="absolute inset-0 opacity-[0.04]" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 40px 40px;"></div>
            </div>

            <div class="relative container-wide section-padding">
                <div class="max-w-3xl">
                    <div class="inline-flex items-center gap-2.5 bg-white/10 backdrop-blur-sm rounded-full px-4 py-2 mb-8 border border-white/10">
                        <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse-soft"></span>
                        <span class="text-sm font-medium text-brand-100">بیش از {{ number_format($stats['total_properties']) }} ملک فعال</span>
                    </div>

                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold mb-6 leading-tight tracking-tight">
                        خانه رویاهایت را
                        <span class="text-brand-300">پیدا کن</span>
                    </h1>

                    <p class="text-lg md:text-xl text-brand-100/80 mb-10 leading-relaxed max-w-2xl">
                        با جستجوی پیشرفته در میان صدها ملک، بهترین گزینه را برای خود و خانواده‌ات پیدا کن.
                        خرید، فروش و اجاره ملک با اطمینان خاطر.
                    </p>

                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('properties.index') }}" class="inline-flex items-center gap-2.5 bg-white text-brand-800 px-8 py-4 rounded-2xl font-bold text-base hover:bg-brand-50 transition-all duration-300 shadow-xl hover:shadow-2xl hover:-translate-y-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            مشاهده املاک
                        </a>
                        @admin
                            <a href="{{ route('properties.create') }}" class="inline-flex items-center gap-2.5 bg-white/10 backdrop-blur-sm text-white border border-white/20 px-8 py-4 rounded-2xl font-bold text-base hover:bg-white/20 transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                ثبت ملک جدید
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="inline-flex items-center gap-2.5 bg-white/10 backdrop-blur-sm text-white border border-white/20 px-8 py-4 rounded-2xl font-bold text-base hover:bg-white/20 transition-all duration-300">
                                شروع رایگان
                            </a>
                        @endadmin
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="section-padding bg-white">
            <div class="container-wide">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
                    <div class="card-glass p-6 text-center hover:shadow-glow transition-all duration-300 group">
                        <div class="text-3xl md:text-4xl font-extrabold text-brand-700 mb-2 group-hover:scale-105 transition-transform duration-300">{{ number_format($stats['total_properties']) }}</div>
                        <div class="text-sm font-medium text-surface-500">ملک ثبت شده</div>
                    </div>
                    <div class="card-glass p-6 text-center hover:shadow-glow transition-all duration-300 group">
                        <div class="text-3xl md:text-4xl font-extrabold text-brand-700 mb-2 group-hover:scale-105 transition-transform duration-300">{{ number_format($stats['total_locations']) }}</div>
                        <div class="text-sm font-medium text-surface-500">موقعیت</div>
                    </div>
                    <div class="card-glass p-6 text-center hover:shadow-glow transition-all duration-300 group">
                        <div class="text-3xl md:text-4xl font-extrabold text-brand-700 mb-2 group-hover:scale-105 transition-transform duration-300">{{ number_format($stats['total_types']) }}</div>
                        <div class="text-sm font-medium text-surface-500">نوع ملک</div>
                    </div>
                    <div class="card-glass p-6 text-center hover:shadow-glow transition-all duration-300 group">
                        <div class="text-3xl md:text-4xl font-extrabold text-brand-700 mb-2 group-hover:scale-105 transition-transform duration-300">{{ number_format($stats['total_users']) }}</div>
                        <div class="text-sm font-medium text-surface-500">کاربر</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Properties Section -->
        @if($featuredProperties->count())
        <section class="section-padding bg-surface-50">
            <div class="container-wide">
                <div class="flex justify-between items-center mb-10">
                    <div>
                        <h2 class="text-2xl md:text-3xl font-extrabold text-surface-900">آخرین املاک</h2>
                        <p class="text-surface-500 mt-2">جدیدترین املاک ثبت شده در سامانه</p>
                    </div>
                    <a href="{{ route('properties.index') }}" class="btn-secondary btn-sm">
                        مشاهده همه
                        <svg class="w-4 h-4 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($featuredProperties as $property)
                        <x-property-card :property="$property"/>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- Features Section -->
        <section class="section-padding bg-white">
            <div class="container-wide">
                <div class="text-center mb-14">
                    <h2 class="text-2xl md:text-3xl font-extrabold text-surface-900">چرا ما؟</h2>
                    <p class="text-surface-500 mt-3">امکانات ویژه برای تجربه بهتر خرید و فروش ملک</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="group text-center p-8 rounded-3xl bg-gradient-to-br from-surface-50 to-white border border-surface-100 hover:border-brand-200 hover:shadow-glow transition-all duration-300">
                        <div class="w-16 h-16 bg-gradient-to-br from-brand-500 to-brand-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-brand-500/25 group-hover:scale-110 group-hover:shadow-xl transition-all duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-surface-900 mb-3">جستجوی پیشرفته</h3>
                        <p class="text-surface-500 leading-relaxed">با فیلترهای پیشرفته بر اساس موقعیت، قیمت، متراژ و امکانات، ملک دلخواه خود را سریع پیدا کنید.</p>
                    </div>

                    <div class="group text-center p-8 rounded-3xl bg-gradient-to-br from-surface-50 to-white border border-surface-100 hover:border-brand-200 hover:shadow-glow transition-all duration-300">
                        <div class="w-16 h-16 bg-gradient-to-br from-brand-500 to-brand-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-brand-500/25 group-hover:scale-110 group-hover:shadow-xl transition-all duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-surface-900 mb-3">اطلاعات معتبر</h3>
                        <p class="text-surface-500 leading-relaxed">تمامی اطلاعات املاک توسط کارشناسان ما تایید شده و با اطمینان خاطر می‌توانید تصمیم بگیرید.</p>
                    </div>

                    <div class="group text-center p-8 rounded-3xl bg-gradient-to-br from-surface-50 to-white border border-surface-100 hover:border-brand-200 hover:shadow-glow transition-all duration-300">
                        <div class="w-16 h-16 bg-gradient-to-br from-brand-500 to-brand-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-brand-500/25 group-hover:scale-110 group-hover:shadow-xl transition-all duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-surface-900 mb-3">سریع و آسان</h3>
                        <p class="text-surface-500 leading-relaxed">ثبت و مدیریت ملک در کمتر از چند دقیقه با رابط کاربری ساده و کاربردی ما.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-surface-900 text-surface-300 py-16">
            <div class="container-wide">
                <div class="flex flex-col md:flex-row justify-between items-center gap-8">
                    <div class="flex items-center gap-3">
                        <x-application-logo class="h-7 w-auto text-brand-400" />
                        <span class="text-lg font-bold text-white">املاک</span>
                    </div>
                    <p class="text-surface-500 text-sm">تمامی حقوق این وب‌سایت متعلق به املاک است.</p>
                </div>
            </div>
    </footer>
</x-app-layout>
