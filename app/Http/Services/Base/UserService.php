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
    public function __construct (UserRepository $repository)
    {
        parent::__construct( $repository);
    }

    /**
     * @param array $data
     * @param string $randNo
     * @return array
     */
    public function userDataFormatter (array $data, string $randNo): array
    {
        if ($data){
            return [
                'email' => $data['email'],
                'username' => $data['username'],
                'password' => Hash::make( $data['password']),
                'phone' => $data['phone'],
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'role' => $data['role'],
                'gender' => $data['gender'],
                'status' => USER_PENDING_STATUS,
                'phone_verification_code' => $randNo? $randNo : null,
            ];
        }
        return [];
    }

    /**
     * @param int $userId
     * @param string $password
     * @return mixed
     */
    public function resetPassword (int $userId, string $password)
    {
        return $this->updateWhere(['id' => $userId], ['password' => Hash::make($password)]);
    }

    /**
     * @param int $userId
     * @return mixed
     */
    public function verifyEmail (int $userId)
    {
        return $this->updateWhere(['id' => $userId], ['is_email_verified' => true, 'email_verification_code' => null]);
    }

    /**
     * @param int $userId
     * @return mixed
     */
    public function verifyPhone (int $userId)
    {
        return $this->updateWhere(['id' => $userId], ['is_phone_verified' => true, 'phone_verification_code' => null]);
    }
}
