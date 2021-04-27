<?php

namespace App\Http\Requests\Api\Timeline;

use App\Http\Requests\Request;

class ReplyRespondTalkRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules ():array
    {
        return [
            'talk_id' => 'required',
            'parent_id' => 'required',
            'content' => 'required',
            'files' => 'array',
            'files.*' => $this->file ? 'required' : '',
        ];
    }
}
