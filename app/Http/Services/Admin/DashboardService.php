<?php


namespace App\Http\Services\Admin;

use App\Http\Services\Base\ResetPasswordService;
use App\Http\Services\Base\StudentInfoService;
use App\Http\Services\Base\UserService;
use App\Http\Services\ResponseService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;

class DashboardService extends ResponseService
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * DashboardService constructor.
     * @param UserService $userService
     */
    public function __construct (UserService $userService)
    {
        $this->userService = $userService;
    }
}
