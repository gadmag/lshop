<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'quantity' => 'required',
            'status' => 'boolean',
            'sku' => 'required',
            'price' => 'required|numeric',
            'weight' => 'required|numeric'
        ];

        if ($this->has('productDiscount.price') || $this->has('productDiscount.quantity'))
        {
            $rules += ['productDiscount.price'=> 'required'];
            $rules += ['productDiscount.quantity'=> 'required'];
        }

        if ($this->has('productSpecial.price'))
        {
            $rules += ['productSpecial.price'=> 'required'];
        }

        if ($this->has('productOptions'))
        {
//            dd($this->request->get('productOptions'));
            foreach ($this->request->get('productOptions') as $key => $option)
            {
//                dd($option);
                if ($key < 7) continue;

                $rules += ["productOptions.$key.color" => 'sometimes|required'];
                $rules += ["productOptions.$key.price" => 'sometimes|required'];
                $rules += ["productOptions.$key.quantity" => 'sometimes|required'];
            }

        }

        return $rules;
    }

    public function messages()
    {
        $messages = [];
        foreach($this->request->get('productOptions') as $key => $val)
        {
            $messages['productOptions.'.$key.'.color.required'] = 'Поле опции: цвет обязательно для заполнения';
            $messages['productOptions.'.$key.'.price.required'] = 'Поле опции: цена обязательно для заполнения';
            $messages['productOptions.'.$key.'.quantity.required'] = 'Поле опции: Кол-во обязательно для заполнения';
        }
        return $messages;
    }

    public function extractOptions()
    {
        $productOptions = array_chunk($this->productOptions, 6);
        $massive = []; $output = [];
        foreach ($productOptions as $key => $item){
            foreach ($item as $field){
                $massive = array_merge($massive, $field);
            }
            $output[$key] = $massive;
        }
        unset($output[0]);
        return $output;
    }


}
