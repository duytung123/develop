<?php

namespace App\Http\Requests;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class DiscountRequest extends FormRequest
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
            'shop_id' => 'required|max:20',
            'name' => 'required|max:10',
            'discount_cd' => 'required|max:2',
            'discount_type' => 'required|max:1',
            'sort' => 'required|max:11',
            'discount' => 'required|max:20'
        ];
    }
     public function messages()
    {
        return [
            'shop_id.required' => trans('messages.shop_idRequired'),
            'name.required' => trans('messages.nameRequired'),
            'discount_cd.required' => trans('messages.discount_cdRequired'),
            'discount_type.required' => trans('messages.discount_typeRequired'),
            'sort.required' =>  trans('messages.sortRequired'),
            'discount.required' => trans('messages.discountRequired')
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        returnErrors($validator);
    }
}
