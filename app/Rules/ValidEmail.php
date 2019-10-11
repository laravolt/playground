<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class ValidEmail implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $data = false;

        $domains = ['go.id', 'ac.id', 'or.id'];
        foreach ($domains as $domain) {
            if (Str::endsWith($value, $domain)) {
                $data = true;
            }
        }

        return $data;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ":attribute hanya boleh diisi .go.id, .ac.id, atau .or.id";
    }
}
