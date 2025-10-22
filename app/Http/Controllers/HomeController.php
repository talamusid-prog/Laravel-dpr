<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Aspiration;
use App\Models\Gallery;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        // Get latest articles for carousel
        $articles = Article::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($article) {
                return [
                    'id' => $article->id,
                    'title' => $article->title,
                    'excerpt' => $article->excerpt,
                    'slug' => $article->slug,
                    'published_at' => $article->published_at,
                ];
            });

        // Get popular posts for blog section
        $posts = Article::where('status', 'published')
            ->orderBy('views', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($article) {
                return [
                    'id' => $article->id,
                    'title' => $article->title,
                    'slug' => $article->slug,
                    'published_at' => $article->published_at,
                    'featured_image_url' => $article->featured_image ? asset('storage/' . $article->featured_image) : null,
                ];
            });

        // Fetch real aspirations data from database
        $aspirations = Aspiration::orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($aspiration) {
                return [
                    'id' => $aspiration->id,
                    'title' => $aspiration->title,
                    'description' => $aspiration->description,
                    'category' => $aspiration->category,
                    'status' => $aspiration->status,
                    'created_at' => $aspiration->created_at->format('Y-m-d'),
                ];
            });

        // Get gallery items for documentation section
        $galleryItems = Gallery::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get()
            ->map(function ($gallery) {
                return [
                    'id' => $gallery->id,
                    'title' => $gallery->title,
                    'description' => $gallery->description,
                    'image' => $gallery->image ? asset('storage/' . $gallery->image) : null,
                    'category' => $gallery->category,
                    'created_at' => $gallery->created_at->format('Y-m-d'),
                ];
            });

        // Debug: Log aspirations data
        \Log::info('Aspirations data:', $aspirations->toArray());
        
        // Debug: Log gallery data
        \Log::info('Gallery data:', $galleryItems->toArray());

        return Inertia::render('Home', [
            'articles' => $articles,
            'posts' => $posts,
            'aspirations' => $aspirations,
            'galleryItems' => $galleryItems,
        ]);
    }
}
