<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;

class AdminSettingsController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        // Get all current settings from cache
        $settings = [
            // General settings
            'site_name' => Cache::get('settings.site_name', config('app.name')),
            'organization_name' => Cache::get('settings.organization_name', 'MMS Organization'),
            'contact_email' => Cache::get('settings.contact_email', 'admin@mms.org'),
            'contact_phone' => Cache::get('settings.contact_phone', '+62 000 0000 0000'),
            
            // Email settings
            'mail_from_address' => Cache::get('settings.mail_from_address', config('mail.from.address', 'noreply@mms.org')),
            'mail_from_name' => Cache::get('settings.mail_from_name', config('mail.from.name', 'MMS System')),
            'send_welcome_email' => Cache::get('settings.send_welcome_email', true),
            'send_verification_email' => Cache::get('settings.send_verification_email', true),
            
            // Card settings
            'card_validity_years' => Cache::get('settings.card_validity_years', 2),
            'show_qr_on_card' => Cache::get('settings.show_qr_on_card', false),
        ];
        
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update the application settings.
     */
    public function update(Request $request)
    {
        // Determine which section is being updated
        $section = $request->input('section', 'general');
        
        if ($section === 'general') {
            // Validate general settings
            $request->validate([
                'site_name' => 'required|string|max:100',
                'organization_name' => 'required|string|max:100',
                'contact_email' => 'required|email',
                'contact_phone' => 'required|string|max:20',
            ]);
            
            // Save general settings to cache
            Cache::put('settings.site_name', $request->site_name, 60*24*30);
            Cache::put('settings.organization_name', $request->organization_name, 60*24*30);
            Cache::put('settings.contact_email', $request->contact_email, 60*24*30);
            Cache::put('settings.contact_phone', $request->contact_phone, 60*24*30);
            
        } elseif ($section === 'email') {
            // Validate email settings
            $request->validate([
                'mail_from_address' => 'required|email',
                'mail_from_name' => 'required|string|max:100',
            ]);
            
            // Save email settings to cache
            Cache::put('settings.mail_from_address', $request->mail_from_address, 60*24*30);
            Cache::put('settings.mail_from_name', $request->mail_from_name, 60*24*30);
            Cache::put('settings.send_welcome_email', $request->has('send_welcome_email'), 60*24*30);
            Cache::put('settings.send_verification_email', $request->has('send_verification_email'), 60*24*30);
            
        } elseif ($section === 'card') {
            // Validate card settings
            $request->validate([
                'card_validity_years' => 'required|integer|min:1|max:10',
            ]);
            
            // Save card settings to cache
            Cache::put('settings.card_validity_years', $request->card_validity_years, 60*24*30);
            Cache::put('settings.show_qr_on_card', $request->has('show_qr_on_card'), 60*24*30);
        }
        
        return redirect()->route('admin.settings')
            ->with('success', 'Pengaturan berhasil disimpan.');
    }
}