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
            'quantity' => 'required|numeric',
            'status' => 'boolean',
            'sku' => 'required',
            'price' => 'required|numeric',
            'weight' => 'required|numeric'
        ];

        if ($this->filled('productDiscount.price') || $this->filled('productDiscount.quantity'))
        {
            $rules += ['productDiscount.price'=> 'required|numeric'];
            $rules += ['productDiscount.quantity'=> 'required|numeric'];
        }

        if ($this->filled('productSpecial.price'))
        {
            $rules += ['productSpecial.price'=> 'required|numeric'];
        }

        if ($this->filled('productOptions.*.color'))
        {
            foreach ($this->request->get('productOptions') as $key => $option)
            {
                if ($key < ProductRequest::OPTION_ROWS) continue;

                $rules += ["productOptions.$key.color" => 'required'];
                $rules += ["productOptions.$key.type" => 'sometimes|required'];
                $rules += ["productOptions.$key.price" => 'sometimes|required|numeric'];
                $rules += ["productOptions.$key.quantity" => 'sometimes|required|numeric'];
            }

        }

        return $rules;
    }

    /*public function messages()
    {
        $messages = [];
        foreach($this->request->get('productOptions') as $key => $val)
        {
            $messages['productOptions.'.$key.'.color.required'] = 'Поле опции: цвет обязательно для заполнения';
            $messages['productOptions.'.$key.'.price.required'] = 'Поле опции: цена обязательно для заполнения';
            $messages['productOptions.'.$key.'.quantity.required'] = 'Поле опции: Кол-во обязательно для заполнения';
        }
        return $messages;
    }*/

    public function extractOptions()
    {
        $productOptions = self::array_flatten(array_chunk($this->productOptions, ProductRequest::OPTION_ROWS), $this->file('image_option'));
//        unset($productOptions[0]);
//        unset($productOptions[1]);
        return $productOptions;
    }

    static function array_flatten($array, $image_option)
    {

        $massive = []; $output = [];
        foreach ($array as $key => $item){
            foreach ($item as $field){
                $massive = array_merge($massive, $field);
            }
            $output[$key] = $massive;
            if ($image_option){
                $output[$key]['image_option'] = array_key_exists($key, $image_option)? $image_option[$key]: null;
            } else{
                $output[$key]['image_option'] = null;
            }
        }
        return $output;
    }

}
