<?php

namespace App\Http\Requests\Api\Timeline;

use App\Http\Requests\Request;

class UpdateResponseRequest extends Request
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
            'talk_id' => 'required',
            'content' => 'required',
            'files' => 'array',
            'files.*' => $this->file ? 'required' : '',
        ];
    }
}
