<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        // Mock data for demonstration
        $registrations = [
            [
                'id' => 1,
                'name' => 'Ahmad Rizki',
                'email' => 'ahmad.rizki@email.com',
                'phone' => '081234567890',
                'birthdate' => '1995-03-15',
                'gender' => 'Laki-laki',
                'education' => 'S1',
                'occupation' => 'Software Developer',
                'address' => 'Jl. Merdeka No. 123, Jakarta',
                'status' => 'pending',
                'submitted_at' => '2024-01-15 10:30:00'
            ],
            [
                'id' => 2,
                'name' => 'Siti Nurhaliza',
                'email' => 'siti.nurhaliza@email.com',
                'phone' => '081234567891',
                'birthdate' => '1992-07-22',
                'gender' => 'Perempuan',
                'education' => 'S2',
                'occupation' => 'Guru',
                'address' => 'Jl. Pendidikan No. 456, Bandung',
                'status' => 'approved',
                'submitted_at' => '2024-01-14 14:20:00'
            ],
            [
                'id' => 3,
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@email.com',
                'phone' => '081234567892',
                'birthdate' => '1988-11-08',
                'gender' => 'Laki-laki',
                'education' => 'SMA/SMK',
                'occupation' => 'Wiraswasta',
                'address' => 'Jl. Usaha No. 789, Surabaya',
                'status' => 'rejected',
                'submitted_at' => '2024-01-13 09:15:00'
            ]
        ];

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
        // Mock data for demonstration
        $registration = [
            'id' => $id,
            'name' => 'Ahmad Rizki',
            'email' => 'ahmad.rizki@email.com',
            'phone' => '081234567890',
            'birthdate' => '1995-03-15',
            'gender' => 'Laki-laki',
            'education' => 'S1',
            'occupation' => 'Software Developer',
            'address' => 'Jl. Merdeka No. 123, Jakarta',
            'status' => 'pending',
            'submitted_at' => '2024-01-15 10:30:00'
        ];

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

        // Here you would update the database
        // For now, we'll just return success

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
        // Here you would delete from database
        // For now, we'll just return success

        return response()->json([
            'message' => 'Pendaftaran berhasil dihapus'
        ]);
    }
}
