<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInquiryRequest;
use App\Models\Property;
use App\Models\PropertyInquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class PropertyInquiryController extends Controller
{
    public function store(StoreInquiryRequest $request, Property $property)
    {
        // Rate limit: max 3 inquiries per IP per hour
        $ip = $request->ip();
        if (RateLimiter::tooManyAttempts('inquiry:' . $ip, 3)) {
            $seconds = RateLimiter::availableIn('inquiry:' . $ip);
            return back()->with('error', "تعداد درخواست‌ها بیش از حد مجاز است. لطفاً {$seconds} ثانیه صبر کنید.");
        }

        RateLimiter::hit('inquiry:' . $ip, 3600);

        // Duplicate check: same email/phone + same property within 24 hours
        $query = PropertyInquiry::where('property_id', $property->id);

        if (auth()->check()) {
            $query->where('customer_id', auth()->id());
        } else {
            $email = $request->input('customer_email');
            $phone = $request->input('customer_phone');
            $query->where(function ($q) use ($email, $phone) {
                if ($email) {
                    $q->orWhere('customer_email', $email);
                }
                if ($phone) {
                    $q->orWhere('customer_phone', $phone);
                }
            });
        }

        $recentDuplicate = $query->where('created_at', '>=', now()->subHours(24))->exists();

        if ($recentDuplicate) {
            return back()->with('error', 'شما قبلاً درخواست بازدید برای این ملک ثبت کرده‌اید. لطفاً ۲۴ ساعت صبر کنید.');
        }

        PropertyInquiry::create([
            'property_id' => $property->id,
            'customer_id' => auth()->id(),
            'customer_name' => auth()->check() ? auth()->user()->name : $request->input('customer_name'),
            'customer_phone' => $request->input('customer_phone'),
            'customer_email' => auth()->check() ? auth()->user()->email : $request->input('customer_email'),
            'inquiry_type' => $request->input('inquiry_type'),
            'preferred_date' => $request->input('preferred_date'),
            'preferred_time' => $request->input('preferred_time'),
            'message' => $request->input('message'),
            'status' => 'pending',
        ]);

        return back()->with('success', 'درخواست شما با موفقیت ثبت شد. به زودی با شما تماس خواهیم گرفت.');
    }
}
