<?php


namespace App\Http\Services\Student;

use App\Http\Services\Base\TalkService;
use App\Http\Services\Base\UserService;
use App\Http\Services\ResponseService;
use Exception;

class TimeLineService extends ResponseService
{
    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var TalkService
     */
    private $talkService;

    /**
     * TimeLineService constructor.
     * @param UserService $userService
     * @param TalkService $talkService
     */
    public function __construct (UserService $userService, TalkService $talkService)
    {
        $this->userService = $userService;
        $this->talkService = $talkService;
    }

    /**
     * @param object $request
     * @return array
     */
    public function present (object $request): array
    {
        try {
            $this->talkService->create($this->talkService->talkDataFormatter($request->all()));

            return $this->response()->success(__('Talk has been released successfully.'));
        } catch (Exception $exception) {
            return $this->response()->error( $exception->getMessage());
        }
    }
}
