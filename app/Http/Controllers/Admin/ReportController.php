<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visitor;
use App\Models\ContactMessage;
use App\Models\Service;
use App\Models\Activity;
use App\Models\Page;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // Visitors Chart Data (Last 7 Days)
        $visitorsData = Visitor::select(DB::raw('DATE(visited_at) as date'), DB::raw('count(*) as count'))
            ->where('visited_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $visitorDates = $visitorsData->pluck('date');
        $visitorCounts = $visitorsData->pluck('count');

        // Content Statistics
        $stats = [
            'services' => Service::count(),
            'activities' => Activity::count(),
            'pages' => Page::count(),
            'messages' => ContactMessage::count(),
            'today_visitors' => Visitor::whereDate('visited_at', Carbon::today())->count(),
        ];

        // Top Visited Pages
        $topPages = Visitor::select('page_url', DB::raw('count(*) as count'))
            ->groupBy('page_url')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        return view('admin.reports.index', compact('visitorDates', 'visitorCounts', 'stats', 'topPages'));
    }
}
