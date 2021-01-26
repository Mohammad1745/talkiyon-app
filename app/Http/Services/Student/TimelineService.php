<?php


namespace App\Http\Services\Student;

use App\Http\Services\Base\TalkFileService;
use App\Http\Services\Base\TalkService;
use App\Http\Services\Base\UserService;
use App\Http\Services\ResponseService;
use Exception;

class TimelineService extends ResponseService
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
     * @var TalkFileService
     */
    private $talkFileService;

    /**
     * TimelineService constructor.
     * @param UserService $userService
     * @param TalkService $talkService
     * @param TalkFileService $talkFileService
     */
    public function __construct (UserService $userService, TalkService $talkService, TalkFileService $talkFileService)
    {
        $this->userService = $userService;
        $this->talkService = $talkService;
        $this->talkFileService = $talkFileService;
    }

    /**
     * @param object $request
     * @return array
     */
    public function present (object $request): array
    {
        try {
            $this->talkService->create( $this->talkService->talkDataFormatter($request->all()));
            foreach ($request->all()['files'] as $file) {
                $this->talkFileService->create( $this->talkFileService->talkFileDataFormatter(['file' => uploadFile( $file, timelinePath())]));
            }

            return $this->response()->success(__('Talk has been presented successfully.'));
        } catch (Exception $exception) {
            return $this->response()->error( $exception->getMessage());
        }
    }
}
