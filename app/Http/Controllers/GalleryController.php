<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class GalleryController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Gallery::where('is_active', true);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Category filter
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        // Featured filter
        if ($request->has('featured') && $request->featured !== '') {
            $query->where('is_featured', $request->featured);
        }

        $galleries = $query->orderBy('created_at', 'desc')
            ->paginate(12)
            ->withQueryString();

        // Transform galleries to include proper image URLs
        $galleries->getCollection()->transform(function ($gallery) {
            $gallery->image_url = $gallery->image ? asset('storage/' . $gallery->image) : null;
            $gallery->thumbnail_url = $gallery->thumbnail_path ? asset('storage/' . $gallery->thumbnail_path) : $gallery->image_url;
            return $gallery;
        });

        $categories = Gallery::where('is_active', true)->distinct()->pluck('category');

        return Inertia::render('Gallery', [
            'galleries' => $galleries,
            'categories' => $categories,
            'filters' => $request->only(['search', 'category', 'featured']),
        ]);
    }
}