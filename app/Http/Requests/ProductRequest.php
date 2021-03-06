<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class  ProductRequest extends FormRequest
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
            'status' => 'boolean',
            'model' => 'required|unique:products,model,' . $this->product,
            'sort_order' => 'integer',
            'quantity' => 'integer',
            'weight' => 'number',
            'productOptions' => 'required|array',
            'productOptions.*.sku' => 'required|distinct',
            'productOptions.*.discount.price' => 'required_unless:productOptions.*.discount.quantity,',
            'productOptions.*.discount.quantity' => 'required_unless:productOptions.*.discount.price,',

        ];


        if ($this->filled('productSpecial.price')) {
            $rules += ['productSpecial.price' => 'required|numeric'];
        }

        if ($this->filled('productOptions.*.color') || $this->filled('productOptions.*.color_stone')) {
            $rules += ["productOptions.*.price" => 'sometimes|required|numeric'];
            $rules += ["productOptions.*.weight" => 'sometimes|required|numeric'];
            $rules += ["productOptions.*.quantity" => 'sometimes|required|integer'];
        }
        return $rules;
    }


    public function extractOptions()
    {
        $productOptions = $this->productOptions;
        foreach ($productOptions as $key => $option) {
            if (!empty($this->file('productOptions')) && in_array($key, $this->file('productOptions'))) {
                $productOptions[$key] = $this->file('productOptions')[$key];
            }
        }

        return $productOptions;
    }


}
