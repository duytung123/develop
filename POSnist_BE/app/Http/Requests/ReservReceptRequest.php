<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class ReservReceptRequest extends FormRequest
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
            'reserv_interval' => 'required|max:1',
            'recept_rest' => 'required|max:1',
            'recept_amount' => 'required',
            'cancel_setting_flg' => 'required|max:1',
            'cancel_limit' => 'required|max:2',
            'future_reserv_num' => 'required',
            'cancel_wait_flg' => 'required|max:1',
        ];
    }

    public function messages()
    {
        return [
            'reserv_interval.required' => trans('messages.reserv_intervalRequired'),
            'reserv_interval.max' => trans('messages.reserv_intervalMax'),
            'recept_rest.required' => trans('messages.recept_restRequired'),
            'recept_rest.max' => trans('messages.recept_restMax'),
            'recept_amount.required' => trans('messages.recept_amountRequired'),
            'cancel_setting_flg.required' => trans('messages.cancel_setting_flgRequired'),
            'cancel_setting_flg.max' => trans('messages.cancel_setting_flgMax'),
            'cancel_limit.required' => trans('messages.cancel_limitRequired'),
            'cancel_limit.max' => trans('messages.cancel_limitMax'),
            'future_reserv_num.required' => trans('messages.sfuture_reserv_numRequired'),
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        returnErrors($validator);
    }
}
