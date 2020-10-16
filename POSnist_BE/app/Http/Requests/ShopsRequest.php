<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * M_shopsController
 * @author IVS
 * @since 09/2020
 */
class ShopsRequest extends FormRequest
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
            'name' => 'required|max:30',
            'company_id' => 'required',
            'postal_cd' => 'required|max:10',
            'prefecture' => 'required|max:10',
            'city' => 'required|max:50',
            'area' =>'required|max:50',
            'address' => 'required|max:50',
            'tel' => 'required|max:12',
            'email' => 'required|max:255',
            'opening_time' => 'required|max:10',
            'closing_time' => 'required|max:10',
            'time_break' => 'required|max:10',
            'facility' => 'required|max:10',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => trans('messages.NameShopRequired'),
            'name.max' => trans('messages.NameShopMax'),
            'company_id.required' =>trans('messages.Company_idShopRequired'),
            'postal_cd.required' => trans('messages.Postal_cdShopRequired'),
            'postal_cd.max' => trans('messages.Postal_cdShopMax'),
            'prefecture.required' => trans('messages.PrefectureShopRequired'),
            'prefecture.max' => trans('messages.PrefectureShopMax'),
            'city.required' => trans('messages.CityShopRequired'),
            'city.max' => trans('messages.CityShopMax'),
            'area.required' => trans('messages.AreaShopRequired'),
            'area.max' => trans('messages.AreaShopMax'),
            'address.required' => trans('messages.AddressShopRequired'),
            'address.max' => trans('messages..AddressShopMax'),
            'tel.required' => trans('messages.TelShopRequired'),
            'tel.max' => trans('messages.TelShopMax'),
            'email.required' => trans('messages.EmailShopRequired'),
            'email.max' => trans('messages.EmailShopMax'),
            'opening_time.required' => trans('messages.Opening_timeShopRequired'),
            'opening_time.max' => trans('messages.Opening_timeShopMax'),
            'closing_time.required' => trans('messages.Closing_timeShopRequired'),
            'closing_time.max' => trans('messages.Closing_timeShopMax'),
            'time_break.required' => trans('messages.Time_breakShopRequired'),
            'time_break.max' => trans('messages.Time_breakShopMax'),
            'facility.required' => trans('messages.FacilityShopRequired'),
            'facility.max' => trans('messages.FacilityShopMax'),

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        returnErrors($validator);
    }
}
