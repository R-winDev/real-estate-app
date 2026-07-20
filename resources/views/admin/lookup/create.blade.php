<x-admin-layout :title="'افزودن ' . $config['label']">
    <div class="max-w-xl">
        <div class="bg-white rounded-2xl shadow-soft border border-surface-100 p-6">
            <form method="POST" action="{{ route('admin.lookup.store', $type) }}" class="space-y-5">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-surface-700 mb-1">نام انگلیسی</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-input" required>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="name_fa" class="block text-sm font-medium text-surface-700 mb-1">نام فارسی</label>
                    <input type="text" name="name_fa" id="name_fa" value="{{ old('name_fa') }}" class="form-input" required>
                    @error('name_fa') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="slug" class="block text-sm font-medium text-surface-700 mb-1">پیوند یکتا <span class="text-surface-400">(اختیاری)</span></label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug') }}" class="form-input" dir="ltr" placeholder="خودکار">
                    @error('slug') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                @if(in_array('category', $config['fields']))
                    <div>
                        <label for="category" class="block text-sm font-medium text-surface-700 mb-1">دسته‌بندی</label>
                        <input type="text" name="category" id="category" value="{{ old('category') }}" class="form-input">
                        @error('category') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                @endif

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="btn-primary">ذخیره</button>
                    <a href="{{ route('admin.lookup.index', $type) }}" class="btn-ghost">انصراف</a>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
