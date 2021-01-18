<?php


namespace App\Http\Services\Student;

use App\Http\Services\Base\StudentInfoService;
use App\Http\Services\Base\UserService;
use App\Http\Services\ResponseService;
use Exception;
use Illuminate\Support\Facades\Auth;

class ProfileService extends ResponseService
{
    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var StudentInfoService
     */
    private $studentInfoService;

    /**
     * DashboardService constructor.
     * @param UserService $userService
     * @param StudentInfoService $studentInfoService
     */
    public function __construct (UserService $userService, StudentInfoService $studentInfoService)
    {
        $this->userService = $userService;
        $this->studentInfoService = $studentInfoService;
    }

    /**
     * @return array
     */
    public function info (): array
    {
        try {
            $student = $this->userService->firstWhere(['id' => Auth::id()])->toArray();
            $student['info'] = $this->studentInfoService->firstWhere(['user_id' => $student]);
            $student['id'] = encrypt($student['id']);

            return $this->response($student)->success();
        } catch (Exception $exception) {
            return $this->response()->error($exception->getMessage());
        }
    }
}
