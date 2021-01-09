<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\Api\LoginRequest;
use App\Http\Services\AuthService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
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
     * @return Application|Factory|View
     */
    public function login ()
    {
        return view('auth.login');
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function loginProcess (LoginRequest $request): JsonResponse
    {
        return response()->json( $this->authService->loginProcess( $request));
    }

    /**
     * @return JsonResponse
     */
    public function logout (): JsonResponse
    {
        return response()->json( $this->authService->logoutProcess());
    }


}
