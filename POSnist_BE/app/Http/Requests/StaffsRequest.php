<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class StaffsRequest extends FormRequest
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
        return
        [
            'shop_id' => 'required|max:10',
            'name' => 'required|max:30',
            'name_kana' => 'required|max:20',
            'staff_img' => 'required|max:255',
            'sex' => 'required|max:20',

        ];
    }

    public function messages()
    {
        return
        [
            'shop_id.required' => trans('messages.shop_idRequired'),
            'name.required' => trans('messages.nameRequired'),
            'name_kana.required' => trans('messages.name_kanaRequired'),
            'sex.required' =>trans('messages.sexRequired'),
            'staff_img.required' => trans('messages.staff_img'),
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        returnErrors($validator);
    }
}
