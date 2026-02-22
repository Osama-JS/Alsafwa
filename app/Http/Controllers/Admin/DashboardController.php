<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Service;
use App\Models\ContactMessage;
use App\Models\Visitor;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'pages' => Page::count(),
            'services' => Service::count(),
            'messages' => ContactMessage::where('status', 'new')->count(),
            'visitors_today' => Visitor::whereDate('visited_at', today())->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
