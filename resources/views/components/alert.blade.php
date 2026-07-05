@switch($type)
    @case('info')
        <div dir="rtl" class="p-4 mb-4 text-sm text-blue-800 border border-blue-300 rounded-lg bg-blue-50" role="alert">
            <span class="font-medium">اطلاعیه</span> {{ $slot }}
        </div>
        @break

    @case('danger')
        <div dir="rtl" class="p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50" role="alert">
            <span class="font-medium">خطا</span> {{ $slot }}
        </div>
        @break

    @case('success')
        <div dir="rtl" class="p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50" role="alert">
            <span class="font-medium">موفق</span> {{ $slot }}
        </div>
        @break

    @case('warning')
        <div dir="rtl" class="p-4 mb-4 text-sm text-yellow-800 border border-yellow-300 rounded-lg bg-yellow-50" role="alert">
            <span class="font-medium">اخطار</span> {{ $slot }}
        </div>
        @break

    @default
        <div dir="rtl" class="p-4 text-sm text-gray-800 border border-gray-300 rounded-lg bg-gray-50" role="alert">
            <span class="font-medium">پیام</span> {{ $slot }}
        </div>
@endswitch
