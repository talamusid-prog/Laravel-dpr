<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MemberRegistration;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MemberRegistrationController extends Controller
{
    /**
     * Display a listing of member registrations.
     */
    public function index(): Response
    {
        $registrations = MemberRegistration::orderBy('submitted_at', 'desc')->get();

        return Inertia::render('Admin/MemberRegistrations/Index', [
            'registrations' => $registrations
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Admin/MemberRegistrations/Create');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): Response
    {
        $registration = MemberRegistration::findOrFail($id);

        return Inertia::render('Admin/MemberRegistrations/Show', [
            'registration' => $registration
        ]);
    }

    /**
     * Update the status of a registration.
     */
    public function updateStatus(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'notes' => 'nullable|string|max:500'
        ]);

        $registration = MemberRegistration::findOrFail($id);
        $registration->update([
            'status' => $request->status,
            'notes' => $request->notes
        ]);

        return response()->json([
            'message' => 'Status berhasil diubah',
            'status' => $request->status
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $registration = MemberRegistration::findOrFail($id);
        $registration->delete();

        return response()->json([
            'message' => 'Pendaftaran berhasil dihapus'
        ]);
    }
}
