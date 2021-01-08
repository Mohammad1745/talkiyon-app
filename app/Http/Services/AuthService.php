<?php


namespace App\Http\Services;

use App\Http\Services\Base\ResetPasswordService;
use App\Http\Services\Base\StudentInfoService;
use App\Http\Services\Base\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AuthService extends ResponseService
{
    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var ResetPasswordService
     */
    private $resetPasswordService;
    /**
     * @var StudentInfoService
     */
    private $studentInfoService;

    /**
     * AuthService constructor.
     * @param UserService $userService
     * @param StudentInfoService $studentInfoService
     * @param ResetPasswordService $resetPasswordService
     */
    public function __construct(UserService $userService, StudentInfoService $studentInfoService, ResetPasswordService $resetPasswordService)
    {
        $this->userService = $userService;
        $this->resetPasswordService = $resetPasswordService;
        $this->studentInfoService = $studentInfoService;
    }

    /**
     * @param object $request
     * @return array
     */
    public function signupProcess(object $request): array
    {
        try {
            DB::beginTransaction();
            $randNo = randomNumber(6);
            $user = $this->userService->create($this->userService->userDataFormatter($request->all(),$randNo));
            $this->studentInfoService->create($this->studentInfoService->studentInfoDataFormatter($user->id, $request->all()));
            $this->_emailVerificationCodeSender($user->first_name.' '.$user->last_name, $user->email,$randNo);
            $authorization = $this->_authorize($user);
            DB::commit();

            return $this->response($this->_authData($user, $authorization))->success(__("Successfully signed up as a ". userRoles($user->role).". Verification Code has been sent to your email."));
        } catch (\Exception $exception) {
            DB::rollBack();

            return $this->response()->error($exception->getMessage());
        }
    }

    /**
     * @param object $request
     * @return array
     */
    public function loginProcess(object $request): array
    {
        try {
            DB::beginTransaction();
            if(Auth::attempt($this->_credentials($request->only('email', 'password')))){
                $user = Auth::user();
                $authorization = $this->_authorize($user);
                DB::commit();

                return $this->response($this->_authData($user, $authorization))->success('Logged In Successfully. '.(!$user->is_email_verified ? 'Please verify your email' : ''));
            } else {
                DB::rollBack();

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
            $this->userService->updateWhere(['id' => $user->id], ['email_verification_code' => $randNo]);
            $this->_emailVerificationCodeSender($user->first_name.' '.$user->last_name, $user->email,$randNo);
            DB::commit();

            return $this->response()->success(__("Verification Code has been sent to ".$user->email.'.'));
        } catch (\Exception $exception) {
            DB::rollBack();

            return $this->response()->error($exception->getMessage());
        }
    }

    /**
     * @param object $request
     * @return array
     */
    public function emailVerificationProcess(object $request): array
    {
        try {
            if (!(Auth::user()->email==$request->email && Auth::user()->email_verification_code==$request->code)){
                return $this->response()->error(__('Wrong entry'));
            }
            $this->userService->verifyEmail(Auth::id());

            return $this->response()->success(__("Email Successfully Verified."));
        } catch (\Exception $exception) {
            return $this->response()->error($exception->getMessage());
        }
    }

    /**
     * @param object $request
     * @return array
     */
    public function sendResetPasswordCodeProcess(object $request): array
    {
        try {
            DB::beginTransaction();
            $randNo = randomNumber(6);
            $user = $this->userService->firstWhere(['email' => $request->email]);
            $this->resetPasswordService->create($this->resetPasswordService->resetPasswordDataFormatter($user->id, $randNo));
            $this->_resetPasswordCodeSender($user->first_name.' '.$user->last_name, $user->email,$randNo);
            DB::commit();

            return $this->response()->success(__("Password Reset Code has been sent to ".$user->email.'.'));
        } catch (\Exception $exception) {
            DB::rollBack();

            return $this->response()->error($exception->getMessage());
        }
    }

    /**
     * @param object $request
     * @return array
     */
    public function resetPasswordProcess(object $request): array
    {
        try {
            DB::beginTransaction();
            $user = $this->userService->firstWhere(['email' => $request->email]);
            $passwordReset = $user ? $this->resetPasswordService->firstWhere(['user_id' => $user->id, 'code' => $request->code]) : null;
            if (!$passwordReset){
                DB::rollBack();

                return $this->response()->error(__('Wrong entry'));
            }
            $this->resetPasswordService->deleteWhere(['user_id' => $user->id]);
            $this->userService->resetPassword($user->id, $request->password);
            DB::commit();

            return $this->response()->success(__("Password Reset Successful."));

        } catch (\Exception $exception) {
            DB::rollBack();

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
     * @param string $name
     * @param string $email
     * @param string $code
     */
    private function _resetPasswordCodeSender(string $name, string $email, string $code)
    {
        $data = array('name'=> $name, 'code' => $code);
        Mail::send('email.auth.reset-password', $data, function($message) use ($name, $email) {
            $message->to($email, $name)
                ->subject('Reset Password');
            $message->from('talkiyon@example.com', 'Talkiyon');
        });
    }

    /**
     * @param object $user
     * @return array
     */
    private function _authorize(object $user): array
    {
        return [
            'token' =>  $user->createToken('Talkiyon')->accessToken,
            'token_type' =>  'Bearer'
        ];
    }

    /**
     * @param object $user
     * @param array $authorization
     * @return array
     */
    private function _authData(object $user, array $authorization): array
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
