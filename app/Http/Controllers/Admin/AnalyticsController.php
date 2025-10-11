<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Analytic;
use App\Models\Article;
use App\Models\Aspiration;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AnalyticsController extends Controller
{
    public function index(Request $request): Response
    {
        // Get date range
        $startDate = $request->get('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));

        // Blog Analytics
        $blogStats = [
            'total_articles' => Article::count(),
            'published_articles' => Article::published()->count(),
            'total_views' => Article::sum('views'),
            'avg_views_per_article' => Article::avg('views') ?? 0,
            'most_viewed_article' => Article::orderBy('views', 'desc')->first(),
        ];

        // Aspirasi Analytics
        $aspirationStats = [
            'total_aspirations' => Aspiration::count(),
            'new_aspirations' => Aspiration::new()->count(),
            'processed_aspirations' => Aspiration::where('status', 'diproses')->count(),
            'completed_aspirations' => Aspiration::where('status', 'selesai')->count(),
            'response_rate' => Aspiration::whereNotNull('responded_at')->count() / max(Aspiration::count(), 1) * 100,
        ];

        // Page Analytics
        $pageAnalytics = Analytic::whereBetween('date', [$startDate, $endDate])
            ->selectRaw('page, SUM(views) as total_views, SUM(unique_visitors) as total_visitors, AVG(session_duration) as avg_duration')
            ->groupBy('page')
            ->orderBy('total_views', 'desc')
            ->get();

        // Daily Analytics
        $dailyAnalytics = Analytic::whereBetween('date', [$startDate, $endDate])
            ->selectRaw('date, SUM(views) as total_views, SUM(unique_visitors) as total_visitors')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Category Analytics for Aspirations
        $categoryAnalytics = Aspiration::selectRaw('category, COUNT(*) as count')
            ->groupBy('category')
            ->orderBy('count', 'desc')
            ->get();

        return Inertia::render('Admin/Analytics/Index', [
            'blogStats' => $blogStats,
            'aspirationStats' => $aspirationStats,
            'pageAnalytics' => $pageAnalytics,
            'dailyAnalytics' => $dailyAnalytics,
            'categoryAnalytics' => $categoryAnalytics,
            'dateRange' => [
                'start_date' => $startDate,
                'end_date' => $endDate,
            ],
        ]);
    }

    public function export(Request $request)
    {
        $startDate = $request->get('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));

        $analytics = Analytic::whereBetween('date', [$startDate, $endDate])
            ->with(['page'])
            ->get();

        // For now, return JSON - in production you might want to generate Excel/PDF
        return response()->json([
            'data' => $analytics,
            'date_range' => [
                'start_date' => $startDate,
                'end_date' => $endDate,
            ],
            'exported_at' => now(),
        ]);
    }
}
