<x-app-layout>
    <div class="py-6">
        <div class="container-wide">

            <div class="mb-5 flex items-center gap-2 text-sm">
                <a href="{{ route('home') }}" class="text-neutral-400 hover:text-neutral-600 transition-colors">خانه</a>
                <svg class="w-3 h-3 text-neutral-300 icon-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('properties.index') }}" class="text-neutral-400 hover:text-neutral-600 transition-colors">املاک</a>
                <svg class="w-3 h-3 text-neutral-300 icon-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-neutral-600 truncate">{{ $property->title }}</span>
            </div>

            @admin
                <div class="flex items-center gap-2 mb-4">
                    <a href="{{ route('properties.edit', $property) }}" class="btn-secondary btn-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        ویرایش
                    </a>
                    <form method="POST" action="{{ route('properties.destroy', $property) }}"
                          onsubmit="return confirm('آیا از حذف این ملک اطمینان دارید؟')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger btn-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            حذف
                        </button>
                    </form>
                </div>
            @endadmin

            <div class="mb-6" x-data="imageGallery()">
                @if($property->images->count())
                    <div class="relative rounded-2xl overflow-hidden bg-neutral-100 aspect-[16/9] mb-3">
                        <img :src="images[currentIndex]?.url || images[0]?.url"
                             :alt="images[currentIndex]?.caption || '{{ $property->title }}'"
                             class="w-full h-full object-cover transition-opacity duration-300"
                             x-ref="mainImage">

                        @if($property->images->count() > 1)
                            <button @click="prev()" class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/80 backdrop-blur-sm rounded-full flex items-center justify-center shadow-lg hover:bg-white transition-all duration-200">
                                <svg class="w-5 h-5 text-neutral-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </button>
                            <button @click="next()" class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/80 backdrop-blur-sm rounded-full flex items-center justify-center shadow-lg hover:bg-white transition-all duration-200">
                                <svg class="w-5 h-5 text-neutral-700 icon-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </button>

                            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 px-3 py-1.5 bg-neutral-900/60 backdrop-blur-sm text-white text-xs rounded-full font-medium">
                                <span x-text="currentIndex + 1"></span> / <span x-text="images.length"></span>
                            </div>
                        @endif

                        @if($property->status)
                            <span class="absolute top-4 right-4 px-3 py-1.5 rounded-lg text-xs font-bold backdrop-blur-md
                                {{ $property->status->slug === 'active' ? 'bg-success-500/90 text-white' : ($property->status->slug === 'sold' ? 'bg-warning-500/90 text-white' : 'bg-neutral-600/90 text-white') }}">
                                {{ $property->status->name_fa }}
                            </span>
                        @endif
                    </div>

                    @if($property->images->count() > 1)
                        <div class="flex gap-2 overflow-x-auto pb-1">
                            @foreach($property->images->sortBy('sort_order') as $index => $image)
                                <button @click="currentIndex = {{ $index }}"
                                        :class="currentIndex === {{ $index }} ? 'ring-2 ring-primary-500 ring-offset-2' : 'opacity-60 hover:opacity-100'"
                                        class="w-16 h-16 rounded-lg overflow-hidden shrink-0 transition-all duration-200">
                                    <img src="{{ $image->url }}" alt="{{ $image->caption }}" class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif

                    <script>
                        function imageGallery() {
                            return {
                                currentIndex: 0,
                                images: @json($property->images->sortBy('sort_order')->values()),
                                next() {
                                    this.currentIndex = (this.currentIndex + 1) % this.images.length;
                                },
                                prev() {
                                    this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
                                }
                            }
                        }
                    </script>
                @else
                    <div class="rounded-2xl overflow-hidden bg-neutral-100 aspect-[16/9]">
                        <img src="https://placehold.co/1200x675/e2e8f0/94a3b8?text={{ urlencode('تصویر ملک') }}" alt="{{ $property->title }}" class="w-full h-full object-cover">
                    </div>
                @endif
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-5">
                    <div class="card p-6">
                        <div class="flex flex-wrap justify-between items-start gap-3 mb-3">
                            <h1 class="text-2xl font-extrabold text-neutral-950">{{ $property->title }}</h1>
                            @if($property->type)
                                <span class="px-3 py-1 bg-primary-50 text-primary-700 rounded-lg text-sm font-medium border border-primary-100">
                                    {{ $property->type->name_fa }}
                                </span>
                            @endif
                        </div>

                        @if($property->location)
                            <div class="flex items-center gap-2 text-sm text-neutral-500 mb-4">
                                <svg class="w-4 h-4 text-accent-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ $property->location->name }}
                            </div>
                        @endif

                        @if($property->listing_type === 'rental')
                            <div class="bg-gradient-to-l from-accent-50 to-accent-100/30 rounded-xl p-5 border border-accent-100 space-y-3">
                                <div class="flex items-center gap-3">
                                    <div class="flex-1">
                                        <div class="text-sm text-accent-600 mb-1">مبلغ رهن</div>
                                        <div class="text-2xl font-extrabold text-accent-700">{{ number_format($property->deposit_amount ?? 0) }} <span class="text-sm font-bold">تومان</span></div>
                                    </div>
                                    <div class="w-px h-12 bg-accent-200"></div>
                                    <div class="flex-1">
                                        <div class="text-sm text-primary-600 mb-1">اجاره ماهانه</div>
                                        <div class="text-2xl font-extrabold text-primary-700">{{ number_format($property->rent_amount ?? 0) }} <span class="text-sm font-bold">تومان</span></div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="bg-gradient-to-l from-primary-50 to-primary-100/30 rounded-xl p-5 border border-primary-100">
                                <div class="text-sm text-primary-600 mb-1">قیمت</div>
                                <div class="text-3xl font-extrabold text-primary-700">{{ number_format($property->price) }} <span class="text-lg font-bold">تومان</span></div>
                            </div>
                        @endif

                        @if($property->description)
                            <div class="mt-5">
                                <h3 class="font-bold text-neutral-950 mb-2 text-sm">توضیحات</h3>
                                <p class="text-neutral-600 leading-relaxed text-sm">{{ $property->description }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="card p-6">
                        <h3 class="font-bold text-neutral-950 mb-4 text-sm">مشخصات کلیدی</h3>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            @if($property->bedrooms)
                                <div class="text-center p-3 rounded-xl bg-neutral-50 hover:bg-primary-50 transition-colors duration-200">
                                    <svg class="w-5 h-5 text-neutral-400 mx-auto mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                    <div class="font-bold text-neutral-950 text-sm">{{ $property->bedrooms }}</div>
                                    <div class="text-[11px] text-neutral-500">خواب</div>
                                </div>
                            @endif
                            @if($property->bathrooms)
                                <div class="text-center p-3 rounded-xl bg-neutral-50 hover:bg-primary-50 transition-colors duration-200">
                                    <svg class="w-5 h-5 text-neutral-400 mx-auto mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <div class="font-bold text-neutral-950 text-sm">{{ $property->bathrooms }}</div>
                                    <div class="text-[11px] text-neutral-500">سرویس</div>
                                </div>
                            @endif
                            @if($property->area_total)
                                <div class="text-center p-3 rounded-xl bg-neutral-50 hover:bg-primary-50 transition-colors duration-200">
                                    <svg class="w-5 h-5 text-neutral-400 mx-auto mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                                    <div class="font-bold text-neutral-950 text-sm">{{ number_format($property->area_total) }}</div>
                                    <div class="text-[11px] text-neutral-500">متر مربع</div>
                                </div>
                            @endif
                            @if($property->floor)
                                <div class="text-center p-3 rounded-xl bg-neutral-50 hover:bg-primary-50 transition-colors duration-200">
                                    <svg class="w-5 h-5 text-neutral-400 mx-auto mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/></svg>
                                    <div class="font-bold text-neutral-950 text-sm">{{ $property->floor }}{{ $property->total_floors ? " از {$property->total_floors}" : '' }}</div>
                                    <div class="text-[11px] text-neutral-500">طبقه</div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card p-6">
                        <h3 class="font-bold text-neutral-950 mb-4 text-sm">مشخصات کامل</h3>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @if($property->area_useful)
                                <div class="p-3 rounded-xl bg-neutral-50 hover:bg-primary-50 transition-colors duration-200 border border-transparent hover:border-primary-100">
                                    <div class="text-[11px] text-neutral-500 mb-0.5">متراژ مفید</div>
                                    <div class="font-bold text-neutral-950 text-sm">{{ number_format($property->area_useful) }} متر مربع</div>
                                </div>
                            @endif
                            @if($property->year_built)
                                <div class="p-3 rounded-xl bg-neutral-50 hover:bg-primary-50 transition-colors duration-200 border border-transparent hover:border-primary-100">
                                    <div class="text-[11px] text-neutral-500 mb-0.5">سال ساخت</div>
                                    <div class="font-bold text-neutral-950 text-sm">{{ $property->year_built }}</div>
                                </div>
                            @endif
                            @if($property->parking_count)
                                <div class="p-3 rounded-xl bg-neutral-50 hover:bg-primary-50 transition-colors duration-200 border border-transparent hover:border-primary-100">
                                    <div class="text-[11px] text-neutral-500 mb-0.5">پارکینگ</div>
                                    <div class="font-bold text-neutral-950 text-sm">{{ $property->parking_count }} عدد</div>
                                </div>
                            @endif
                            @if($property->orientation)
                                <div class="p-3 rounded-xl bg-neutral-50 hover:bg-primary-50 transition-colors duration-200 border border-transparent hover:border-primary-100">
                                    <div class="text-[11px] text-neutral-500 mb-0.5">جهت ملک</div>
                                    <div class="font-bold text-neutral-950 text-sm">{{ $property->orientation }}</div>
                                </div>
                            @endif
                            @if($property->land_area)
                                <div class="p-3 rounded-xl bg-neutral-50 hover:bg-primary-50 transition-colors duration-200 border border-transparent hover:border-primary-100">
                                    <div class="text-[11px] text-neutral-500 mb-0.5">مساحت زمین</div>
                                    <div class="font-bold text-neutral-950 text-sm">{{ number_format($property->land_area) }} متر مربع</div>
                                </div>
                            @endif
                            @if($property->total_floors)
                                <div class="p-3 rounded-xl bg-neutral-50 hover:bg-primary-50 transition-colors duration-200 border border-transparent hover:border-primary-100">
                                    <div class="text-[11px] text-neutral-500 mb-0.5">کل طبقات</div>
                                    <div class="font-bold text-neutral-950 text-sm">{{ $property->total_floors }} طبقه</div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card p-6">
                        <h3 class="font-bold text-neutral-950 mb-4 text-sm">امکانات</h3>
                        <div class="flex flex-wrap gap-2">
                            @if($property->has_parking)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-success-50 text-success-700 rounded-lg text-xs font-medium border border-success-100">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    پارکینگ
                                </span>
                            @endif
                            @if($property->has_elevator)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-success-50 text-success-700 rounded-lg text-xs font-medium border border-success-100">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    آسانسور
                                </span>
                            @endif
                            @if($property->has_storage)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-success-50 text-success-700 rounded-lg text-xs font-medium border border-success-100">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    انباری
                                </span>
                            @endif
                            @if($property->has_balcony)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-success-50 text-success-700 rounded-lg text-xs font-medium border border-success-100">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    بالکن
                                </span>
                            @endif
                            @if($property->has_garden)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-success-50 text-success-700 rounded-lg text-xs font-medium border border-success-100">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    فضای سبز
                                </span>
                            @endif

                            @unless($property->has_parking || $property->has_elevator || $property->has_storage || $property->has_balcony || $property->has_garden)
                                <p class="text-neutral-500 text-sm">امکاناتی ثبت نشده است.</p>
                            @endunless
                        </div>
                    </div>

                    @if($property->features->count())
                        <div class="card p-6">
                            <h3 class="font-bold text-neutral-950 mb-4 text-sm">ویژگی‌ها</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($property->features as $feature)
                                    <span class="px-3 py-1.5 bg-accent-50 text-accent-700 rounded-lg text-xs font-medium border border-accent-100">
                                        {{ $feature->name_fa }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <div class="space-y-5">
                    @if($property->location)
                        <div class="card p-5">
                            <h3 class="font-bold text-neutral-950 mb-3 text-sm">موقعیت</h3>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-primary-50 rounded-xl flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <div class="font-bold text-neutral-950 text-sm">{{ $property->location->name }}</div>
                            </div>
                        </div>
                    @endif

                    @if($property->address_fa)
                        <div class="card p-5">
                            <h3 class="font-bold text-neutral-950 mb-3 text-sm">آدرس</h3>
                            <p class="text-neutral-600 leading-relaxed text-sm">{{ $property->address_fa }}</p>
                        </div>
                    @endif

                    @admin
                        @if($property->owner)
                            <div class="card p-5">
                                <h3 class="font-bold text-neutral-950 mb-3 text-sm">مالک</h3>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    </div>
                                    <div>
                                        <div class="font-bold text-neutral-950 text-sm">{{ $property->owner->name }}</div>
                                        <div class="text-xs text-neutral-500">{{ $property->owner->email }}</div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endadmin

                    <div class="card p-5" x-data="{ showForm: false }">
                        <button @click="showForm = !showForm" class="w-full flex items-center justify-between mb-0">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 bg-accent-50 rounded-lg flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <h3 class="font-bold text-neutral-950 text-sm">درخواست بازدید</h3>
                            </div>
                            <svg class="w-4 h-4 text-neutral-400 transition-transform duration-200" :class="showForm ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>

                        <div x-show="showForm" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="mt-4">
                            <form method="POST" action="{{ route('properties.inquiries.store', $property) }}" class="space-y-3">
                                @csrf

                                <div style="position: absolute; left: -9999px; opacity: 0;" tabindex="-1" aria-hidden="true">
                                    <label for="_hp">لطفاً خالی بگذارید</label>
                                    <input type="text" name="_hp" id="_hp" tabindex="-1" autocomplete="off">
                                </div>

                                @guest
                                    <div>
                                        <label for="customer_name" class="block mb-1 text-xs font-semibold text-neutral-700">نام و نام خانوادگی</label>
                                        <input type="text" name="customer_name" id="customer_name"
                                               class="form-input py-2.5 text-xs" placeholder="نام خود را وارد کنید"
                                               value="{{ old('customer_name') }}" required>
                                        @error('customer_name')
                                            <p class="mt-1 text-xs text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="customer_email" class="block mb-1 text-xs font-semibold text-neutral-700">ایمیل (اختیاری)</label>
                                        <input type="email" name="customer_email" id="customer_email"
                                               class="form-input py-2.5 text-xs" placeholder="example@email.com"
                                               value="{{ old('customer_email') }}">
                                        @error('customer_email')
                                            <p class="mt-1 text-xs text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @endguest

                                @auth
                                    <input type="hidden" name="customer_name" value="{{ Auth::user()->name }}">
                                    <input type="hidden" name="customer_email" value="{{ Auth::user()->email }}">
                                @endauth

                                <div>
                                    <label for="customer_phone" class="block mb-1 text-xs font-semibold text-neutral-700">شماره تماس</label>
                                    <input type="text" name="customer_phone" id="customer_phone"
                                           class="form-input py-2.5 text-xs" placeholder="۰۹۱۲۱۲۳۴۵۶۷"
                                           value="{{ old('customer_phone') }}" required>
                                    @error('customer_phone')
                                        <p class="mt-1 text-xs text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="inquiry_type" class="block mb-1 text-xs font-semibold text-neutral-700">نوع درخواست</label>
                                    <select name="inquiry_type" id="inquiry_type" class="form-select py-2.5 text-xs">
                                        <option value="visit_request" @selected(old('inquiry_type') === 'visit_request')>درخواست بازدید</option>
                                        <option value="price_inquiry" @selected(old('inquiry_type') === 'price_inquiry')>استعلام قیمت</option>
                                        <option value="general" @selected(old('inquiry_type') === 'general')>سوال عمومی</option>
                                    </select>
                                    @error('inquiry_type')
                                        <p class="mt-1 text-xs text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <label for="preferred_date" class="block mb-1 text-xs font-semibold text-neutral-700">تاریخ</label>
                                        <input type="date" name="preferred_date" id="preferred_date"
                                               class="form-input py-2.5 text-xs" value="{{ old('preferred_date') }}" required>
                                        @error('preferred_date')
                                            <p class="mt-1 text-xs text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="preferred_time" class="block mb-1 text-xs font-semibold text-neutral-700">ساعت</label>
                                        <input type="time" name="preferred_time" id="preferred_time"
                                               class="form-input py-2.5 text-xs" value="{{ old('preferred_time') }}" required>
                                        @error('preferred_time')
                                            <p class="mt-1 text-xs text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <label for="message" class="block mb-1 text-xs font-semibold text-neutral-700">پیام (اختیاری)</label>
                                    <textarea name="message" id="message" rows="3"
                                              class="form-textarea py-2.5 text-xs" placeholder="توضیحات اضافی...">{{ old('message') }}</textarea>
                                </div>

                                <button type="submit" class="btn-primary w-full py-2.5 text-xs">
                                    ثبت درخواست
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @if($similarProperties->count())
                <div class="mt-12">
                    <div class="flex justify-between items-end mb-6">
                        <div>
                            <h2 class="text-xl font-extrabold text-neutral-950">املاک مشابه</h2>
                            <p class="text-neutral-500 text-sm mt-1">ملک‌هایی با ویژگی‌های مشابه</p>
                        </div>
                        <a href="{{ route('properties.index') }}" class="text-sm text-accent-600 hover:text-accent-700 font-semibold flex items-center gap-1">
                            مشاهده همه
                            <svg class="w-3.5 h-3.5 icon-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        @foreach($similarProperties as $similar)
                            <x-property-card :property="$similar"/>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
