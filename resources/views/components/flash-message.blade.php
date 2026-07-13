@php
    $types = ['success', 'error', 'warning', 'info'];
@endphp

@foreach($types as $type)
    @if(session($type))
        @switch($type)
            @case('error')
                <x-alert type="danger">{{ session($type) }}</x-alert>
                @break
            @default
                <x-alert type="{{ $type }}">{{ session($type) }}</x-alert>
        @endswitch
    @endif
@endforeach
