<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class MStaffReceptsRequest extends FormRequest
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
            'staff_id' => 'required|integer',
            'recept_amount' => 'required|integer',
            'web_flg' => 'required|max:1',
            'nomination' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'staff_id.required' => trans('messages.staff_idRequired'),
            'staff_id.integer' => trans('messages.staff_idInteger'),
            'recept_amount.required' => trans('messages.recept_amountRequired'),
            'recept_amount.integer' => trans('messages.recept_amountInteger'),
            'web_flg.required' => trans('messages.web_flgRequired'),
            'web_flg.max' => trans('messages.web_flgMax'),
            'nomination.required' => trans('messages.nominationRequired'),
            'nomination.integer' => trans('messages.nominationInteger'),
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        returnErrors($validator);
    }
}
