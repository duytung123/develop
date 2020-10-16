<?php

namespace App\Http\Requests;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class AccountRequest extends FormRequest
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

            'name'=>'required',
            'company_id' =>'required',
            'shop_id'=>'required',
            'email' => 'required|email|unique:m_users',
            'login_id' => 'required|alpha_dash',
            'password' =>'required|min:6',

        ];
    }
    public function messages()
    {
        return [
            'name.require' => trans('messages.nameRequired'),
            'email.required' => trans('messages.emailRequired'),
            'email.email' =>trans('messages.email'),
            'email.unique' => trans('messages.emailRequired'),
            'shop_id.required'=>trans('messages.shop_idRequired'),
            'company_id.required'=>trans('messages.company_idRequired'),
            'login_id.required' => trans('messages.login_idRequired'),
            'login_id.alpha_dash' => '属性には文字、数字、ダッシュ、アンダースコアのみを含めることができます',
            'password.required|min:6' => 'パスワードを入力してください。',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        returnErrors($validator);
    }
}
