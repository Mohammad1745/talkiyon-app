<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Admin\DashboardService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    /**
     * @var DashboardService
     */
    private $service;

    /**
     * AuthController constructor.
     * @param DashboardService $service
     */
    public function __construct (DashboardService $service)
    {
        $this->service = $service;
    }

    /**
     * @return Application|Factory|View
     */
    public function dashboard ()
    {
        return view('admin.dashboard');
    }

    /**
     * @return JsonResponse
     */
    public function content (): JsonResponse
    {
        return response()->json( $this->service->content());
    }
}
