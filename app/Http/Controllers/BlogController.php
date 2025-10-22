<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BlogController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Article::query()->where('status', 'published');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('excerpt', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        // Category filter
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        $articles = $query->latest('published_at')->get();

        // Transform articles to include proper image URLs
        $articles->transform(function ($article) {
            $article->featured_image_url = $article->featured_image ? asset('storage/' . $article->featured_image) : null;
            return $article;
        });

        $categories = Article::where('status', 'published')
            ->distinct()
            ->pluck('category')
            ->filter()
            ->values();

        return Inertia::render('Blog', [
            'articles' => $articles,
            'categories' => $categories,
            'filters' => $request->only(['search', 'category']),
        ]);
    }


    public function show(string $slug): Response
    {
        $article = Article::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Add featured image URL
        $article->featured_image_url = $article->featured_image ? asset('storage/' . $article->featured_image) : null;

        // Increment view count
        $article->increment('views');

        // Get popular articles (most viewed, excluding current)
        $popularPosts = Article::where('id', '!=', $article->id)
            ->where('status', 'published')
            ->orderBy('views', 'desc')
            ->limit(3)
            ->get();

        // Transform popular posts to include image URLs
        $popularPosts->transform(function ($post) {
            $post->featured_image_url = $post->featured_image ? asset('storage/' . $post->featured_image) : null;
            return $post;
        });

        // Get popular tags (most used tags across all articles)
        $popularTags = Article::where('status', 'published')
            ->get()
            ->pluck('tags')
            ->flatten()
            ->countBy()
            ->sortDesc()
            ->take(8)
            ->keys()
            ->values();

        return Inertia::render('Blog/Detail', [
            'article' => $article,
            'popularPosts' => $popularPosts,
            'popularTags' => $popularTags,
        ]);
    }
}
