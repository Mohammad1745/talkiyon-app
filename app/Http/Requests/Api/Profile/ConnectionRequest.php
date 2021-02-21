<?php

namespace App\Http\Requests\Api\Profile;

use App\Http\Requests\Request;

class ConnectionRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules ():array
    {
        return [
            'connected_with' => 'required|unique:connection',
            'type' => 'required|in:'.implode(',',[CONNECTION_TYPE_FRIEND, CONNECTION_TYPE_COLLABORATOR, CONNECTION_TYPE_MENTOR, CONNECTION_TYPE_MENTEE])
        ];
    }
}
