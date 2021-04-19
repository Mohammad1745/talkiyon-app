<?php


namespace App\Http\Repositories;


use App\Models\TalkBoo;

class TalkBooRepository extends Repository
{
    /**
     * TalkBooRepository constructor.
     */
    public function __construct ()
    {
        parent::__construct( new TalkBoo());
    }
}
