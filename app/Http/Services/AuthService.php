<?php


namespace App\Http\Services;

use App\Http\Services\Base\ResetPasswordService;
use App\Http\Services\Base\StudentInfoService;
use App\Http\Services\Base\UserService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;

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
    public function __construct (UserService $userService, StudentInfoService $studentInfoService, ResetPasswordService $resetPasswordService)
    {
        $this->userService = $userService;
        $this->resetPasswordService = $resetPasswordService;
        $this->studentInfoService = $studentInfoService;
    }

    /**
     * @param object $request
     * @return array
     */
    public function signupProcess (object $request): array
    {
        try {
            DB::beginTransaction();
            $randNo = randomNumber(6);
            $user = $this->userService->create( $this->userService->userDataFormatter( $request->all(),$randNo));
            $this->studentInfoService->create( $this->studentInfoService->studentInfoDataFormatter( $user->id, $request->all()));
            $this->_phoneVerificationCodeSender( $user->first_name.' '.$user->last_name, $user->phone,$randNo);
            $authorization = $this->_authorize( $user);
            DB::commit();

            return $this->response( $this->_authData($user, $authorization))->success(__("Successfully signed up as a ". userRoles( $user->role).". Verification Code has been sent to ".$user->phone."."));
        } catch (Exception $exception) {
            DB::rollBack();

            return $this->response()->error( $exception->getMessage());
        }
    }

    /**
     * @param object $request
     * @param string $requestType
     * @return array
     */
    public function loginProcess (object $request, string $requestType='api'): array
    {
        try {
            DB::beginTransaction();
            if(Auth::attempt( $this->_credentials( $request->only('phone', 'password')))){
                $user = Auth::user();
                $authorization = $this->_authorize( $user);
                DB::commit();

                return $this->response( $this->_authData($user, $authorization))->success('Logged In Successfully. '.(!$user->is_phone_verified ? 'Please verify your account' : ''));
            } else {
                DB::rollBack();

                return $this->response()->error('Wrong Email Or Password');
            }
        } catch (Exception $exception) {
            return $this->response()->error( $exception->getMessage());
        }
    }

    /**
     * @param object $request
     * @return array
     */
    public function adminLoginProcess (object $request): array
    {
        try {
            if(Auth::attempt( $this->_credentials( $request->only('phone', 'password')))){
                return $this->response()->success('Logged In Successfully.');
            } else {
                return $this->response()->error('Wrong Email Or Password');
            }
        } catch (Exception $exception) {
            return $this->response()->error( $exception->getMessage());
        }
    }

    /**
     * @return array
     */
    public function resendPhoneVerificationCodeProcess (): array
    {
        try {
            DB::beginTransaction();
            $randNo = randomNumber(6);
            $user = Auth::user();
            $this->userService->updateWhere(['id' => $user->id], ['phone_verification_code' => $randNo]);
            $this->_phoneVerificationCodeSender( $user->first_name.' '.$user->last_name, $user->phone,$randNo);
            DB::commit();

            return $this->response()->success(__("Verification Code has been sent to ".$user->phone.'.'));
        } catch (Exception $exception) {
            DB::rollBack();

            return $this->response()->error( $exception->getMessage());
        }
    }

    /**
     * @param object $request
     * @return array
     */
    public function phoneVerificationProcess (object $request): array
    {
        try {
            if (Auth::user()->phone_verification_code!=$request->code){
                return $this->response()->error(__('Wrong entry'));
            }
            $this->userService->verifyPhone( Auth::id());

            return $this->response()->success(__("Phone Verification Successful."));
        } catch (Exception $exception) {
            return $this->response()->error( $exception->getMessage());
        }
    }

    /**
     * @return array
     */
    public function resendEmailVerificationCodeProcess (): array
    {
        try {
            DB::beginTransaction ();
            $randNo = randomNumber(6);
            $user = Auth::user();
            $this->userService->updateWhere(['id' => $user->id], ['email_verification_code' => $randNo]);
            $this->_emailVerificationCodeSender( $user->first_name.' '.$user->last_name, $user->email,$randNo);
            DB::commit();

            return $this->response()->success(__("Verification Code has been sent to ".$user->email.'.'));
        } catch (Exception $exception) {
            DB::rollBack();

            return $this->response()->error( $exception->getMessage());
        }
    }

    /**
     * @param object $request
     * @return array
     */
    public function emailVerificationProcess (object $request): array
    {
        try {
            if (Auth::user()->email_verification_code!=$request->code){
                return $this->response()->error(__('Wrong entry'));
            }
            $this->userService->verifyEmail( Auth::id());

            return $this->response()->success(__("Email Successfully Verified."));
        } catch (Exception $exception) {
            return $this->response()->error( $exception->getMessage());
        }
    }

    /**
     * @param object $request
     * @return array
     */
    public function sendResetPasswordCodeProcess (object $request): array
    {
        try {
            DB::beginTransaction();
            $randNo = randomNumber(6);
            $user = $this->userService->firstWhere(['phone' => $request->phone]);
            if (!$user) {
                DB::rollBack();

                return $this->response()->error(__('Unknown entry.'));
            }
            $this->resetPasswordService->create( $this->resetPasswordService->resetPasswordDataFormatter($user->id, $randNo));
            $this->_resetPasswordCodeSender( $user->first_name.' '.$user->last_name, $user->phone,$randNo);
            DB::commit();

            return $this->response()->success(__("Password Reset Code has been sent to ".$user->phone.'.'));
        } catch (Exception $exception) {
            DB::rollBack();

            return $this->response()->error( $exception->getMessage());
        }
    }

    /**
     * @param object $request
     * @return array
     */
    public function resetPasswordProcess (object $request): array
    {
        try {
            DB::beginTransaction();
            $user = $this->userService->firstWhere(['phone' => $request->phone]);
            $passwordReset = $user ? $this->resetPasswordService->firstWhere(['user_id' => $user->id, 'code' => $request->code]) : null;
            if (!$passwordReset){
                DB::rollBack();

                return $this->response()->error(__('Wrong entry'));
            }
            $this->resetPasswordService->deleteWhere(['user_id' => $user->id]);
            $this->userService->resetPassword( $user->id, $request->password);
            DB::commit();

            return $this->response()->success(__("Password Reset Successful."));

        } catch (Exception $exception) {
            DB::rollBack();

            return $this->response()->error( $exception->getMessage());
        }
    }

    /**
     * @param string $requestType
     * @return array
     */
    public function logoutProcess(string $requestType='api'): array
    {
        try {
            if(Auth::user()){
                $requestType=='api' ?
                    Auth::user()->token()->revoke() :
                    Auth::logout();

                return $this->response()->success('Logged Out Successfully');
            } else {
                return $this->response()->error('Already Logged Out.');
            }
        } catch (Exception $exception) {
            return $this->response()->error( $exception->getMessage());
        }
    }

    /**
     * @param string $name
     * @param string $phone
     * @param string $code
     * @throws ConfigurationException
     * @throws TwilioException
     */
    private function _phoneVerificationCodeSender (string $name, string $phone, string $code)
    {
        sendSMS('Dear '.$name.', You Verification Code Is :'.$code, '+88'.$phone);
    }

    /**
     * @param string $name
     * @param string $email
     * @param string $code
     */
    private function _emailVerificationCodeSender (string $name, string $email, string $code)
    {
        $data = array('name'=> $name, 'code' => $code);
        Mail::send('email.auth.verification', $data, function($message) use ($name, $email) {
            $message->to( $email, $name)
                ->subject('Email Verification');
            $message->from('talkiyon@example.com', 'Talkiyon');
        });
    }

    /**
     * @param string $name
     * @param string $phone
     * @param string $code
     * @throws ConfigurationException
     * @throws TwilioException
     */
    private function _resetPasswordCodeSender (string $name, string $phone, string $code)
    {
        sendSMS('Dear '.$name.', You Password Reset Code Is :'.$code, '+88'.$phone);
    }

    /**
     * @param object $user
     * @return array
     */
    private function _authorize (object $user): array
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
    private function _authData (object $user, array $authorization): array
    {
        return [
            'authorization' => $authorization,
            'user_info' => [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'username' => $user->username,
                'is_phone_verified' => $user->is_phone_verified,
                'role' => $user->role,
            ]
        ];
    }

    /**
     * @param array $data
     * @return array
     */
    private function _credentials (array $data) : array {
        if (isPhone($data['phone'])){
            return [
                'phone' => $data['phone'],
                'password' => $data['password']
            ];
        }
        return filter_var( $data['phone'], FILTER_VALIDATE_EMAIL) ? [
            'email' => $data['phone'],
            'password' => $data['password']
        ] : [
            'username' => $data['phone'],
            'password' => $data['password']
        ];
    }
}
