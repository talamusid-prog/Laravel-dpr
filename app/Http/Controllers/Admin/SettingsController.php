<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SettingsController extends Controller
{
    public function index(): Response
    {
        $settings = Setting::all()->keyBy('key');

        return Inertia::render('Admin/Settings/Index', [
            'settings' => $settings,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'required|string',
            'primary_color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string',
            'social_facebook' => 'nullable|url',
            'social_instagram' => 'nullable|url',
            'social_twitter' => 'nullable|url',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string',
        ]);

        // Update settings
        Setting::set('site_name', $request->site_name, 'string', 'Nama website');
        Setting::set('site_description', $request->site_description, 'string', 'Deskripsi website');
        Setting::set('primary_color', $request->primary_color, 'string', 'Warna primer website');
        Setting::set('contact_email', $request->contact_email, 'string', 'Email kontak');
        Setting::set('contact_phone', $request->contact_phone, 'string', 'Nomor telepon kontak');
        Setting::set('social_facebook', $request->social_facebook, 'string', 'Link Facebook');
        Setting::set('social_instagram', $request->social_instagram, 'string', 'Link Instagram');
        Setting::set('social_twitter', $request->social_twitter, 'string', 'Link Twitter');
        Setting::set('meta_title', $request->meta_title, 'string', 'Meta title untuk SEO');
        Setting::set('meta_description', $request->meta_description, 'string', 'Meta description untuk SEO');
        Setting::set('meta_keywords', $request->meta_keywords, 'string', 'Meta keywords untuk SEO');

        return redirect()->route('admin.settings')
            ->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
