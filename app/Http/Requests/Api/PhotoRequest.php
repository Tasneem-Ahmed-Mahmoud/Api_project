<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Api\BaseFormRequest;


class PhotoRequest extends BaseFormRequest
{
   
    public function rules(): array
    {
        return [
            'photo'=>'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ];
    }
}
