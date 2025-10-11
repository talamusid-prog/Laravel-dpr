<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Aspiration;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\Analytic;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $stats = [
            'total_articles' => Article::count(),
            'published_articles' => Article::published()->count(),
            'draft_articles' => Article::draft()->count(),
            'total_views' => Article::sum('views'),
            'new_aspirations' => Aspiration::new()->count(),
            'upcoming_events' => Event::upcoming()->count(),
            'total_galleries' => Gallery::count(),
        ];

        $recentPosts = Article::latest()
            ->limit(5)
            ->get(['id', 'title', 'status', 'views', 'created_at']);

        $recentAspirations = Aspiration::latest()
            ->limit(5)
            ->get(['id', 'title', 'status', 'submitter_name', 'created_at']);

        $upcomingEvents = Event::upcoming()
            ->orderBy('start_date')
            ->limit(5)
            ->get(['id', 'title', 'type', 'start_date', 'location']);

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats,
            'recentPosts' => $recentPosts,
            'recentAspirations' => $recentAspirations,
            'upcomingEvents' => $upcomingEvents,
        ]);
    }
}
