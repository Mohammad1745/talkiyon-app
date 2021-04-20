<?php


namespace App\Http\Repositories;


use App\Models\TalkResponse;

class TalkResponseRepository extends Repository
{
    /**
     * TalkResponseRepository constructor.
     */
    public function __construct ()
    {
        parent::__construct( new TalkResponse());
    }
}
