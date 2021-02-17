<?php

namespace App\Http\Controllers\Api\Student\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Profile\ProfileAboutRequest;
use App\Http\Requests\Api\Profile\ProfileImageRequest;
use App\Http\Services\User\ProfileService;
use Illuminate\Http\JsonResponse;

class InformationController extends Controller
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
    public function helpers (): JsonResponse
    {
        return response()->json( $this->service->helpers());
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

    /**
     * @param ProfileAboutRequest $request
     * @return JsonResponse
     */
    public function saveAbout (ProfileAboutRequest $request): JsonResponse
    {
        return response()->json( $this->service->saveAbout( $request));
    }
}
