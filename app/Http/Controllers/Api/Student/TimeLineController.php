<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PresentTalkRequest;
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
     * @param PresentTalkRequest $request
     * @return JsonResponse
     */
    public function present (PresentTalkRequest $request): JsonResponse
    {
        return response()->json( $this->service->present( $request));
    }
}
