<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class CustomersRequest extends FormRequest
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
        "firstname"=> 'required|max:10',
        "lastname"=> 'required|max:10',
        "firstname_kana"=> 'required|max:20',
        "lastname_kana"=> 'required|max:20',
        "sex"=> 'required|max:1',
        "email"=> 'required|max:255',
        "tel"=> 'required|max:12',
        "login_id" => 'required|max:255',
        "password" => 'required|max:255',
        "staff_id" => 'required',
        "member_flg" => 'required|max:1',
        "customer_img"=> 'required|max:255',
        "postal_cd"=> 'required|max:10',
        "prefecture"=> 'required|max:10',
        "city"=> 'required|max:50',
        "area"=> 'required|max:50',
        "address"=> 'required|max:50',
        "language"=> 'required|max:3',
        "visit_cnt"=> 'required',
        "first_visit"=> 'required',
        "last_visit"=> 'required',

        ];
    }

    public function messages()
    {
        return [
        'customer_no.max' => trans('messages.customer_noMax'),
        'firstname.required'=> trans('messages.firstnameRequired'),
        'firstname.max' => trans('messages.firstnameMax'),
        'lastname.required'=> trans('messages.lastnameRequired'),
        'lastname.max' => trans('messages.lastnameMax'),
        'firstname_kana.required'=> trans('messages.firstname_kanaRequired'),
        'firstname_kana.max' => trans('messages.firstname_kanaMax'),
        'lastname_kana.required'=> trans('messages.lastname_kanaRequired'),
        'lastname_kana.max' => trans('messages.lastname_kanaMax'),
        'sex.required'=> trans('messages.sexRequired'),
        'sex.max' => trans('messages.sexMax'),
        'email.required'=> trans('messages.emailRequired'),
        'email.max' => trans('messages.emailMax'),
        'tel.required'=> trans('messages.telRequired'),
        'tel.max' => trans('messages.telMax'),
        'login_id.required'=> trans('messages.login_idRequired'),
        'login_id.max' => trans('messages.login_idMax'),
        'password.required'=> trans('messages.passwordRequired'),
        'password.max' => trans('messages.passwordMax'),
        'staff_id.required'=> trans('messages.staff_idRequired'),
        'member_flg.required'=> trans('messages.member_flgRequired'),
        'member_flg.max' => trans('messages.member_flgMax'),
        'customer_img.required'=> trans('messages.customer_imgRequired'),
        'customer_img.max' => trans('messages.customer_imgMax'),
        'postal_cd.required'=> trans('messages.postal_cdRequired'),
        'postal_cd.max' => trans('messages.postal_cdMax'),
        'prefecture.required'=> trans('messages.prefectureRequired'),
        'prefecture.max' => trans('messages.prefectureMax'),
        'city.required'=> trans('messages.cityRequired'),
        'city.max' => trans('messages.cityMax'),
        'area.required'=> trans('messages.areaRequired'),
        'area.max' => trans('messages.areaMax'),
        "address.required"=> trans('messages.addressRequired'),
        'address.max' => trans('messages.addressMax'),
        "language.required"=> trans('messages.languageRequired'),
        'language.max' => trans('messages.languageMax'),
        "visit_cnt.required"=> trans('messages.visit_cntRequired'),
        "first_visit.required"=> trans('messages.first_visitRequired'),
        "last_visit.required"=> trans('messages.last_visitRequired'),
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        returnErrors($validator);
    }
}
