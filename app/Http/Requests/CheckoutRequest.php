<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'telephone' => 'required',
            'email' => 'required|email',
            //
            'city' => 'required',
            'address' => 'required',
            'country' => 'required',
            'postcode' => 'required|min:3',

            //
            'payment' => 'required',
            'shipment' => 'required'
        ];



        return $rules;
    }
}
