<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'inquiry_type' => ['required', 'in:visit_request,price_inquiry,general'],
            'preferred_date' => ['required', 'date', 'after_or_equal:today'],
            'preferred_time' => ['required', 'date_format:H:i'],
            'message' => ['nullable', 'string', 'max:1000'],
            '_hp' => ['honeypot'],
        ];

        if (auth()->check()) {
            $rules['customer_phone'] = ['required', 'string', 'max:20'];
        } else {
            $rules['customer_name'] = ['required', 'string', 'max:100'];
            $rules['customer_phone'] = ['nullable', 'string', 'max:20'];
            $rules['customer_email'] = ['nullable', 'email', 'max:100'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'inquiry_type.required' => 'نوع درخواست را انتخاب کنید.',
            'inquiry_type.in' => 'نوع درخواست نامعتبر است.',
            'preferred_date.required' => 'تاریخ مورد نظر را وارد کنید.',
            'preferred_date.after_or_equal' => 'تاریخ مورد نظر باید از امروز به بعد باشد.',
            'preferred_time.required' => 'ساعت مورد نظر را وارد کنید.',
            'preferred_time.date_format' => 'فرمت ساعت نامعتبر است.',
            'customer_name.required' => 'نام خود را وارد کنید.',
            'customer_phone.required' => 'شماره تماس را وارد کنید.',
            'customer_email.email' => 'فرمت ایمیل نامعتبر است.',
        ];
    }
}
