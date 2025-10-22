<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class ArticleController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Article::query();

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('excerpt', 'like', '%' . $request->search . '%');
            });
        }

        // Status filter
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $articles = $query->latest()
            ->paginate(10)
            ->withQueryString();

        // Transform articles to include proper image URLs
        $articles->getCollection()->transform(function ($article) {
            $article->featured_image_url = $article->featured_image ? asset('storage/' . $article->featured_image) : null;
            return $article;
        });

        return Inertia::render('Admin/Articles/Index', [
            'articles' => $articles,
            'filters' => $request->only(['search', 'status']),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Articles/Create');
    }

    public function store(Request $request)
    {
        // Debug: Log request data
        \Log::info('Store request data:', [
            'title' => $request->title,
            'content' => $request->content,
            'status' => $request->status,
            'has_featured_image_file' => $request->hasFile('featured_image'),
            'all_input' => $request->all(),
            'files' => $request->allFiles(),
        ]);

        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'featured_image' => 'nullable|file|image|max:2048',
            'status' => 'required|in:draft,published',
        ]);

        $featuredImagePath = null;
        if ($request->hasFile('featured_image')) {
            $featuredImagePath = $request->file('featured_image')->store('articles', 'public');
            \Log::info('Featured image stored:', ['path' => $featuredImagePath]);
        }

        $article = Article::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'featured_image' => $featuredImagePath,
            'status' => $request->status,
            'published_at' => $request->status === 'published' ? now() : null,
        ]);

        \Log::info('Article created:', [
            'id' => $article->id,
            'title' => $article->title,
            'featured_image' => $article->featured_image,
        ]);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil dibuat.');
    }

    public function edit(Article $article): Response
    {
        // Add full image URL for display
        if ($article->featured_image) {
            $article->featured_image_url = asset('storage/' . $article->featured_image);
            \Log::info('Generated image URL:', [
                'featured_image' => $article->featured_image,
                'featured_image_url' => $article->featured_image_url,
            ]);
        } else {
            $article->featured_image_url = null;
        }

        \Log::info('Sending article to frontend:', [
            'id' => $article->id,
            'featured_image' => $article->featured_image,
            'featured_image_url' => $article->featured_image_url ?? 'NOT SET',
        ]);

        return Inertia::render('Admin/Articles/Edit', [
            'article' => $article,
        ]);
    }

    public function update(Request $request, Article $article)
    {
        // Debug: Log request data
        \Log::info('Update request data:', [
            'title' => $request->title,
            'content' => $request->content,
            'status' => $request->status,
            'has_featured_image_file' => $request->hasFile('featured_image'),
            'all_input' => $request->all(),
            'request_method' => $request->method(),
            'content_type' => $request->header('Content-Type'),
            'raw_input' => $request->getContent(),
            'files' => $request->allFiles(),
            'input_keys' => array_keys($request->all()),
            'title_exists' => $request->has('title'),
            'content_exists' => $request->has('content'),
            'status_exists' => $request->has('status')
        ]);

        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'featured_image' => 'nullable|file|image|max:2048',
            'image_alt' => 'nullable|string',
            'tags' => 'nullable|array',
            'status' => 'required|in:draft,published',
        ]);

        // Handle tags - decode JSON string if needed or use array directly
        $tags = $request->tags;
        if (is_string($tags)) {
            $tags = json_decode($tags, true) ?? [];
        }
        if (!is_array($tags)) {
            $tags = [];
        }

        $updateData = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'image_alt' => $request->image_alt,
            'tags' => $tags,
            'status' => $request->status,
            'published_at' => $request->status === 'published' && !$article->published_at ? now() : $article->published_at,
        ];

        // Handle featured image
        if ($request->hasFile('featured_image')) {
            $file = $request->file('featured_image');
            $path = $file->store('articles', 'public');
            $updateData['featured_image'] = $path;
            \Log::info('File uploaded successfully:', [
                'original_name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'path' => $path
            ]);
        }
        
        \Log::info('Update data:', $updateData);

        $article->update($updateData);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil dihapus.');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,publish,draft',
            'article_ids' => 'required|array',
        ]);

        $articles = Article::whereIn('id', $request->article_ids);

        switch ($request->action) {
            case 'delete':
                $articles->delete();
                $message = 'Artikel berhasil dihapus.';
                break;
            case 'publish':
                $articles->update(['status' => 'published', 'published_at' => now()]);
                $message = 'Artikel berhasil dipublikasikan.';
                break;
            case 'draft':
                $articles->update(['status' => 'draft']);
                $message = 'Artikel berhasil diubah ke draft.';
                break;
        }

        return redirect()->back()->with('success', $message);
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        $imagePath = $request->file('image')->store('articles', 'public');

        return redirect()->back()->with([
            'upload_success' => true,
            'image_path' => $imagePath,
            'image_url' => asset('storage/' . $imagePath),
        ]);
    }
}
