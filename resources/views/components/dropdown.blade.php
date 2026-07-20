@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'py-1.5 bg-white'])

@php
    $widthClass = match ($width) {
        '48' => 'w-52',
        '56' => 'w-56',
        default => $width,
    };
@endphp

<div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
    <div @click="open = ! open">
        {{ $trigger }}
    </div>

    <div x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95 translate-y-1"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-1"
            class="absolute z-50 mt-2.5 {{ $widthClass }} rounded-xl shadow-elevated-lg ring-1 ring-neutral-200/60 {{ $align === 'right' ? 'start-0 ltr:origin-top-left rtl:origin-top-right' : ($align === 'left' ? 'end-0 ltr:origin-top-right rtl:origin-top-left' : 'origin-top start-1/2 -translate-x-1/2') }}"
            @click="open = false">
        <div class="{{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>
