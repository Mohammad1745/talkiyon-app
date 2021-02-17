<?php

namespace App\Http\Requests\Api\Profile;

use App\Http\Requests\Request;

class ProfileImageRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules ():array
    {
        return [
            'image' => 'required||file|mimes:jpeg,png,jpg|max:5048'
        ];
    }
}
