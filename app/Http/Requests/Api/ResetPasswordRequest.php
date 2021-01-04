<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Request;

class ResetPasswordRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules():array
    {
        return [
            'email' => 'required',
            'code' => 'required',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
        ];
    }
}
