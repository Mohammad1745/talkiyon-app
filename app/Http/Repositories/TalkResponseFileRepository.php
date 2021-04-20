<?php


namespace App\Http\Repositories;


use App\Models\TalkResponseFile;

class TalkResponseFileRepository extends Repository
{
    /**
     * TalkResponseFileRepository constructor.
     */
    public function __construct ()
    {
        parent::__construct( new TalkResponseFile());
    }
}
