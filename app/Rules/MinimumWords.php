<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MinimumWords implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    protected $limit;

    public function __construct($limit = 3)
    {
        $this->limit = $limit;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return str_world_count($value) >= $this->limit;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute harus mengandung {$this->limit} suku kata atau lebih';
    }
}
