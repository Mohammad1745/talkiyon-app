<?php


namespace App\Http\Repositories;


use App\Models\TalkResponseClap;

class TalkResponseClapRepository extends Repository
{
    /**
     * TalkResponseClapRepository constructor.
     */
    public function __construct ()
    {
        parent::__construct( new TalkResponseClap());
    }
}
