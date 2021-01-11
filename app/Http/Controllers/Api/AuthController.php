<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CheckResetPasswordCodeRequest;
use App\Http\Requests\Api\EmailVerificationRequest;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\PhoneVerificationRequest;
use App\Http\Requests\Api\ResetPasswordRequest;
use App\Http\Requests\Api\SendResetPasswordCodeRequest;
use App\Http\Requests\Api\SignupRequest;
use App\Http\Services\AuthService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * @var AuthService
     */
    private $authService;

    /**
     * AuthController constructor.
     * @param AuthService $service
     */
    public function __construct (AuthService $service)
    {
        $this->authService = $service;
    }

    /**
     * @param SignupRequest $request
     * @return JsonResponse
     */
    public function signup (SignupRequest $request): JsonResponse
    {
        return response()->json( $this->authService->signupProcess( $request));
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login (LoginRequest $request): JsonResponse
    {
        return response()->json( $this->authService->loginProcess( $request));
    }

    /**
     * @return JsonResponse
     */
    public function resendEmailVerificationCode (): JsonResponse
    {
        return response()->json( $this->authService->resendEmailVerificationCodeProcess());
    }

    /**
     * @param EmailVerificationRequest $request
     * @return JsonResponse
     */
    public function emailVerification (EmailVerificationRequest $request): JsonResponse
    {
        return response()->json( $this->authService->emailVerificationProcess( $request));
    }

    /**
     * @return JsonResponse
     */
    public function resendPhoneVerificationCode (): JsonResponse
    {
        return response()->json( $this->authService->resendPhoneVerificationCodeProcess());
    }

    /**
     * @param PhoneVerificationRequest $request
     * @return JsonResponse
     */
    public function phoneVerification (PhoneVerificationRequest $request): JsonResponse
    {
        return response()->json( $this->authService->phoneVerificationProcess( $request));
    }

    /**
     * @param SendResetPasswordCodeRequest $request
     * @return JsonResponse
     */
    public function sendResetPasswordCode (SendResetPasswordCodeRequest $request): JsonResponse
    {
        return response()->json( $this->authService->sendResetPasswordCodeProcess( $request));
    }

    /**
     * @param CheckResetPasswordCodeRequest $request
     * @return JsonResponse
     */
    public function checkResetPasswordCode (CheckResetPasswordCodeRequest $request): JsonResponse
    {
        return response()->json( $this->authService->checkResetPasswordCodeProcess( $request));
    }

    /**
     * @param ResetPasswordRequest $request
     * @return JsonResponse
     */
    public function resetPassword (ResetPasswordRequest $request): JsonResponse
    {
        return response()->json( $this->authService->resetPasswordProcess( $request));
    }

    /**
     * @return JsonResponse
     */
    public function logout (): JsonResponse
    {
        return response()->json( $this->authService->logoutProcess());
    }


}
