<?php


namespace App\Http\Services\Student;

use App\Http\Services\Base\StudentInfoService;
use App\Http\Services\Base\UserService;
use App\Http\Services\ResponseService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            $student = $this->userService->firstWhere(['id' => Auth::id()], ['id', 'first_name', 'last_name', 'email', 'username', 'phone', 'role', 'gender', 'is_phone_verified', 'image'])->toArray();
            $student = array_merge($student, $this->studentInfoService->firstWhere(['user_id' => $student], ['date_of_birth', 'introduction', 'about'])->toArray());
            $student['id'] = encrypt($student['id']);

            return $this->response($student)->success();
        } catch (Exception $exception) {
            return $this->response()->error($exception->getMessage());
        }
    }

    /**
     * @param object $request
     * @return array
     */
    public function saveImage (object $request): array
    {
        try {
            DB::beginTransaction();
            $image = Auth::user()->image;
            $this->userService->updateWhere(['id' => Auth::id()], ['image' => uploadFile( $request->image, avatarPath(), $image)]);
            DB::commit();

            return $this->response()->success(__('Image has been '.(!$image ? 'added' : 'updated').' successfully.'));
        } catch (Exception $exception) {
            DB::rollBack();

            return $this->response()->error($exception->getMessage());
        }
    }
}
