<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class GalleryController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Gallery::query();

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

        $galleries = $query->latest()
            ->paginate(12)
            ->withQueryString();

        // Transform galleries to include proper image URLs
        $galleries->getCollection()->transform(function ($gallery) {
            $gallery->image_url = $gallery->image ? asset('storage/' . $gallery->image) : null;
            $gallery->thumbnail_url = $gallery->thumbnail_path ? asset('storage/' . $gallery->thumbnail_path) : $gallery->image_url;
            return $gallery;
        });

        $categories = Gallery::distinct()->pluck('category');

        return Inertia::render('Admin/Gallery/Index', [
            'galleries' => $galleries,
            'categories' => $categories,
            'filters' => $request->only(['search', 'category', 'featured']),
        ]);
    }

    public function create(): Response
    {
        $categories = [
            'Kunjungan Kerja',
            'Rapat',
            'Acara',
            'Infrastruktur',
            'Sosial',
            'Pendidikan',
            'Kesehatan',
            'Ekonomi',
            'Lingkungan',
            'Lainnya'
        ];

        return Inertia::render('Admin/Gallery/Create', [
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|max:2048',
            'category' => 'required|string',
            'location' => 'nullable|string',
            'is_featured' => 'boolean',
        ]);

        $imagePath = $request->file('image')->store('gallery', 'public');
        
        // Create thumbnail
        $thumbnailPath = $this->createThumbnail($imagePath);

        Gallery::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
            'image_path' => $imagePath,
            'thumbnail_path' => $thumbnailPath,
            'category' => $request->category,
            'location' => $request->location,
            'is_featured' => $request->boolean('is_featured'),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Gambar berhasil diupload.');
    }

    public function show(Gallery $gallery): Response
    {
        return Inertia::render('Admin/Gallery/Show', [
            'gallery' => $gallery,
        ]);
    }

    public function edit(Gallery $gallery): Response
    {
        $categories = [
            'Kunjungan Kerja',
            'Rapat',
            'Acara',
            'Infrastruktur',
            'Sosial',
            'Pendidikan',
            'Kesehatan',
            'Ekonomi',
            'Lingkungan',
            'Lainnya'
        ];

        return Inertia::render('Admin/Gallery/Edit', [
            'gallery' => $gallery,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'category' => 'required|string',
            'location' => 'nullable|string',
            'is_featured' => 'boolean',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'location' => $request->location,
            'is_featured' => $request->boolean('is_featured'),
        ];

        if ($request->hasFile('image')) {
            // Delete old image
            Storage::disk('public')->delete($gallery->image_path);
            Storage::disk('public')->delete($gallery->thumbnail_path);

            // Upload new image
            $imagePath = $request->file('image')->store('gallery', 'public');
            $thumbnailPath = $this->createThumbnail($imagePath);

            $data['image_path'] = $imagePath;
            $data['thumbnail_path'] = $thumbnailPath;
        }

        $gallery->update($data);

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Gambar berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery)
    {
        // Delete files
        Storage::disk('public')->delete($gallery->image_path);
        Storage::disk('public')->delete($gallery->thumbnail_path);

        $gallery->delete();

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Gambar berhasil dihapus.');
    }

    public function bulkUpload(Request $request)
    {
        $request->validate([
            'images' => 'required|array|min:1',
            'images.*' => 'image|max:2048',
            'category' => 'required|string',
        ]);

        $uploadedCount = 0;

        foreach ($request->file('images') as $image) {
            $imagePath = $image->store('gallery', 'public');
            $thumbnailPath = $this->createThumbnail($imagePath);

            Gallery::create([
                'title' => $image->getClientOriginalName(),
                'description' => null,
                'image' => $imagePath,
                'image_path' => $imagePath,
                'thumbnail_path' => $thumbnailPath,
                'category' => $request->category,
                'location' => null,
                'is_featured' => false,
                'is_active' => true,
            ]);

            $uploadedCount++;
        }

        return redirect()->route('admin.gallery.index')
            ->with('success', "{$uploadedCount} gambar berhasil diupload.");
    }

    private function createThumbnail(string $imagePath): string
    {
        // Simple implementation - in production you might want to use Intervention Image
        return $imagePath; // For now, return the same path
    }
}
