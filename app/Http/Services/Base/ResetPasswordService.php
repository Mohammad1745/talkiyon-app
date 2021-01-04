<?php


namespace App\Http\Services\Base;


use App\Http\Repositories\ResetPasswordRepository;
use App\Http\Services\Service;
use Illuminate\Support\Facades\Hash;
use phpDocumentor\Reflection\Types\Integer;
use phpseclib\Math\BigInteger;

class ResetPasswordService extends Service
{
    /**
     * @var ResetPasswordRepository
     */
    public $repository;

    /**
     * ResetPasswordService constructor.
     * @param ResetPasswordRepository $repository
     */
    public function __construct(ResetPasswordRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $userId
     * @param string $randNo
     * @return array
     */
    public function resetPasswordDataFormatter(int $userId, string $randNo): array
    {
        if($userId){
            return [
                'user_id' => $userId,
                'code' => $randNo? $randNo : null,
            ];
        }
        return [];
    }

    /**
     * @param $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    /**
     * @param array $where
     * @return mixed
     */
    public function firstWhere(array $where)
    {
        return $this->repository->firstWhere($where);
    }

    /**
     * @param array $where
     * @return mixed
     */
    public function deleteWhere(array $where)
    {
        return $this->repository->deleteWhere($where);
    }
}
