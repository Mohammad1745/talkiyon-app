<?php


namespace App\Http\Services\User;

use App\Http\Services\Base\TalkFileService;
use App\Http\Services\Base\TalkService;
use App\Http\Services\Base\UserService;
use App\Http\Services\ResponseService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            DB::beginTransaction();
            $talk = $this->talkService->create( $this->talkService->talkDataFormatter( Auth::id(), $request->all()));
            if ($request->has(['files'])) {
                foreach ($request->all()['files'] as $file) {
                    $this->talkFileService->create( $this->talkFileService->talkFileDataFormatter( $talk->id, ['file' => uploadFile( $file, timelinePath())]));
                }
            }
            DB::commit();

            return $this->response()->success(__('Talk has been presented successfully.'));
        } catch (Exception $exception) {
            DB::rollBack();

            return $this->response()->error( $exception->getMessage());
        }
    }

    /**
     * @return array
     */
    public function index (): array
    {
        try {
            $talks = $this->talkService->paginateWhere(['user_id'=>Auth::id()]);
            $talks->map(function ($item) {
                $item['files'] = $this->talkFileService->pluckWhere(['talk_id'=>$item['id']], 'file');
                $item["encrypted_id"] = encrypt($item['id']);
                $item["user_id"] = encrypt($item['user_id']);
                $item["id"] = null;
            });

            return $this->response($talks->toArray())->success();
        } catch (Exception $exception) {
            return $this->response()->error( $exception->getMessage());
        }
    }

    /**
     * @param object $request
     * @return array
     */
    public function read (object $request): array
    {
        try {
            $talk = $this->talkService->lastWhere(['id'=> decrypt($request->id), 'user_id'=>Auth::id()]);
            if (!$talk) {
                return $this->response()->error( __('Talk not found'));
            }
            $talk['encrypted_id'] = encrypt($talk['id']);
            $talk['files'] = $this->talkFileService->pluckWhere(['talk_id'=>$talk['id']], 'file');

            return $this->response($talk->toArray())->success();
        } catch (Exception $exception) {
            return $this->response()->error( $exception->getMessage());
        }
    }

    /**
     * @param object $request
     * @return array
     */
    public function update (object $request): array
    {
        try {
            DB::beginTransaction();
            $talk = $this->talkService->lastWhere(['id' => decrypt($request->id), 'user_id' => Auth::id()]);
            if (!$talk) {
                DB::rollBack();

                return $this->response()->error( __('Talk not found'));
            }
            $this->talkFileService->deleteWhere(['talk_id' => $talk->id]);
            $this->talkService->updateWhere(['id' => $talk->id], $this->talkService->talkDataFormatter( Auth::id(), $request->all()));
            if ($request->has(['files'])) {
                foreach ($request->all()['files'] as $file) {
                    $this->talkFileService->create( $this->talkFileService->talkFileDataFormatter( $talk->id, ['file' => uploadFile( $file, timelinePath())]));
                }
            }
            DB::commit();

            return $this->response()->success(__('Talk has been updated successfully.'));
        } catch (Exception $exception) {
            DB::rollBack();

            return $this->response()->error( $exception->getMessage());
        }
    }

    /**
     * @param object $request
     * @return array
     */
    public function delete (object $request): array
    {
        try {
            $talk = $this->talkService->lastWhere(['id' => decrypt($request->id), 'user_id' => Auth::id()]);
            if (!$talk) {
                return $this->response()->error( __('Talk not found'));
            }
            $this->talkService->deleteWhere(['id' => $talk->id]);

            return $this->response()->success(__('Talk has been deleted successfully.'));
        } catch (Exception $exception) {
            return $this->response()->error( $exception->getMessage());
        }
    }
}
