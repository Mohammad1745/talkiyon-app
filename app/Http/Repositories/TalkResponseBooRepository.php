<?php


namespace App\Http\Repositories;


use App\Models\TalkResponseBoo;

class TalkResponseBooRepository extends Repository
{
    /**
     * TalkResponseBooRepository constructor.
     */
    public function __construct ()
    {
        parent::__construct( new TalkResponseBoo());
    }
}
