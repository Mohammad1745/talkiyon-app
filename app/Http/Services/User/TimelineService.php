<?php


namespace App\Http\Services\User;

use App\Http\Services\Base\TalkBooService;
use App\Http\Services\Base\TalkClapService;
use App\Http\Services\Base\TalkFileService;
use App\Http\Services\Base\TalkResponseBooService;
use App\Http\Services\Base\TalkResponseClapService;
use App\Http\Services\Base\TalkResponseFileService;
use App\Http\Services\Base\TalkResponseService;
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
     * @var TalkClapService
     */
    private $talkClapService;
    /**
     * @var TalkBooService
     */
    private $talkBooService;
    /**
     * @var TalkResponseService
     */
    private $talkResponseService;
    /**
     * @var TalkResponseFileService
     */
    private $talkResponseFileService;
    /**
     * @var TalkResponseClapService
     */
    private $talkResponseClapService;
    /**
     * @var TalkResponseBooService
     */
    private $talkResponseBooService;

    /**
     * TimelineService constructor.
     * @param UserService $userService
     * @param TalkService $talkService
     * @param TalkFileService $talkFileService
     * @param TalkClapService $talkClapService
     * @param TalkBooService $talkBooService
     * @param TalkResponseService $talkResponseService
     * @param TalkResponseFileService $talkResponseFileService
     * @param TalkResponseClapService $talkResponseClapService
     * @param TalkResponseBooService $talkResponseBooService
     */
    public function __construct (UserService $userService, TalkService $talkService, TalkFileService $talkFileService, TalkClapService $talkClapService,
                                 TalkBooService $talkBooService, TalkResponseService $talkResponseService, TalkResponseFileService $talkResponseFileService,
                                 TalkResponseClapService $talkResponseClapService, TalkResponseBooService $talkResponseBooService)
    {
        $this->userService = $userService;
        $this->talkService = $talkService;
        $this->talkFileService = $talkFileService;
        $this->talkClapService = $talkClapService;
        $this->talkBooService = $talkBooService;
        $this->talkResponseService = $talkResponseService;
        $this->talkResponseFileService = $talkResponseFileService;
        $this->talkResponseClapService = $talkResponseClapService;
        $this->talkResponseBooService = $talkResponseBooService;
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

    /**
     * @param object $request
     * @return array
     */
    public function clap (object $request): array
    {
        try {
            $talk = $this->talkService->lastWhere(['id' => decrypt($request->talk_id), 'user_id' => Auth::id()]);
            if (!$talk) {
                return $this->response()->error( __('Talk not found'));
            }
            $clap = $this->talkClapService->lastWhere(['user_id' => Auth::id()]);
            if($clap){
                $this->talkClapService->deleteWhere(['id' => $clap->id]);

                return $this->response()->success(__('Clap removed from the talk.'));
            }
            DB::beginTransaction();
            $this->talkClapService->create($this->talkClapService->talkClapDataFormatter($request->only('talk_id')));
            $this->talkBooService->deleteWhere(['talk_id' => decrypt($request->talk_id)]);
            DB::commit();

            return $this->response()->success(__('Clapped for the talk.'));
        } catch (Exception $exception) {
            DB::rollBack();

            return $this->response()->error( $exception->getMessage());
        }
    }

    /**
     * @param object $request
     * @return array
     */
    public function boo (object $request): array
    {
        try {
            $talk = $this->talkService->lastWhere(['id' => decrypt($request->talk_id), 'user_id' => Auth::id()]);
            if (!$talk) {
                return $this->response()->error( __('Talk not found'));
            }
            $boo = $this->talkBooService->lastWhere(['user_id' => Auth::id()]);
            if($boo){
                $this->talkBooService->deleteWhere(['id' => $boo->id]);

                return $this->response()->success(__('Boo removed from the talk.'));
            }
            DB::beginTransaction();
            $this->talkBooService->create($this->talkBooService->talkBooDataFormatter($request->only('talk_id')));
            $this->talkClapService->deleteWhere(['talk_id' => decrypt($request->talk_id)]);
            DB::commit();

            return $this->response()->success(__('Booed for the talk.'));
        } catch (Exception $exception) {
            DB::rollBack();

            return $this->response()->error( $exception->getMessage());
        }
    }

    /**
     * @param object $request
     * @return array
     */
    public function respond (object $request): array
    {
        try {
            $talkResponse = $this->talkService->lastWhere(['id' => decrypt($request->talk_id)]);
            if (!$talkResponse) {
                return $this->response()->error( __('Talk not found'));
            }
            DB::beginTransaction();
            $talkResponse = $this->talkResponseService->create( $this->talkResponseService->talkResponseDataFormatter($request->all()));
            if ($request->has(['files'])) {
                foreach ($request->all()['files'] as $file) {
                    $this->talkResponseFileService->create( $this->talkResponseFileService->talkResponseFileDataFormatter( $talkResponse->id, ['file' => uploadFile( $file, timelinePath())]));
                }
            }
            DB::commit();

            return $this->response()->success(__('Responded to the Talk.'));
        } catch (Exception $exception) {
            DB::rollBack();

            return $this->response()->error( $exception->getMessage());
        }
    }
}
