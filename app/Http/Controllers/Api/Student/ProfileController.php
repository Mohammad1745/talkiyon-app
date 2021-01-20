<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ProfileImageRequest;
use App\Http\Services\Student\ProfileService;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    /**
     * @var ProfileService
     */
    private $service;

    /**
     * AuthController constructor.
     * @param ProfileService $service
     */
    public function __construct (ProfileService $service)
    {
        $this->service = $service;
    }

    /**
     * @return JsonResponse
     */
    public function info (): JsonResponse
    {
        return response()->json( $this->service->info());
    }

    /**
     * @param ProfileImageRequest $request
     * @return JsonResponse
     */
    public function saveImage (ProfileImageRequest $request): JsonResponse
    {
        return response()->json( $this->service->saveImage( $request));
    }
}
