<?php

namespace App\Http\Requests\Api\Timeline;

use App\Http\Requests\Request;

class UpdateTalkRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules ():array
    {
        return [
            'id' => 'required',
            'content' => 'required',
            'type' => 'required|in:'.implode(',',[TALK_TYPE_TALKIYON_OFFICIAL,TALK_TYPE_PUBLIC]),
            'security_type' => 'required|in:'.implode(',',[TALK_SECURITY_TYPE_PUBLIC,TALK_SECURITY_TYPE_SPECIFIC,TALK_SECURITY_TYPE_CONNECTION]),
            'files' => 'array',
            'files.*' => $this->file ? 'required' : '',
        ];
    }
}
