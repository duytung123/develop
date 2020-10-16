<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class CoursesRequest extends FormRequest
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
        'class_id' => 'required|integer',
        'name' => 'required|max:30',
        'treatment_time' => 'required|integer',
        'buffer_time' => 'required|integer',
        'count' => 'required|integer',
        'price' => 'required|integer',
        'tax_id' => 'required|integer',
        'limit_date' => 'required',
        'month_menu_flg' => 'required|max:1',

        ];
    }

    public function messages()
    {
        return [
            'class_id.required' => trans('messages.class_idRequired'),
            'class_id.integer' => trans('messages.classs_idInteger'),
            'name.required' => trans('messages.nameCourseRequired'),
            'name.max' => trans('messages.nameCourseMax'),
            'treatment_time.required' => trans('messages.treatment_timeRequired'),
            'treatment_time.integer' => trans('messages.treatment_timeInteger'),
            'buffer_time.required' => trans('messages.buffer_timeRequired'),
            'buffer_time.integer' => trans('messages.buffer_timeInteger'),
            'count.required' => trans('messages.countRequired'),
            'count.integer' => trans('messages.countInteger'),
            'price.required' => trans('messages.priceRequired'),
            'price.integer' => trans('messages.priceInteger'),
            'tax_id.required' => trans('messages.tax_idRequired'),
            'tax_id.integer' => trans('messages.tax_idInteger'),
            'limit_date.required' => trans('messages.limit_dateRequired'),
            'month_menu_flg.required' => trans('messages.month_menu_flgRequired'),
            'month_menu_flg.max' => trans('messages.month_menu_flgMax'),

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        returnErrors($validator);
    }
}
