<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ReleaseTalkRequest;
use App\Http\Services\Student\TimeLineService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TimeLineController extends Controller
{

    /**
     * @var TimeLineService
     */
    protected $service;

    /**
     * TimeLineController constructor.
     * @param TimeLineService $service
     */
    public function __construct (TimeLineService $service)
    {
        $this->service = $service;
    }

    /**
     * @param ReleaseTalkRequest $request
     * @return JsonResponse
     */
    public function present (ReleaseTalkRequest $request): JsonResponse
    {
        return response()->json( $this->service->present( $request));
    }
}
