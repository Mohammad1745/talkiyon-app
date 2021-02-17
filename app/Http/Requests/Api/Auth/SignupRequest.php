<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\Request;

class SignupRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules ():array
    {
        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
            'phone' => 'required|unique:users|regex: /^(01){1}[1-9]{1}[0-9]{8}$/',
            'role' => 'required|in:'.implode(',',[STUDENT_ROLE,TEACHER_ROLE]),
            'gender' => 'required|in:'.implode(',',[SEX_MALE,SEX_FEMALE,SEX_OTHER]),
            'date_of_birth' => 'required|date|before:now',
        ];
    }
}
