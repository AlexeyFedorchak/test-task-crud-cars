<?php

namespace App\Http\Requests;

use App\Traits\Requests\Authorize;
use Illuminate\Foundation\Http\FormRequest;

class CreateCarModelRequest extends FormRequest
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
            'name' => 'required|alpha|min:3|max:255|unique:car_models,name',
            'brand_id' => 'required|integer|exists:car_brands,id',
        ];
    }
}
