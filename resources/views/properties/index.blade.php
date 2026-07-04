<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Properties') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($properties->isEmpty())
                        <p>No properties found.</p>
                    @else
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b">
                                    <th class="py-2">Title</th>
                                    <th class="py-2">Location</th>
                                    <th class="py-2">Type</th>
                                    <th class="py-2">Status</th>
                                    <th class="py-2">Area</th>
                                    <th class="py-2">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($properties as $property)
                                    <tr class="border-b">
                                        <td class="py-2">{{ $property->title }}</td>
                                        <td class="py-2">{{ $property->location?->name }}</td>
                                        <td class="py-2">{{ $property->type?->name }}</td>
                                        <td class="py-2">{{ $property->status?->name }}</td>
                                        <td class="py-2">{{ $property->area_total }} m²</td>
                                        <td class="py-2">{{ number_format($property->price) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
