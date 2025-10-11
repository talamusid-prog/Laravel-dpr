<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aspiration;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AspirationController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Aspiration::query();

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('submitter_name', 'like', '%' . $request->search . '%');
            });
        }

        // Status filter
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Category filter
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        $aspirations = $query->latest()
            ->paginate(15)
            ->withQueryString();

        $statuses = ['baru', 'diproses', 'selesai'];
        $categories = Aspiration::distinct()->pluck('category');

        return Inertia::render('Admin/Aspirations/Index', [
            'aspirations' => $aspirations,
            'statuses' => $statuses,
            'categories' => $categories,
            'filters' => $request->only(['search', 'status', 'category']),
        ]);
    }

    public function show(Aspiration $aspiration): Response
    {
        return Inertia::render('Admin/Aspirations/Show', [
            'aspiration' => $aspiration,
        ]);
    }

    public function respond(Request $request, Aspiration $aspiration)
    {
        $request->validate([
            'response' => 'required|string',
        ]);

        $aspiration->markAsResponded($request->response);

        return redirect()->route('admin.aspirations.index')
            ->with('success', 'Response berhasil dikirim.');
    }

    public function updateStatus(Request $request, Aspiration $aspiration)
    {
        $request->validate([
            'status' => 'required|in:baru,diproses,selesai',
        ]);

        $aspiration->update(['status' => $request->status]);

        return redirect()->back()
            ->with('success', 'Status aspirasi berhasil diperbarui.');
    }

    public function export(Request $request)
    {
        $query = Aspiration::query();

        // Apply filters
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $aspirations = $query->get();

        // For now, return JSON - in production you might want to generate Excel/PDF
        return response()->json([
            'data' => $aspirations,
            'count' => $aspirations->count(),
        ]);
    }

    public function destroy(Aspiration $aspiration)
    {
        $aspiration->delete();

        return redirect()->route('admin.aspirations.index')
            ->with('success', 'Aspirasi berhasil dihapus.');
    }
}
