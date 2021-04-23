<?php

namespace App\Http\Controllers\Api\Student\Timeline;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Timeline\PresentTalkRequest;
use App\Http\Requests\Api\Timeline\RespondTalkRequest;
use App\Http\Requests\Api\Timeline\UpdateResponseRequest;
use App\Http\Requests\Api\Timeline\UpdateTalkRequest;
use App\Http\Services\User\TimelineService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TalkController extends Controller
{

    /**
     * @var TimelineService
     */
    protected $service;

    /**
     * TalkController constructor.
     * @param TimelineService $service
     */
    public function __construct (TimelineService $service)
    {
        $this->service = $service;
    }

    /**
     * @return JsonResponse
     */
    public function helpers (): JsonResponse
    {
        return response()->json( $this->service->helpers());
    }

    /**
     * @param PresentTalkRequest $request
     * @return JsonResponse
     */
    public function present (PresentTalkRequest $request): JsonResponse
    {
        return response()->json( $this->service->present( $request));
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json( $this->service->index());
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function read(Request $request): JsonResponse
    {
        return response()->json( $this->service->read( $request));
    }

    /**
     * @param UpdateTalkRequest $request
     * @return JsonResponse
     */
    public function update (UpdateTalkRequest $request): JsonResponse
    {
        return response()->json( $this->service->update( $request));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        return response()->json( $this->service->delete( $request));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function clap(Request $request): JsonResponse
    {
        return response()->json( $this->service->clap( $request));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function boo(Request $request): JsonResponse
    {
        return response()->json( $this->service->boo( $request));
    }

    /**
     * @param RespondTalkRequest $request
     * @return JsonResponse
     */
    public function respond(RespondTalkRequest $request): JsonResponse
    {
        return response()->json( $this->service->respond( $request));
    }

    /**
     * @param UpdateResponseRequest $request
     * @return JsonResponse
     */
    public function updateResponse(UpdateResponseRequest $request): JsonResponse
    {
        return response()->json( $this->service->updateResponse( $request));
    }
}
