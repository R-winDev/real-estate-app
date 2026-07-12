<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;
use Hekmatinasser\Verta\Verta;

class ValidYearBuilt implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_numeric($value)) {
            $fail('سال ساخت باید یک عدد باشد.');
            return;
        }

        if ($value > Verta::now()->year) {
            $fail('سال ساخت نمی‌تواند در آینده باشد.');
            return;
        }

        if ($value < 1300) {
            $fail('سال ساخت نمی‌تواند کمتر از ۱۳۰۰ باشد.');
        }
    }
}
