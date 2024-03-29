<?php

namespace App\Http\Requests\Api\Worker;

use App\Http\Requests\Api\BaseFormRequest;


class LoginRequest extends BaseFormRequest
{
   
    public function rules(): array
    {
        return [
          
                'email' => 'required|email',
                'password' => 'required|string|min:6',
            
        ];
    }
}
