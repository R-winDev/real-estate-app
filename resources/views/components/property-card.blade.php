<div class="bg-white rounded-lg shadow-sm overflow-hidden">
    <!-- عکس placeholder -->
    <div class="bg-gray-200 h-48 flex items-center justify-center">
        <span class="text-gray-400">تصویر</span>
    </div>

    <div class="p-4">
        <!-- عنوان -->
        <h3 class="font-semibold text-lg text-gray-900 mb-2 truncate">
            {{ $property->title }}
        </h3>

        <!-- لوکیشن -->
        <p class="text-sm text-gray-500 mb-2">
            📍 {{ $property->location?->name }}
        </p>

        <!-- جزئیات -->
        <div class="flex justify-between items-center text-sm text-gray-600 mb-3">
            <span>{{ $property->area_total }} متر²</span>
            <span class="px-2 py-1 bg-gray-100 rounded text-xs">
                {{ $property->status?->name }}
            </span>
        </div>

        <!-- قیمت -->
        <div class="text-lg font-bold text-blue-600">
            {{ number_format($property->price) }} تومان
        </div>
    </div>
</div>
