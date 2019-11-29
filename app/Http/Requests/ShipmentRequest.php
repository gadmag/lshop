<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShipmentRequest extends FormRequest
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
        $rules = [
            'title' => 'required|min:3',
            'name' => 'required|min:3',
            'status' => 'boolean',
            'price_setting.*.price' => 'regex:/^\d+(\.\d{1,2})?$/',
            'price_setting.*.weight' => 'regex:/^\d+(\.\d{1,2})?$/',
        ];


        return $rules;
    }
}
