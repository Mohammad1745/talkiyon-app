<?php


namespace App\Http\Services\Base;


use App\Http\Repositories\UserRepository;
use App\Http\Services\Service;
use Illuminate\Support\Facades\Hash;

class UserService extends Service
{
    /**
     * UserService constructor.
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @param $request
     * @param $randNo
     * @return array
     */
    public function userDataFormatter(array $request, string $randNo): array
    {
        if($request){
            return [
                'email' => $request['email'],
                'username' => $request['username'],
                'password' => Hash::make($request['password']),
                'phone' => $request['phone'],
                'first_name' => $request['first_name'],
                'last_name' => $request['last_name'],
                'role' => $request['role'],
                'gender' => $request['gender'],
                'status' => USER_PENDING_STATUS,
                'email_verification_code' => $randNo? $randNo : null,
            ];
        }
        return [];
    }

    /**
     * @param int $userId
     * @param string $password
     * @return mixed
     */
    public function resetPassword(int $userId, string $password)
    {
        return $this->updateWhere(['id' => $userId], ['password' => Hash::make($password)]);
    }

    /**
     * @param int $userId
     * @return mixed
     */
    public function verifyEmail(int $userId)
    {
        return $this->updateWhere(['id' => $userId], ['is_email_verified' => true, 'email_verification_code' => null]);
    }
}
