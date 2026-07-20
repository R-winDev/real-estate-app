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
    <div class="fixed top-20 left-1/2 -translate-x-1/2 z-[100] w-full max-w-md px-4"
         x-data="{ show: true }"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 -translate-y-4 scale-95"
         x-init="setTimeout(() => show = false, 5000)">
        <div class="shadow-elevated-lg">
            <x-alert type="{{ $flashType }}">{{ $flashMessage }}</x-alert>
        </div>
    </div>
@endif
