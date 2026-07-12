<?php

namespace App\Http\Requests;

use App\Rules\ValidYearBuilt;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePropertyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string|max:1024',

            'area_total' => 'sometimes|nullable|numeric|min:0',
            'area_useful' => 'sometimes|nullable|numeric|min:0',
            'land_length' => 'sometimes|nullable|numeric|min:0',
            'land_width' => 'sometimes|nullable|numeric|min:0',
            'land_area' => 'sometimes|nullable|numeric|min:0',
            'year_built' => ['sometimes', 'nullable', 'integer', new ValidYearBuilt],
            'orientation' => 'sometimes|nullable|string|in:north,south,east,west',

            'bedrooms' => 'sometimes|nullable|integer|min:0',
            'bathrooms' => 'sometimes|nullable|integer|min:0',
            'floor' => 'sometimes|nullable|integer',
            'total_floors' => 'sometimes|nullable|integer|min:0',
            'units_count' => 'sometimes|nullable|integer|min:0',

            'has_parking' => 'sometimes|boolean',
            'parking_count' => 'sometimes|nullable|integer|min:0',
            'has_elevator' => 'sometimes|boolean',
            'has_storage' => 'sometimes|boolean',
            'has_balcony' => 'sometimes|boolean',
            'has_garden' => 'sometimes|boolean',

            'price' => 'sometimes|nullable|integer|min:0',
            'is_sold' => 'sometimes|boolean',
            'address_fa' => 'sometimes|nullable|string|max:500',

            'status_id' => 'sometimes|nullable|integer|exists:property_statuses,id',
            'type_id' => 'sometimes|nullable|integer|exists:property_types,id',
            'location_id' => 'sometimes|nullable|integer|exists:locations,id',
            'owner_id' => 'sometimes|nullable|integer|exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'عنوان ملک الزامی است.',
            'title.max' => 'عنوان نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',
            'area_total.numeric' => 'متراژ باید عدد باشد.',
            'area_useful.numeric' => 'متراژ مفید باید عدد باشد.',
            'price.integer' => 'قیمت باید عدد باشد.',
            'bedrooms.integer' => 'تعداد اتاق خواب باید عدد باشد.',
            'bathrooms.integer' => 'تعداد سرویس بهداشتی باید عدد باشد.',
            'status_id.exists' => 'وضعیت انتخاب شده معتبر نیست.',
            'type_id.exists' => 'نوع ملک انتخاب شده معتبر نیست.',
            'location_id.exists' => 'موقعیت انتخاب شده معتبر نیست.',
            'year_built.integer' => 'سال ساخت باید عدد باشد.',
            'has_parking.boolean' => 'مقدار پارکینگ معتبر نیست.',
            'has_elevator.boolean' => 'مقدار آسانسور معتبر نیست.',
        ];
    }
}
