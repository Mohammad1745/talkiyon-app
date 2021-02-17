<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\Auth\CheckResetPasswordCodeRequest;
use App\Http\Requests\Api\Auth\EmailVerificationRequest;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\PhoneVerificationRequest;
use App\Http\Requests\Api\Auth\ResetPasswordRequest;
use App\Http\Requests\Api\Auth\SendResetPasswordCodeRequest;
use App\Http\Requests\Api\Auth\SignupRequest;
use App\Http\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * @var AuthService
     */
    private $service;

    /**
     * AuthController constructor.
     * @param AuthService $service
     */
    public function __construct (AuthService $service)
    {
        $this->service = $service;
    }

    /**
     * @return JsonResponse
     */
    public function helpers (): JsonResponse
    {
        return response()->json( $this->service->helpers());
    }

    /**
     * @param SignupRequest $request
     * @return JsonResponse
     */
    public function signup (SignupRequest $request): JsonResponse
    {
        return response()->json( $this->service->signupProcess( $request));
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login (LoginRequest $request): JsonResponse
    {
        return response()->json( $this->service->loginProcess( $request));
    }

    /**
     * @return JsonResponse
     */
    public function resendEmailVerificationCode (): JsonResponse
    {
        return response()->json( $this->service->resendEmailVerificationCodeProcess());
    }

    /**
     * @param EmailVerificationRequest $request
     * @return JsonResponse
     */
    public function emailVerification (EmailVerificationRequest $request): JsonResponse
    {
        return response()->json( $this->service->emailVerificationProcess( $request));
    }

    /**
     * @return JsonResponse
     */
    public function resendPhoneVerificationCode (): JsonResponse
    {
        return response()->json( $this->service->resendPhoneVerificationCodeProcess());
    }

    /**
     * @param PhoneVerificationRequest $request
     * @return JsonResponse
     */
    public function phoneVerification (PhoneVerificationRequest $request): JsonResponse
    {
        return response()->json( $this->service->phoneVerificationProcess( $request));
    }

    /**
     * @param SendResetPasswordCodeRequest $request
     * @return JsonResponse
     */
    public function sendResetPasswordCode (SendResetPasswordCodeRequest $request): JsonResponse
    {
        return response()->json( $this->service->sendResetPasswordCodeProcess( $request));
    }

    /**
     * @param CheckResetPasswordCodeRequest $request
     * @return JsonResponse
     */
    public function checkResetPasswordCode (CheckResetPasswordCodeRequest $request): JsonResponse
    {
        return response()->json( $this->service->checkResetPasswordCodeProcess( $request));
    }

    /**
     * @param ResetPasswordRequest $request
     * @return JsonResponse
     */
    public function resetPassword (ResetPasswordRequest $request): JsonResponse
    {
        return response()->json( $this->service->resetPasswordProcess( $request));
    }

    /**
     * @return JsonResponse
     */
    public function logout (): JsonResponse
    {
        return response()->json( $this->service->logoutProcess());
    }


}
