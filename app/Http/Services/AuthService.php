<?php


namespace App\Http\Services;

use App\Http\Requests\Api\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService extends Service
{
    /**
     * @param LoginRequest $request
     * @return array
     */
    public function loginProcess(LoginRequest $request): array
    {
        try {
            $user = User::where('email', $request->email)->first();//TODO: this will move to user service
            if(Hash::check($request->password, $user->password)){
                Auth::attempt([
                    'email' => $request->email,
                    'password' => $request->password
                ]);

                return $this->response()->success('Logged In Successfully');
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
