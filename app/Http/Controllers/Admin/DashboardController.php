<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\News;
use App\Models\Catalog;
use App\Models\Gallery;
use App\Models\Report;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
