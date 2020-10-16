<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class ItemsRequest extends FormRequest
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
        return [
            'class_id' => 'required',
            'name' => 'required|max:30',
            'used_date' => 'required',
            'price' => 'required',
            'tax_id' => 'required'

        ];
    }

    public function messages()
    {
        return [
            'class_id.required' => trans('messages.class_idRequired'),
            'name.required' => trans('messages.nameItemsRequired'),
            'name.max' => trans('messages.nameItemsMax'),
            'used_date.required' => trans('messages.used_dateRequired'),
            'price.required' => trans('messages.used_dateRequired'),
            'tax_id.required' => trans('messages.tax_idRequired')
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        returnErrors($validator);
    }
}
