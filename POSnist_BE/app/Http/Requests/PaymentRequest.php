<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
class PaymentRequest extends FormRequest
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
            'payment' => 'required|max:30',
        ];
    }

    public function messages()
    {
        return [
            'payment.required' => trans('messages.PaymentRequired'),
            'payment.max' => trans('messages.PaymentMax'),
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        returnErrors($validator);
    }
}
