<?php

namespace App\Http\Requests;

use App\Rules\ValidYearBuilt;
use Illuminate\Foundation\Http\FormRequest;

class StorePropertyRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'listing_type' => 'required|string|in:sale,rental',
            'description' => 'nullable|string|max:1024',

            'area_total' => 'nullable|numeric|min:0',
            'area_useful' => 'nullable|numeric|min:0',
            'land_length' => 'nullable|numeric|min:0',
            'land_width' => 'nullable|numeric|min:0',
            'land_area' => 'nullable|numeric|min:0',
            'year_built' => ['nullable', 'integer', new ValidYearBuilt],
            'orientation' => 'nullable|string|in:north,south,east,west',

            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'floor' => 'nullable|integer',
            'total_floors' => 'nullable|integer|min:0',
            'units_count' => 'nullable|integer|min:0',

            'has_parking' => 'boolean',
            'parking_count' => 'nullable|integer|min:0',
            'has_elevator' => 'boolean',
            'has_storage' => 'boolean',
            'has_balcony' => 'boolean',
            'has_garden' => 'boolean',

            'price' => 'nullable|integer|min:0',
            'deposit_amount' => 'nullable|integer|min:0',
            'rent_amount' => 'nullable|integer|min:0',
            'is_sold' => 'boolean',
            'address_fa' => 'nullable|string|max:500',

            'status_id' => 'nullable|integer|exists:property_statuses,id',
            'type_id' => 'nullable|integer|exists:property_types,id',
            'location_id' => 'nullable|integer|exists:locations,id',
            'owner_id' => 'nullable|integer|exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'عنوان ملک الزامی است.',
            'title.max' => 'عنوان نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',
            'listing_type.required' => 'نوع آگهی الزامی است.',
            'listing_type.in' => 'نوع آگهی معتبر نیست.',
            'area_total.numeric' => 'متراژ باید عدد باشد.',
            'area_useful.numeric' => 'متراژ مفید باید عدد باشد.',
            'price.integer' => 'قیمت باید عدد باشد.',
            'deposit_amount.integer' => 'مبلغ رهن باید عدد باشد.',
            'rent_amount.integer' => 'مبلغ اجاره باید عدد باشد.',
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
