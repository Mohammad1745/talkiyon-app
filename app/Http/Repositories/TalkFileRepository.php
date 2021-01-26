<?php


namespace App\Http\Repositories;


use App\Models\TalkFile;

class TalkFileRepository extends Repository
{
    /**
     * TalkFileRepository constructor.
     */
    public function __construct ()
    {
        parent::__construct( new TalkFile());
    }
}
