<div class="mb-5">
    <label for="{{ $name }}" class="block mb-2.5 text-sm font-medium text-heading">{{ $label }}</label>
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" placeholder="Enter your {{ $label }}" value="{{old($name, $value)}}" required />
</div>
