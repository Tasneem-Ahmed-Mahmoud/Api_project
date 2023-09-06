<?php

namespace App\Http\Requests\Api\Worker;

use App\Http\Requests\Api\BaseFormRequest;

class RegisterRequest extends BaseFormRequest
{
    
    public function rules(): array
    {
        return [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:workers,email,except,id',
            'password' => 'required|string|confirmed|min:6|max:30',
            'location'=>'required|max:70',
            'phone'=>'required|unique:workers,phone,except,id'
        ];
    }
}
