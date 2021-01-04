<?php


namespace App\Http\Services;

use App\Http\Requests\Api\EmailVerificationRequest;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\SignupRequest;
use App\Http\Services\Base\StudentInfoService;
use App\Http\Services\Base\UserService;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use const http\Client\Curl\AUTH_ANY;

class AuthService extends Service
{
    /**
     * @var UserService
     */
    private $userService;
    private $studentInfoService;

    /**
     * AuthService constructor.
     * @param UserService $userService
     * @param StudentInfoService $studentInfoService
     */
    public function __construct(UserService $userService, StudentInfoService $studentInfoService)
    {
        $this->userService = $userService;
        $this->studentInfoService = $studentInfoService;
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
            $this->studentInfoService->create($this->studentInfoService->studentInfoDataFormatter($user->id, $request->all()));
            $this->_emailVerificationCodeSender($user->first_name.' '.$user->last_name, $user->email,$randNo);
            $authorization['token'] =  $user->createToken('Talkiyon')->accessToken;
            $authorization['token_type'] =  'Bearer';
            DB::commit();

            return $this->response($this->_authData($user, $authorization))->success(__("Successfully signed up as a ". userRoles($user->role).". Verification Code has been sent to your email."));
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
            if(Auth::attempt($this->_credentials($request->only('email', 'password')))){
                $user = authUser();
                $authorization['token'] =  $user->createToken('Talkiyon')->accessToken;
                $authorization['token_type'] =  'Bearer';
                DB::commit();

                return $this->response($this->_authData($user, $authorization))->success('Logged In Successfully. '.(!$user->is_email_verified ? 'Please verify your email' : ''));
            } else {
                return $this->response()->error('Wrong Email Or Password');
            }
        } catch (\Exception $exception) {
            return $this->response()->error($exception->getMessage());
        }
    }

    /**
     * @return array
     */
    public function resendEmailVerificationCodeProcess(): array
    {
        try {
            DB::beginTransaction();
            $randNo = randomNumber(6);
            $user = Auth::user();
            $this->_emailVerificationCodeSender($user->first_name.' '.$user->last_name, $user->email,$randNo);
            DB::commit();

            return $this->response()->success(__("Verification Code has been sent to ".$user->email.'.'));
        } catch (\Exception $exception) {
            DB::rollBack();

            return $this->response()->error($exception->getMessage());
        }
    }

    /**
     * @param EmailVerificationRequest $request
     * @return array
     */
    public function emailVerificationProcess(EmailVerificationRequest $request): array
    {
        try {
            if (Auth::user()->email==$request->email && Auth::user()->email_verification_code==$request->code){
                $this->userService->verifyEmail(Auth::id());

                return $this->response()->success(__("Email Successfully Verified."));
            } else {
                return $this->response()->error(__('Wrong entry'));
            }

        } catch (\Exception $exception) {

            return $this->response()->error($exception->getMessage());
        }
    }

    /**
     * @return array
     */
    public function logoutProcess(): array
    {
        try {
            if(Auth::user()){
                Auth::user()->token()->revoke();

                return $this->response()->success('Logged Out Successfully');
            } else {
                return $this->response()->error('Already Logged Out.');
            }
        } catch (\Exception $exception) {
            return $this->response()->error($exception->getMessage());
        }
    }

    /**
     * @param string $name
     * @param string $email
     * @param string $code
     */
    private function _emailVerificationCodeSender(string $name, string $email, string $code)
    {
        $data = array('name'=> $name, 'code' => $code);
        Mail::send('email.auth.verification', $data, function($message) use ($name, $email) {
            $message->to($email, $name)
                ->subject('Email Verification');
            $message->from('talkiyon@example.com', 'Talkiyon');
        });
    }
    /**
     * @param User $user
     * @param array $authorization
     * @return array
     */
    private function _authData(User $user, array $authorization): array
    {
        return [
            'authorization' => $authorization,
            'user_info' => [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'username' => $user->username,
                'is_email_verified' => $user->is_email_verified,
                'role' => $user->role,
            ]
        ];
    }

    /**
     * @param array $data
     * @return array
     */
    private function _credentials(array $data) : array {
        return filter_var($data['email'], FILTER_VALIDATE_EMAIL) ? [
            'email' => $data['email'],
            'password' => $data['password']
        ] : [
            'username' => $data['email'],
            'password' => $data['password']
        ];
    }
}
