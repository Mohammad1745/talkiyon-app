<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ReleaseTalkRequest;
use App\Http\Services\Student\TalkService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TalkController extends Controller
{

    /**
     * @var TalkService
     */
    protected $service;

    /**
     * TalkController constructor.
     * @param TalkService $service
     */
    public function __construct (TalkService $service)
    {
        $this->service = $service;
    }

    /**
     * @param ReleaseTalkRequest $request
     * @return JsonResponse
     */
    public function release (ReleaseTalkRequest $request): JsonResponse
    {
        return response()->json( $this->service->release( $request));
    }
}
