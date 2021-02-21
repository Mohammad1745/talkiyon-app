<?php

namespace App\Http\Controllers\Api\Student\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Profile\ConnectionRequest;
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
     * @return JsonResponse
     */
    public function index (): JsonResponse
    {
        return response()->json( $this->service->connections());
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
