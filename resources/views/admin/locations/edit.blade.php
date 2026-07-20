<x-admin-layout title="ویرایش موقعیت">
    <div class="max-w-xl">
        <div class="bg-white rounded-2xl shadow-soft border border-surface-100 p-6">
            <form method="POST" action="{{ route('admin.locations.update', $location->id) }}" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-sm font-medium text-surface-700 mb-1">نام</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $location->name) }}" class="form-input" required>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="slug" class="block text-sm font-medium text-surface-700 mb-1">پیوند یکتا</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $location->slug) }}" class="form-input" dir="ltr">
                    @error('slug') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="parent_id" class="block text-sm font-medium text-surface-700 mb-1">والد</label>
                    <select name="parent_id" id="parent_id" class="form-select">
                        <option value="">بدون والد</option>
                        @foreach($parentLocations as $loc)
                            <option value="{{ $loc->id }}" {{ old('parent_id', $location->parent_id) == $loc->id ? 'selected' : '' }}>{{ $loc->name }}</option>
                        @endforeach
                    </select>
                    @error('parent_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="latitude" class="block text-sm font-medium text-surface-700 mb-1">عرض جغرافیایی</label>
                        <input type="number" step="any" name="latitude" id="latitude" value="{{ old('latitude', $location->latitude) }}" class="form-input" dir="ltr">
                        @error('latitude') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="longitude" class="block text-sm font-medium text-surface-700 mb-1">طول جغرافیایی</label>
                        <input type="number" step="any" name="longitude" id="longitude" value="{{ old('longitude', $location->longitude) }}" class="form-input" dir="ltr">
                        @error('longitude') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="btn-primary">بروزرسانی</button>
                    <a href="{{ route('admin.locations.index') }}" class="btn-ghost">انصراف</a>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
