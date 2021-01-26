<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Request;

class PresentTalkRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules ():array
    {
        return [
            'content' => 'required',
            'type' => 'required|in:'.implode(',',[TALK_TYPE_TALKIYON_OFFICIAL,TALK_TYPE_PUBLIC]),
            'security_type' => 'required|in:'.implode(',',[TALK_SECURITY_TYPE_PUBLIC,TALK_SECURITY_TYPE_SPECIFIC,TALK_SECURITY_TYPE_CONNECTION]),
        ];
    }
}
