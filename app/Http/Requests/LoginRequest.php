<?php

namespace App\Http\Requests;

use App\Traits\Requests\Authorize;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 'required|email:rfc,dns|exists:users,email',
            'password' => 'required|alpha_num|min:8',
        ];
    }
}
