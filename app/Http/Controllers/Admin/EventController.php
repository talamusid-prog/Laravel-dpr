<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EventController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Event::query();

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('location', 'like', '%' . $request->search . '%');
            });
        }

        // Type filter
        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        // Status filter
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $events = $query->latest('start_date')
            ->paginate(15)
            ->withQueryString();

        $types = ['sidang', 'rapat', 'kunjungan', 'acara', 'lainnya'];
        $statuses = ['terjadwal', 'berlangsung', 'selesai', 'dibatalkan'];

        return Inertia::render('Admin/Events/Index', [
            'events' => $events,
            'types' => $types,
            'statuses' => $statuses,
            'filters' => $request->only(['search', 'type', 'status']),
        ]);
    }

    public function create(): Response
    {
        $types = ['sidang', 'rapat', 'kunjungan', 'acara', 'lainnya'];
        $statuses = ['terjadwal', 'berlangsung', 'selesai', 'dibatalkan'];

        return Inertia::render('Admin/Events/Create', [
            'types' => $types,
            'statuses' => $statuses,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:sidang,rapat,kunjungan,acara,lainnya',
            'status' => 'required|in:terjadwal,berlangsung,selesai,dibatalkan',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'location' => 'nullable|string',
            'participants' => 'nullable|array',
            'send_reminder' => 'boolean',
        ]);

        Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'status' => $request->status,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'location' => $request->location,
            'participants' => $request->participants ?? [],
            'send_reminder' => $request->boolean('send_reminder'),
        ]);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event berhasil dibuat.');
    }

    public function show(Event $event): Response
    {
        return Inertia::render('Admin/Events/Show', [
            'event' => $event,
        ]);
    }

    public function edit(Event $event): Response
    {
        $types = ['sidang', 'rapat', 'kunjungan', 'acara', 'lainnya'];
        $statuses = ['terjadwal', 'berlangsung', 'selesai', 'dibatalkan'];

        return Inertia::render('Admin/Events/Edit', [
            'event' => $event,
            'types' => $types,
            'statuses' => $statuses,
        ]);
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:sidang,rapat,kunjungan,acara,lainnya',
            'status' => 'required|in:terjadwal,berlangsung,selesai,dibatalkan',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'location' => 'nullable|string',
            'participants' => 'nullable|array',
            'send_reminder' => 'boolean',
        ]);

        $event->update([
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'status' => $request->status,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'location' => $request->location,
            'participants' => $request->participants ?? [],
            'send_reminder' => $request->boolean('send_reminder'),
        ]);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Event berhasil dihapus.');
    }

    public function calendar(): Response
    {
        $events = Event::where('start_date', '>=', now()->startOfMonth())
            ->where('start_date', '<=', now()->endOfMonth())
            ->get();

        return Inertia::render('Admin/Events/Calendar', [
            'events' => $events,
        ]);
    }
}
