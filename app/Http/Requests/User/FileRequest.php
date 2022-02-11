<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class FileRequest extends FormRequest
{
    public function authorize()
    {
        return true;

    }

    public function rules()
    {
        return [
            'file' => 'required|mimes:json,csv,xml,txt',
        ];

    }

    protected function failedValidation(Validator $validator)
    {

        if (\Request::is('api/*')){
            $error = array(
                'error' => $validator->errors(),
                'status' => false
            );
            throw new HttpResponseException(response()->json($error, 422));
        } else{
            throw (new ValidationException($validator))
                ->errorBag($this->errorBag)
                ->redirectTo($this->getRedirectUrl());
        }
    }
}
