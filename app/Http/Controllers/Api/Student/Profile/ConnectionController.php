<?php

namespace App\Http\Controllers\Api\Student\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Profile\ConnectionRequest;
use App\Http\Requests\Request;
use App\Http\Services\User\ProfileService;
use Illuminate\Http\JsonResponse;

class ConnectionController extends Controller
{
    /**
     * @var ProfileService
     */
    private $service;

    /**
     * ConnectionController constructor.
     * @param ProfileService $service
     */
    public function __construct (ProfileService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function suggestions (Request $request): JsonResponse
    {
        return response()->json( $this->service->connectionSuggestions( $request));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function sentRequests (Request $request): JsonResponse
    {
        return response()->json( $this->service->sentRequests( $request));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function receivedRequests (Request $request): JsonResponse
    {
        return response()->json( $this->service->receivedRequests( $request));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function connections (Request $request): JsonResponse
    {
        return response()->json( $this->service->connections( $request));
    }

    /**
     * @param ConnectionRequest $request
     * @return JsonResponse
     */
    public function sendRequest (ConnectionRequest $request): JsonResponse
    {
        return response()->json( $this->service->sendRequest( $request));
    }

    /**
     * @param ConnectionRequest $request
     * @return JsonResponse
     */
    public function acceptRequest (ConnectionRequest $request): JsonResponse
    {
        return response()->json( $this->service->acceptRequest( $request));
    }
}
