<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class ShopPaymentsRequest extends FormRequest
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
            'shop_id' => 'required|integer',
            'name' => 'required|max:30',
            'sort' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'shop_id.required' => trans('messages.shop_idRequired'),
            'shop_id.integer' => trans('messages.shop_idInteger'),                        
            'name.required' => trans('messages.nameShopPaymentRequired'),
            'name.max' => trans('messages.nameShopPaymentMax'),
            'sort.required' => trans('messages.sortRequired'),
            'sort.integer' => trans('messages.sortInteger'),
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(
            [
                "message" => "fail",
                "error" => ["field" => $validator->errors(),"code" => "400"]
            ],
            400
        ));
    }
}
