<?php

namespace App\Http\Requests\Api\Timeline;

use App\Http\Requests\Request;

class RespondTalkRequest extends Request
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
            'content' => 'required',
            'files' => 'array',
            'files.*' => $this->file ? 'required' : '',
        ];
    }
}
