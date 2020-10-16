<?php
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

    function returnErrors(Validator $validator)
    {
        $field = json_decode(json_encode($validator->errors()->keys()), false);
        $errors = $validator->errors();
        $counts = count($errors);

        foreach ($errors->all() as $key => $error) {
            $message[] = $error;
        }

        $errors = [];
        for ($i = 0 ; $i < count($field); $i++) {
            $errors[$i] = [
                "field" => $field[$i],
                "message" => $message[$i],
                "code" => 422
            ];
        }

        throw new HttpResponseException(response()
        ->json([
                "message" => "fail",
                "errors" => $errors
        ], 422));
    }

