<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\SignupRequest;
use App\Http\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
    public function __construct(AuthService $service) {
        $this->authService = $service;
    }

    /**
     * @param SignupRequest $request
     * @return JsonResponse
     */
    public function signup(SignupRequest $request): JsonResponse
    {
        return response()->json($this->authService->signupProcess($request));
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        return response()->json( $this->authService->loginProcess($request));
    }

    /**
     * @return JsonResponse
     */
    public function resendEmailVerificationCode(): JsonResponse
    {
        return response()->json( $this->authService->resendEmailVerificationCodeProcess());
    }

//    /**
//     * @return JsonResponse
//     */
//    public function emailVerification(): JsonResponse
//    {
//        return response()->json( $this->authService->emailVerificationProcess());
//    }

//    /**
//     * @param PhoneVerificationRequest $request
//     * @return JsonResponse
//     */
//    public function phoneVerificationProcess(PhoneVerificationRequest $request) {
//        $response = $this->authService->phoneVerify($request);
//        return response()->json($response);
//    }
//
//    /**
//     * @return JsonResponse
//     */
//    public function resendPhoneVerificationCode() {
//        $response = $this->authService->resendPhoneVerificationCode();
//        return response()->json($response);
//    }
//
//    /**
//     * @param ForgetPasswordRequest $request
//     * @return JsonResponse
//     */
//    public function forgetPasswordSendCode(ForgetPasswordRequest $request) {
//        $response = $this->authService->sendForgetPasswordCode($request);
//        return response()->json($response);
//    }
//
//    /**
//     * @param ForgetPasswordCodeSubmitRequest $request
//     * @return JsonResponse
//     */
//    public function resetPasswordCode(ForgetPasswordCodeSubmitRequest $request) {
//        $response = $this->authService->forgetPasswordCodeSubmit($request);
//        return response()->json($response);
//    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout (Request $request) {
        $request->user()->token()->revoke();
        return response()->json([
            'success' => true,
            'message' => __('Successfully logged out')
        ]);
    }


}
