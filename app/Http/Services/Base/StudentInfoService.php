<?php


namespace App\Http\Services\Base;


use App\Http\Repositories\StudentInfoRepository;
use App\Http\Services\Service;
use Illuminate\Support\Facades\Hash;

class StudentInfoService extends Service
{
    /**
     * @var StudentInfoRepository
     */
    public $repository;

    /**
     * StudentInfoService constructor.
     * @param StudentInfoRepository $repository
     */
    public function __construct(StudentInfoRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $userId
     * @param array $request
     * @return array
     */
    public function studentInfoDataFormatter(int $userId, array $request): array
    {
        if($request){
            return [
                'user_id' => $userId,
                'date_of_birth' => $request['date_of_birth'],
            ];
        }
        return [];
    }

    /**
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        return $this->repository->create($data);
    }
}
