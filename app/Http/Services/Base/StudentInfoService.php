<?php


namespace App\Http\Services\Base;


use App\Http\Repositories\StudentInfoRepository;
use App\Http\Services\Service;

class StudentInfoService extends Service
{

    /**
     * StudentInfoService constructor.
     * @param StudentInfoRepository $repository
     */
    public function __construct (StudentInfoRepository $repository)
    {
        parent::__construct( $repository);
    }

    /**
     * @param int $userId
     * @param array $request
     * @return array
     */
    public function studentInfoDataFormatter (int $userId, array $request): array
    {
        if($request){
            return [
                'user_id' => $userId,
                'date_of_birth' => $request['date_of_birth'],
            ];
        }
        return [];
    }
}
