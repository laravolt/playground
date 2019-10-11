<?php

namespace App\Http\Requests\ContactForm;

use App\Rules\MinimumWords;
use App\Rules\ValidEmail;
use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', new MinimumWords(2)],
            'email' => ['required', 'email', new ValidEmail()],
            'message' => ['required', 'min:20'],
        ];
    }
}
