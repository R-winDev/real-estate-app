<div class="max-w-sm mx-auto">
    <label for="{{ $name }}" class="block mb-2.5 text-sm font-medium text-heading">{{ $label }}</label>
    <textarea id="{{ $name }}" name="{{ $name }}" rows="4" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full p-3.5 shadow-xs placeholder:text-body" placeholder="{{ $label }}">{{ old($name, $value) }}</textarea>
</div>
