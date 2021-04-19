<?php


namespace App\Http\Repositories;


use App\Models\TalkClap;

class TalkClapRepository extends Repository
{
    /**
     * TalkClapRepository constructor.
     */
    public function __construct ()
    {
        parent::__construct( new TalkClap());
    }
}
