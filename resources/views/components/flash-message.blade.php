@php
    $types = ['success', 'error', 'warning', 'info'];
    $showFlash = false;
    $flashType = null;
    $flashMessage = null;

    foreach ($types as $type) {
        if (session($type)) {
            $showFlash = true;
            $flashType = $type === 'error' ? 'danger' : $type;
            $flashMessage = session($type);
            break;
        }
    }
@endphp

@if($showFlash)
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4"
         x-data="{ show: true }"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         x-init="setTimeout(() => show = false, 5000)">
        <x-alert type="{{ $flashType }}">{{ $flashMessage }}</x-alert>
    </div>
@endif
