<?php

namespace App\Http\Requests;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class ShopMailDestinationsRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email'
        ];
    }

    public function messages()
    {
        return [
           'name.required' => trans('messages.nameShopMailDestinationsRequired'),
           'email.required' => trans('messages.emailShopMailDestinationsRequired'),
           'email.email' => trans('messages.emailShopMailDestinationsEmail'),
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        returnErrors($validator);
    }
}
