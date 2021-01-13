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

    /**
     * @return array
     */
    public function content (): array
    {
        try {
            $data['student_count'] = $this->userService->countWhere(['role' => STUDENT_ROLE]);
            $data['teacher_count'] = $this->userService->countWhere(['role' => TEACHER_ROLE]);

            return $this->response($data)->success();
        } catch (Exception $exception) {
            return $this->response()->error($exception->getMessage());
        }
    }
}
