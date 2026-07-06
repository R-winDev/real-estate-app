<label for="{{ $name }}" class="block mb-2.5 text-sm font-medium text-heading">{{ $label }}</label>
<select id="{{ $name }}" name="{{ $name }}" class="block w-full px-3 py-2.5 bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body">
    @foreach($options as $key => $value)
        <option value="{{ $key }}" @if($loop->first) selected @endif>{{ $value }}</option>
    @endforeach
</select>
