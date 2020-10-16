<?php

namespace App\Http\Requests;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;


class ShopViewRequest extends FormRequest
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
        'shop_id' => 'required|max:30',
        'name' => 'required|max:30',
        'log_img' => 'required|max:255',
        'postal_cd' => 'required:max:20',
        'prefecture' => 'required|max:20',
        'city' => 'required|max:20',
        'area' =>'required|max:10',
        'address' => 'required|max:20',
        'tel' => 'required|max:10',
        'access' => 'required|max:10',
    ];
}

    public function messages()
    {
        return
        [
            'shop_id.required' => trans('messages.shop_idRequired'),
            'name.required' => trans('messages.nameRequired'),
            'log_img.required' => trans('messages.log_imgRequired'),
            'postal_cd.required' => trans('messages.postal_cdRequired'),
            'prefecture.required' => trans('messages.prefectureRequired'),
            'city.required' => trans('messages.cityRequired'),
            'area.required' =>trans('messages.areaRequired'),
            'address.required' => trans('messages.addressRequired'),
            'tel.required' => trans('messages.telRequired'),
            'access.required' => trans('messages.accessRequired'),

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        returnErrors($validator);
    }
}
