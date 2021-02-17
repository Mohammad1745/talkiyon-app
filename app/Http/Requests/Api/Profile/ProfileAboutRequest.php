<?php

namespace App\Http\Requests\Api\Profile;

use App\Http\Requests\Request;

class ProfileAboutRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules ():array
    {
        return [
            'about' => 'required|string'
        ];
    }
}
