<?php


namespace App\Http\Services\User;

use App\Http\Services\Base\ConnectionService;
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
     * @var ConnectionService
     */
    private $connectionService;

    /**
     * ProfileService constructor.
     * @param UserService $userService
     * @param StudentInfoService $studentInfoService
     * @param ConnectionService $connectionService
     */
    public function __construct (UserService $userService, StudentInfoService $studentInfoService, ConnectionService $connectionService)
    {
        $this->userService = $userService;
        $this->studentInfoService = $studentInfoService;
        $this->connectionService = $connectionService;
    }

    /**
     * @return array
     */
    public function helpers (): array
    {
        return $this->response([
            'avatar_view_path' => asset(avatarViewPath()),
            'connection_types' => connectionTypes(),
            'connection_statuses' => connectionStatuses()
        ])->success();
    }

    /**
     * @return array
     */
    public function info (): array
    {
        try {
            $student = $this->userService->firstWhere(['id' => Auth::id()], ['id', 'first_name', 'last_name', 'email', 'username', 'phone', 'role', 'gender', 'is_phone_verified', 'image'])->toArray();
            $student = array_merge($student, $this->studentInfoService->firstWhere(['user_id' => $student['id']], ['date_of_birth', 'introduction', 'about'])->toArray());
            $student['id'] = encrypt($student['id']);

            return $this->response( $student)->success();
        } catch (Exception $exception) {
            return $this->response()->error( $exception->getMessage());
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

            return $this->response()->error( $exception->getMessage());
        }
    }

    /**
     * @param object $request
     * @return array
     */
    public function saveAbout (object $request): array
    {
        try {
            $about = $this->studentInfoService->lastWhere(['user_id' => Auth::id()])->about;
            $this->studentInfoService->updateWhere(['user_id' => Auth::id()], ['about' => $request->about]);

            return $this->response()->success(__('About has been '.(!$about ? 'added' : 'updated').' successfully.'));
        } catch (Exception $exception) {
            return $this->response()->error( $exception->getMessage());
        }
    }

    /**
     * @param object $request
     * @return array
     */
    public function connectionSuggestions (object $request): array
    {
        try {
            $connections = $this->_connectionList(STATUS_PENDING, $request);

            return $this->response($connections)->success();
        } catch (Exception $exception) {
            return $this->response()->error( $exception->getMessage());
        }
    }

    /**
     * @param object $request
     * @return array
     */
    public function sentRequests (object $request): array
    {
        try {
            $connections = $this->_connectionList(STATUS_PENDING, $request);

            return $this->response($connections)->success();
        } catch (Exception $exception) {
            return $this->response()->error( $exception->getMessage());
        }
    }

    /**
     * @param object $request
     * @return array
     */
    public function receivedRequests (object $request): array
    {
        try {
            $connections = $request->has('type') ?
                $this->connectionService->getWhere(['connected_with'=>Auth::id(), 'status'=>STATUS_PENDING, 'type'=>$request->type])->toArray():
                $this->connectionService->getWhere(['connected_with'=>Auth::id(), 'status'=>STATUS_PENDING])->toArray();
            $connections = $connections ? $connections : [];
            foreach ($connections as $key => $item) {
                $connections[$key]['id'] = encrypt($item['id']);
                $connections[$key]['sender'] = $this->userService->lastWhere(['id' => $item['user_id']], ['id', 'first_name', 'last_name', 'email', 'username', 'phone', 'role', 'gender', 'image'])->toArray();
                $connections[$key]['sender']['id'] = encrypt($connections[$key]['sender']['id']);
                $connections[$key]['user_id'] = $connections[$key]['connected_with'];
                $connections[$key]['connected_with'] = null;
            }

            return $this->response($connections)->success();
        } catch (Exception $exception) {
            return $this->response()->error( $exception->getMessage());
        }
    }

    /**
     * @param object $request
     * @return array
     */
    public function connections (object $request): array
    {
        try {
            $connections = $this->_connectionList(STATUS_ACTIVE, $request);

            return $this->response($connections)->success();
        } catch (Exception $exception) {
            return $this->response()->error( $exception->getMessage());
        }
    }

    /**
     * @param int $status
     * @param object $request
     * @return array
     */
    private function _connectionList (int $status, object $request): array
    {
        $connections = $request->has('type') ?
            $this->connectionService->getWhere(['user_id'=>Auth::id(), 'status'=>$status, 'type'=>$request->type])->toArray():
            $this->connectionService->getWhere(['user_id'=>Auth::id(), 'status'=>$status])->toArray();
        $connections = $connections ? $connections : [];
        foreach ($connections as $key => $item) {
            $connections[$key]['id'] = encrypt($item['id']);
            $connections[$key]['connected_with'] = $this->userService->lastWhere(['id' => $item['connected_with']], ['id', 'first_name', 'last_name', 'email', 'username', 'phone', 'role', 'gender', 'image'])->toArray();
            $connections[$key]['connected_with']['id'] = encrypt($connections[$key]['connected_with']['id']);
        }

        return $connections;
    }

    /**
     * @param object $request
     * @return array
     */
    public function sendRequest (object $request): array
    {
        try {
            $this->connectionService->create( $this->connectionService->connectionDataFormatter( Auth::id(), $request->only('connected_with', 'type')));

            return $this->response()->success(__('Connection Request has been sent successfully.'));
        } catch (Exception $exception) {
            return $this->response()->error( $exception->getMessage());
        }
    }

    /**
     * @param object $request
     * @return array
     */
    public function acceptRequest (object $request): array
    {
        try {
            DB::beginTransaction();
            $this->connectionService->create( $this->connectionService->connectionDataFormatter( Auth::id(), $request->only('connected_with', 'type')));
            $this->connectionService->updateWhere( ['user_id' => Auth::id()], ['status' => STATUS_ACTIVE]);
            $this->connectionService->updateWhere( ['connected_with' => Auth::id()], ['status' => STATUS_ACTIVE]);
            DB::commit();

            return $this->response()->success(__('Connection Request has been accepted successfully.'));
        } catch (Exception $exception) {
            DB::rollBack();

            return $this->response()->error( $exception->getMessage());
        }
    }
}
