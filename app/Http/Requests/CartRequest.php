<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use function Deployer\option;

class CartRequest extends FormRequest
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
            'options' => 'required',
            'options.id' => 'sometimes|required|int',

        ];
//        if ($this->filled('options.engraving.id')) {
//            $rules += ['options.engraving.text' => 'required_if:options.engraving.filename,'];
//            $rules += ['options.engraving.filename' => 'required_if:options.engraving.text,'];
//        }
//        dd($this->input('options.engraving.isChecked'));
        if ($this->input('options.engraving.isChecked')) {
            $rules += ['options.engraving.id' => 'required'];
            $rules += ['options.engraving.font' => 'required'];
            $rules += ['options.engraving.text' => 'required_if:options.engraving.filename,'];
            $rules += ['options.engraving.filename' => 'required_if:options.engraving.text,'];
        }
        return $rules;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'options' =>  json_decode($this->options,true)
        ]);
    }

    public function getEngraving()
    {
        if (!$this->exists('options.engraving')) {
            return null;
        }
        $engraving = $this->input('options.engraving');
        return [
            'id' => $engraving['id'] ?? null,
            'text' => $engraving['text'] ?? null,
            'price' => $engraving['price'] ?? '',
            'font' => $engraving['font'] ?? '',
            'comment' => $engraving['comment'] ?? '',
            'qty' => $engraving['qty']?? 1,
            'filename' => $engraving['filename'] ?? '',
        ];
    }
}
