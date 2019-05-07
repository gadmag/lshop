<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    const OPTION_ROWS = 8;

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
            'status' => 'boolean',
            'sku' => 'required',
            'productOptions' => 'required'
        ];

        if ($this->filled('productDiscount.price') || $this->filled('productDiscount.quantity')) {
            $rules += ['productDiscount.price' => 'required|numeric'];
            $rules += ['productDiscount.quantity' => 'required|numeric'];
        }

        if ($this->filled('productSpecial.price')) {
            $rules += ['productSpecial.price' => 'required|numeric'];
        }
        if ($this->filled('productOptions.*.color') || $this->filled('productOptions.*.color_stone')) {
            $rules += ["productOptions.*.price" => 'sometimes|required|numeric'];
            $rules += ["productOptions.*.quantity" => 'sometimes|required|numeric'];
        }

        return $rules;
    }

//    public function messages()
//    {
//        $messages = [];
//        if ($this->has('productOptions')) {
//            foreach ($this->extractOptions() as $key => $val) {
//                $messages['productOptions.' . $key . '.color.required'] = 'Поле опции: цвет обязательно для заполнения';
//                $messages['productOptions.' . $key . '.color_stone.required'] = 'Поле опции: цвет камня обязательно для заполнения';
//                $messages['productOptions.' . $key . '.price.required'] = 'Поле опции: цена обязательно для заполнения';
//                $messages['productOptions.' . $key . '.quantity.required'] = 'Поле опции: Кол-во обязательно для заполнения';
//            }
//        }
//        return $messages;
//    }

    public function extractOptions()
    {
        $productOptions = $this->productOptions;
        foreach ( $productOptions as $key => $option)
        {
            if (!empty($this->file('productOptions')) && in_array( $key, $this->file('productOptions'))){
                $productOptions[$key] = $this->file('productOptions')[$key];
            }
        }

        return $productOptions;
    }



}
