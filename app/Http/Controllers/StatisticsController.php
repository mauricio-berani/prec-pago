<?php

namespace App\Http\Controllers;

use App\Services\StatisticsService;
use Illuminate\Http\JsonResponse;

class StatisticsController extends Controller
{
    public function __construct(protected StatisticsService $service) {}

    public function getLast(): JsonResponse
    {
        $statistics = $this->service->getStatistics();

        return response()->json($statistics);
    }
}
