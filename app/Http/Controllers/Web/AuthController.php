<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\Web\LoginRequest;
use App\Http\Requests\Web\ResetPasswordRequest;
use App\Http\Requests\Web\SendResetPasswordCodeRequest;
use App\Http\Services\Auth\AuthService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

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
     * @return Application|Factory|View
     */
    public function login ()
    {
        return view('auth.login');
    }

    /**
     * @param LoginRequest $request
     * @return RedirectResponse
     */
    public function loginProcess (LoginRequest $request): RedirectResponse
    {
        return $this->webResponse( $this->service->loginProcess( $request, 'web'), 'admin.dashboard');
    }

    /**
     * @return Application|Factory|View
     */
    public function sendResetPasswordCode ()
    {
        return view('auth.send-reset-password-code');
    }

    /**
     * @param SendResetPasswordCodeRequest $request
     * @return RedirectResponse
     */
    public function sendResetPasswordCodeProcess (SendResetPasswordCodeRequest $request): RedirectResponse
    {
        return $this->webResponse( $this->service->sendResetPasswordCodeProcess( $request), 'resetPassword');
    }

    /**
     * @return Application|Factory|View
     */
    public function resetPassword ()
    {
        return view('auth.reset-password');
    }

    /**
     * @param ResetPasswordRequest $request
     * @return RedirectResponse
     */
    public function resetPasswordProcess (ResetPasswordRequest $request): RedirectResponse
    {
        return $this->webResponse( $this->service->resetPasswordProcess( $request), 'login');
    }

    /**
     * @return RedirectResponse
     */
    public function logout (): RedirectResponse
    {
        return $this->webResponse( $this->service->logoutProcess('web'), 'login');
    }


}
