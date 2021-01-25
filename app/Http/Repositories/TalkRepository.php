<?php


namespace App\Http\Repositories;


use App\Models\Talk;

class TalkRepository extends Repository
{
    /**
     * TalkRepository constructor.
     */
    public function __construct ()
    {
        parent::__construct( new Talk());
    }
}
