<?php

namespace App\Http\Requests;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;


class CompaniesRequest extends FormRequest
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
            'postal_cd' => 'required|max:10',
            'prefecture' => 'required|max:10',
            'city' => 'required|max:50',
            'area' => 'required|max:50',
            'address' => 'required:max:10',
            'accounting' => 'required|max:10',
            'cutoff_date' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => trans('messages.nameRequired'),
            'name.max' => trans('messages.nameMax'),
            'postal_cd.required' => trans('messages.postal_cdRequired'),
            'postal_cd.max' => trans('messages.postal_cdMax'),
            'prefecture.required' => trans('messages.prefectureRequired'),
            'prefecture.max' => trans('messages.prefectureMax'),
            'city.required' => trans('messages.cityRequired'),
            'city.max' => trans('messages.cityMax'),
            'area.required' => trans('messages.areaRequired'),
            'area.max' => trans('messages.areaMax'),
            'address.required' => trans('messages.addressRequired'),
            'address.max' => trans('messages.addressMax'),
            'accounting.required' => trans('messages.accountingRequired'),
            'accounting.max' => trans('messages.accountingMax'),
            'cutoff_date.required' => trans('messages.cutoff_dateRequired'),
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        returnErrors($validator);
    }
}
