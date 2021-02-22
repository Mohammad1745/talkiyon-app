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
    public function request (Request $request): JsonResponse
    {
        return response()->json( $this->service->connectionRequests( $request));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index (Request $request): JsonResponse
    {
        return response()->json( $this->service->connections( $request));
    }

    /**
     * @param ConnectionRequest $request
     * @return JsonResponse
     */
    public function create (ConnectionRequest $request): JsonResponse
    {
        return response()->json( $this->service->saveConnection( $request));
    }
}
