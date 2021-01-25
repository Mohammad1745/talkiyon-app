<?php


namespace App\Http\Services\Student;

use App\Http\Services\Base\UserService;
use App\Http\Services\ResponseService;

class TalkService extends ResponseService
{
    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var \App\Http\Services\Base\TalkService
     */
    private $talkService;

    /**
     * TalkService constructor.
     * @param UserService $userService
     * @param \App\Http\Services\Base\TalkService $talkService
     */
    public function __construct (UserService $userService, \App\Http\Services\Base\TalkService $talkService)
    {
        $this->userService = $userService;
        $this->talkService = $talkService;
    }

    /**
     * @param object $request
     * @return array
     */
    public function release (object $request): array
    {
        try {
            $this->talkService->create($this->talkService->talkDataFormatter($request->all()));

            return $this->response()->success(__('Talk has been released successfully.'));
        } catch (\Exception $exception) {
            return $this->response()->error( $exception->getMessage());
        }
    }
}
