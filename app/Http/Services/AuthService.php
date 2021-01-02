<?php


namespace App\Http\Services;

use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\SignupRequest;
use App\Http\Services\Base\UserService;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthService extends Service
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * AuthService constructor.
     * @param UserService $service
     */
    public function __construct(UserService $service)
    {
        $this->userService = $service;
    }

    /**
     * @param SignupRequest $request
     * @return array
     */
    public function signupProcess(SignupRequest $request): array
    {
        try {
            DB::beginTransaction();
            $randNo = randomNumber(6);
            $user  = $this->userService->create($this->userService->userDataFormatter($request->all(),$randNo));
//            $this->phoneVerificationCodeSender($user->phone,$randNo);
            $success['token'] =  $user->createToken('Talkiyon')->accessToken;
            $success['token_type'] =  'Bearer';
            $user = User::find($user->id);
            DB::commit();
            $data = [
                'authorization' => $success,
                'user_info' => [
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                    'username' => $user->username,
                    'is_email_verified' => $user->is_email_verified,
                    'role' => $user->role,
                    'code' => $user->email_verification_code,
                ]
            ];

            return $this->response($data)->success(__("Successfully signed up as a ". userRoles($user->role).". Verification Code has been sent to your email."));
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->response()->error($exception->getMessage());
        }
    }

    /**
     * @param LoginRequest $request
     * @return array
     */
    public function loginProcess(LoginRequest $request): array
    {
        try {
            if(Auth::attempt($this->credentials($request->only('email', 'password')))){
                $user = authUser();
                $success['token'] =  $user->createToken('Talkiyon')->accessToken;
                $success['token_type'] =  'Bearer';
                $user = User::find($user->id);
                DB::commit();
                $data = [
                    'authorization' => $success,
                    'user_info' => [
                        'first_name' => $user->first_name,
                        'last_name' => $user->last_name,
                        'email' => $user->email,
                        'username' => $user->username,
                        'is_email_verified' => $user->is_email_verified,
                        'role' => $user->role,
                    ]
                ];
                return $this->response($data)->success('Logged In Successfully. '.(!$user->is_email_verified ? 'Please verify your email' : ''));
            } else {
                return $this->response()->error('Wrong Email Or Password');
            }
        } catch (\Exception $exception) {
            return $this->response()->error($exception->getMessage());
        }
    }

    /**
     * @param array $data
     * @return array
     */
    private function credentials(array $data) : array {
        return filter_var($data['email'], FILTER_VALIDATE_EMAIL) ? [
            'email' => $data['email'],
            'password' => $data['password']
        ] : [
            'username' => $data['email'],
            'password' => $data['password']
        ];
    }

    /**
     * @return array
     */
    public function logoutProcess(): array
    {
        try {
            if(Auth::user()){
                Auth::logout();

                return $this->response()->success('Logged Out Successfully');
            } else {
                return $this->response()->error('Already Logged Out.');
            }
        } catch (\Exception $exception) {
            return $this->response()->error($exception->getMessage());
        }
    }
}
