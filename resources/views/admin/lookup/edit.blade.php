<x-admin-layout :title="'ویرایش ' . $config['label']">
    <div class="max-w-xl">
        {{-- Page Header --}}
        <div class="mb-6">
            <h2 class="text-xl font-bold text-neutral-800">ویرایش {{ $config['label'] }}</h2>
            <p class="text-sm text-neutral-500 mt-1">{{ $item->name_fa }} &mdash; {{ $item->name }}</p>
        </div>

        {{-- Form Card --}}
        <div class="rounded-xl border border-neutral-200 bg-white overflow-hidden">
            <form method="POST" action="{{ route('admin.lookup.update', [$type, $item->id]) }}">
                @csrf
                @method('PUT')

                {{-- Section: Basic Info --}}
                <div class="px-6 py-4 border-b border-neutral-100">
                    <h3 class="text-sm font-semibold text-neutral-700 flex items-center gap-2">
                        <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        اطلاعات پایه
                    </h3>
                </div>
                <div class="p-6 space-y-5">
                    <x-form-input name="name" :value="old('name', $item->name)" label="نام انگلیسی" required />

                    <x-form-input name="name_fa" :value="old('name_fa', $item->name_fa)" label="نام فارسی" required />

                    <x-form-input name="slug" :value="old('slug', $item->slug)" label="پیوند یکتا" dir="ltr" />

                    @if(in_array('category', $config['fields']))
                        <x-form-input name="category" :value="old('category', $item->category)" label="دسته‌بندی" />
                    @endif
                </div>

                {{-- Actions --}}
                <div class="px-6 py-4 border-t border-neutral-100 bg-neutral-50/50 flex items-center gap-3">
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        بروزرسانی
                    </button>
                    <a href="{{ route('admin.lookup.index', $type) }}" class="btn-secondary">انصراف</a>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
