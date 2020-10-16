<?php

namespace App\Http\Requests;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class SkillRequest extends FormRequest
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
        'class_id' => 'required|max:30',
        'name' => 'required|max:30',
        'treatment_time' => 'required|max:20',
        'buffer_time' => 'required:max:20',
        'price' => 'required|max:20',
        'tax_id' => 'required',
        'web_flg' =>'required|max:10',
        'sort' => 'required|max:2',
        'color_code' => 'required|max:6',
    ];
    }

    public function messages()
    {
        return [
        'class_id.required' => trans('messages.class_idRequired'),
        'name.required' => trans('messages.name_skillRequired'),
        'treatment_time.required' => trans('messages.treatment_timeRequired'),
        'buffer_time.required' => trans('messages.buffer_timeRequired'),
        'price.required' => trans('messages.priceRequired'),
        'tax_id.required' => trans('messages.tax_idRequired'),
        'web_flg.required' =>trans('messages.web_flgRequired'),
        'sort.required' => trans('messages.sortRequired'),
        'color_code.required' => trans('messages.color_code'),

    ];
    }

    public function FunctionName($counts, $arr ,$key=false,$value=false)
    {
        $result;
        for ($i=0; $i < $counts; $i++) {
            if($key){
                return $result= ($arr[$i]);
            }
            if($value==false){
                return $result= ($arr[$i]);
            }
        }
    }

    protected function failedValidation(Validator $validator)
    {
        returnErrors($validator);
    }
}
