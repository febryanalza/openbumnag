<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Catalog;
use App\Models\Gallery;
use App\Models\News;
use App\Models\Report;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => User::count(),
            'news' => News::count(),
            'catalogs' => Catalog::count(),
            'galleries' => Gallery::count(),
            'reports' => Report::count(),
        ];

        $recentNews = News::latest()->take(5)->get();
        $recentReports = Report::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentNews', 'recentReports'));
    }
}
