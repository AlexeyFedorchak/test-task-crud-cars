<?php

namespace App\Http\Requests;

use App\Traits\Requests\Authorize;
use App\Traits\Requests\InjectUrlData;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCarModelRequest extends FormRequest
{
    use InjectUrlData, Authorize;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => 'required|numeric|exists:car_models,id',
            'name' => 'string|min:3|max:255|unique:car_models,name',
            'brand_id' => 'integer|exists:car_brands,id',
        ];
    }
}
