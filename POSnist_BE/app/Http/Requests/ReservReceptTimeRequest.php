<?php

namespace App\Http\Requests;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class ReservReceptTimeRequest extends FormRequest
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
           'recept_type'=>'required',
           'recept_start'=>'required',
           'recept_end'=>'required',
           'recept_start_mo'=>'required',
           'recept_end_mo'=>'required',
           'recept_start_tu'=>'required',
           'recept_end_tu'=>'required',
           'recept_start_we'=>'required',
           'recept_end_we'=>'required',
           'recept_start_th'=>'required',
           'recept_end_th'=>'required',
           'recept_start_fr'=>'required',
           'recept_end_fr'=>'required',
           'recept_start_sa'=>'required',
           'recept_end_sa'=>'required',
           'recept_start_su'=>'required',
           'recept_end_su'=>'required',
           'recept_start_ho'=>'required',
           'recept_end_ho'=>'required',

        ];
    }
    public function messages()

    {
        return [
            'recept_type.required' => trans('messages.recept_type'),
            'recept_start.required' => trans('messages.recept_start'),
            'recept_end.required' => trans('messages.recept_end'),
            'recept_start_mo.required' => trans('messages.recept_start_mo'),
            'recept_end_mo.required' => trans('messages.recept_end_mo'),
            'recept_start_tu.required' => trans('messages.recept_start_tu'),
            'recept_end_tu.required' => trans('messages.recept_end_tu'),
            'recept_start_we.required' => trans('messages.recept_start_we'),
            'recept_end_we.required' => trans('messages.recept_end_we'),
            'recept_start_th.required' => trans('messages.recept_start_th'),
            'recept_end_th.required' => trans('messages.recept_end_th'),
            'recept_start_fr.required' => trans('messages.recept_start_fr'),
            'recept_end_fr.required' => trans('messages.recept_end_fr'),
            'recept_start_sa.required' => trans('messages.recept_start_sa'),
            'recept_end_sa.required' => trans('messages.recept_end_sa'),
            'recept_start_su.required' => trans('messages.recept_start_su'),
            'recept_end_su.required' => trans('messages.recept_end_su'),
            'recept_start_ho.required' => trans('messages.recept_start_ho'),
            'recept_end_ho.required' => trans('messages.recept_end_ho'),


        ];
    }

    protected function failedValidation(Validator $validator)
    {
        returnErrors($validator);
    }
}
