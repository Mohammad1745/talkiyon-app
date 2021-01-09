<?php


namespace App\Http\Services\Base;


use App\Http\Repositories\ResetPasswordRepository;
use App\Http\Services\Service;

class ResetPasswordService extends Service
{
    /**
     * ResetPasswordService constructor.
     * @param ResetPasswordRepository $repository
     */
    public function __construct (ResetPasswordRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @param int $userId
     * @param string $randNo
     * @return array
     */
    public function resetPasswordDataFormatter (int $userId, string $randNo): array
    {
        if($userId){
            return [
                'user_id' => $userId,
                'code' => $randNo? $randNo : null,
            ];
        }
        return [];
    }
}
