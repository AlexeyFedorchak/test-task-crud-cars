<?php

namespace App\Http\Requests;

use App\Traits\Requests\Authorize;
use Illuminate\Foundation\Http\FormRequest;

class SearchCarAPIRequest extends FormRequest
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
            'search' => 'required|min:3',
            'per_page' => 'numeric|integer|min:3|max:100',
        ];
    }
}
