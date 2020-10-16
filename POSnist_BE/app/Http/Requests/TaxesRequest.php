<?php

namespace App\Http\Requests;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class TaxesRequest extends FormRequest
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
            'name' => 'required|max:3',
            'tax' => 'required|max:3',
            'reduced_flg' => 'required|numeric|max:11',
            'start_date' => 'required',
            'end_date' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => trans('messages.nameTaxesRequired'),
            'name.max' => trans('messages.nameMax'),
            'tax.required' => trans('messages.taxTaxesRequired'),
            'tax.max' => trans('messages.taxTaxesMax'),
            'reduced_flg.required' => trans('messages.reduced_flgTaxesRequired'),
            'reduced_flg.numeric' => trans('messages.reduced_flgTaxesNumeric'),
            'reduced_flg.max' => trans('messages.reduced_flgTaxesMax'),
            'start_date.required' => trans('messages.start_dateTaxesRequired'),
            'end_date.required' => trans('messages.end_dateTaxesRequired'),
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        returnErrors($validator);
    }
}
