@props(['name', 'label', 'options', 'selected' => null])

<div class="mb-5">
    <label for="{{ $name }}" class="block mb-1.5 text-sm font-medium text-surface-700">{{ $label }}</label>
    <select id="{{ $name }}" name="{{ $name }}" class="form-select">
        <option value="">انتخاب کنید...</option>
        @foreach($options as $key => $value)
            <option value="{{ $key }}" @selected(old($name, $selected) == $key)>{{ $value }}</option>
        @endforeach
    </select>
    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
