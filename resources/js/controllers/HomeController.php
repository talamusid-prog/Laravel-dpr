<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        // Get gallery items from database
        $galleryItems = \App\Models\Gallery::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'description' => $item->description,
                    'image' => $item->image_url,
                    'category' => $item->category,
                    'created_at' => $item->created_at->format('Y-m-d'),
                ];
            });

        return Inertia::render('Home', [
            'articles' => [], // Your existing articles data
            'posts' => [], // Your existing posts data
            'galleryItems' => $galleryItems,
        ]);
    }
}
