<?php


namespace App\Http\Services\Base;


use App\Http\Services\Service;

class TeacherInfoService extends Service
{

//    /**
//     * TeacherInfoService constructor.
//     * @param TeacherInfoRepository $repository
//     */
//    public function __construct (TeacherInfoRepository $repository)
//    {
//        parent::__construct( $repository);
//    }

    /**
     * @param int $userId
     * @param array $request
     * @return array
     */
    public function teacherInfoDataFormatter (int $userId, array $request): array
    {
//        if($request){
//            return [
//                'user_id' => $userId,
//                'date_of_birth' => $request['date_of_birth'],
//            ];
//        }
//        return [];
    }
}
