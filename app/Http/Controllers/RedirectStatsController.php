<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RedirectLog;
use Carbon\Carbon;

class RedirectStatsController extends Controller
{
    public function stats(Request $request, $redirectId)
    {

        $totalAccesses = RedirectLog::where('redirect_id', $redirectId)->count();

        $uniqueAccesses = RedirectLog::where('redirect_id', $redirectId)->distinct('ip')->count('ip');

        $topReferrers = RedirectLog::where('redirect_id', $redirectId)
            ->groupBy('referer')
            ->orderByRaw('COUNT(*) DESC')
            ->take(5)
            ->get(['referer', \DB::raw('COUNT(*) as count')]);

        $last10DaysStats = RedirectLog::where('redirect_id', $redirectId)
            ->where('access_time', '>', Carbon::now()->subDays(10))
            ->groupBy('date')
            ->orderBy('date')
            ->get([
                \DB::raw('DATE(access_time) as date'),
                \DB::raw('COUNT(*) as total'),
                \DB::raw('COUNT(DISTINCT ip) as unique'),
            ]);

        return response()->json([
            'totalAccesses' => $totalAccesses,
            'uniqueAccesses' => $uniqueAccesses,
            'topReferrers' => $topReferrers,
            'last10DaysStats' => $last10DaysStats,
        ]);
    }
}

