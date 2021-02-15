<?php


namespace App\Http\Services\Student;

use App\Http\Services\Base\TalkFileService;
use App\Http\Services\Base\TalkService;
use App\Http\Services\Base\UserService;
use App\Http\Services\ResponseService;
use Exception;
use Illuminate\Support\Facades\Auth;

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
     * @return array
     */
    public function helpers (): array
    {
        return $this->response([
            'type' => talkTypes(),
            'security_type' => talkSecurityTypes(),
            'timeline_view_path' => asset(timelineViewPath())
        ])->success();
    }

    /**
     * @param object $request
     * @return array
     */
    public function present (object $request): array
    {
        try {
            $talk = $this->talkService->create( $this->talkService->talkDataFormatter( Auth::id(), $request->all()));
            if ($request->has(['files'])) {
                foreach ($request->all()['files'] as $file) {
                    $this->talkFileService->create( $this->talkFileService->talkFileDataFormatter( $talk->id, ['file' => uploadFile( $file, timelinePath())]));
                }
            }

            return $this->response()->success(__('Talk has been presented successfully.'));
        } catch (Exception $exception) {
            return $this->response()->error( $exception->getMessage());
        }
    }
}
