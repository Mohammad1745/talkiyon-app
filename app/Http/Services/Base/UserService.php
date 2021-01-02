<?php


namespace App\Http\Services\Base;


use App\Http\Repositories\UserRepository;
use App\Http\Services\Service;
use Illuminate\Support\Facades\Hash;

class UserService extends Service
{
    /**
     * @var UserRepository
     */
    public $repository;

    /**
     * UserService constructor.
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
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
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        return $this->repository->create($data);
    }
}
