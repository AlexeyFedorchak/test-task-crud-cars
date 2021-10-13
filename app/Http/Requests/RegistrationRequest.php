<?php

namespace App\Http\Requests;

use App\Traits\Requests\Authorize;
use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{
    use Authorize;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|alpha|min:2',
            'email' => 'required|email',
            'password' => 'required|alpha_num|min:8',
        ];
    }
}
