<?php


namespace App\Http\Repositories;


use App\Models\StudentInfo;

class StudentInfoRepository extends Repository
{
    /**
     * StudentInfoRepository constructor.
     */
    public function __construct ()
    {
        parent::__construct( new StudentInfo());
    }
}
