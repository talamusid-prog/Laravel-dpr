<?php

namespace App\Http\Controllers;

use App\Models\Aspiration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AspirationController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'kategori' => 'required|string|max:255',
            'aspirasi' => 'required|string|min:50',
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'nama.string' => 'Nama harus berupa teks.',
            'nama.max' => 'Nama maksimal 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 255 karakter.',
            'kategori.required' => 'Kategori aspirasi wajib dipilih.',
            'kategori.string' => 'Kategori harus berupa teks.',
            'kategori.max' => 'Kategori maksimal 255 karakter.',
            'aspirasi.required' => 'Aspirasi wajib diisi.',
            'aspirasi.string' => 'Aspirasi harus berupa teks.',
            'aspirasi.min' => 'Aspirasi minimal 50 karakter.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $aspiration = Aspiration::create([
                'title' => 'Aspirasi dari ' . $request->nama,
                'description' => $request->aspirasi,
                'submitter_name' => $request->nama,
                'submitter_email' => $request->email,
                'category' => $request->kategori,
                'status' => 'baru',
                'submitted_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Aspirasi Anda berhasil dikirim! Terima kasih atas partisipasi Anda.',
                'data' => [
                    'id' => $aspiration->id,
                    'title' => $aspiration->title,
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengirim aspirasi. Silakan coba lagi.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
