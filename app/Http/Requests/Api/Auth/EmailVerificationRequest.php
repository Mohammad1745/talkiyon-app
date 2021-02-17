<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\Request;

class EmailVerificationRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules ():array
    {
        return [
            'email' => 'required',
            'code' => 'required'
        ];
    }
}
