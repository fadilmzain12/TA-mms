<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class MemberProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the member profile page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $member = $user->member;
        
        if (!$member) {
            return redirect()->route('registration.step1')
                ->with('error', 'Please complete your registration first.');
        }
        
        // Get the current photo document if it exists
        $photoDocument = $member->getPhotoDocument();
        
        // Get the current KTP document if it exists
        $ktpDocument = $member->getKtpDocument();
        
        // Get registration data including rejection reason
        $registration = $member->registration;
        
        return view('member.profile', compact('member', 'photoDocument', 'ktpDocument', 'registration'));
    }

    /**
     * Update member's profile photo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $user = Auth::user();
        $member = $user->member;
        
        if (!$member) {
            return redirect()->route('registration.step1')
                ->with('error', 'Please complete your registration first.');
        }
        
        $file = $request->file('photo');
        $originalName = $file->getClientOriginalName();
        $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('uploads/photos', $fileName, 'public');
        
        // Check if a photo document already exists
        $photoDocument = $member->documents()->where('type', 'photo')->first();
        
        if ($photoDocument) {
            // Delete old file if it exists
            if (Storage::disk('public')->exists($photoDocument->file_path)) {
                Storage::disk('public')->delete($photoDocument->file_path);
            }
            
            // Update existing document
            $photoDocument->update([
                'original_name' => $originalName,
                'file_name' => $fileName,
                'file_path' => $filePath,
                'mime_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
                'verified' => false, // Reset verification status
                'verification_notes' => null,
            ]);
        } else {
            // Create new document
            Document::create([
                'member_id' => $member->id,
                'type' => 'photo',
                'original_name' => $originalName,
                'file_name' => $fileName,
                'file_path' => $filePath,
                'mime_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
                'verified' => false,
            ]);
        }
        
        return redirect()->route('member.profile')
            ->with('status', 'Profile photo has been updated successfully.');
    }

    /**
     * Update member's KTP photo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateKtp(Request $request)
    {
        $request->validate([
            'ktp' => 'required|image|mimes:jpeg,png,jpg,gif|max:3072', // Allow slightly larger size for KTP (3MB)
        ]);
        
        $user = Auth::user();
        $member = $user->member;
        
        if (!$member) {
            return redirect()->route('registration.step1')
                ->with('error', 'Please complete your registration first.');
        }
        
        $file = $request->file('ktp');
        $originalName = $file->getClientOriginalName();
        $fileName = time() . '_ktp_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('uploads/ktp', $fileName, 'public');
        
        // Check if a KTP document already exists
        $ktpDocument = $member->documents()->where('type', 'ktp')->first();
        
        if ($ktpDocument) {
            // Delete old file if it exists
            if (Storage::disk('public')->exists($ktpDocument->file_path)) {
                Storage::disk('public')->delete($ktpDocument->file_path);
            }
            
            // Update existing document
            $ktpDocument->update([
                'original_name' => $originalName,
                'file_name' => $fileName,
                'file_path' => $filePath,
                'mime_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
                'verified' => false, // Reset verification status
                'verification_notes' => null,
            ]);
        } else {
            // Create new document
            Document::create([
                'member_id' => $member->id,
                'type' => 'ktp',
                'original_name' => $originalName,
                'file_name' => $fileName,
                'file_path' => $filePath,
                'mime_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
                'verified' => false,
            ]);
        }
        
        return redirect()->route('member.profile')
            ->with('status', 'KTP photo has been updated successfully.');
    }

    /**
     * Show the card generation page
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showCard()
    {
        $user = Auth::user();
        $member = $user->member;
        
        if (!$member) {
            return redirect()->route('registration.step1')
                ->with('error', 'Please complete your registration first.');
        }
        
        // Check if member is active
        if ($member->status !== Member::STATUS_ACTIVE) {
            return redirect()->route('member.profile')
                ->with('error', 'Your account needs to be approved before generating a card.');
        }
        
        // Get the photo document
        $photoDocument = $member->getPhotoDocument();
        
        // Get QR code setting
        $showQrCode = Cache::get('settings.show_qr_on_card', false);
        
        // Generate QR code if enabled
        $qrCodeImage = null;
        if ($showQrCode) {
            // Generate QR code containing member information
            $qrData = json_encode([
                'id' => $member->id,
                'name' => $member->full_name,
                'nik' => $member->nik,
                'reg_num' => $member->registration_number,
            ]);
            
            // Generate QR code as SVG instead of PNG to avoid Imagick dependency
            $qrCodeImage = 'data:image/svg+xml;base64,' . base64_encode(
                QrCode::format('svg')
                    ->size(200)
                    ->errorCorrection('H')
                    ->generate($qrData)
            );
        }
        
        // Prepare card data (same structure as admin controller)
        $cardData = [
            'member' => $member,
            'photoDocument' => $photoDocument,
            'generatedAt' => $member->card_generated_at ? \Carbon\Carbon::parse($member->card_generated_at) : now(),
            'showQrCode' => $showQrCode,
            'qrCodeImage' => $qrCodeImage,
        ];
        
        return view('member.card', $cardData);
    }

    /**
     * Generate a membership card for download
     *
     * @return \Illuminate\Http\Response
     */
    public function generateCard()
    {
        $user = Auth::user();
        $member = $user->member;
        
        if (!$member || $member->status !== Member::STATUS_ACTIVE) {
            return redirect()->route('member.profile')
                ->with('error', 'Your account needs to be approved before generating a card.');
        }
        
        // Update card generation timestamp
        $member->card_generated_at = now();
        $member->save();
        
        // Get the photo document
        $photoDocument = $member->getPhotoDocument();
        
        // Get QR code setting
        $showQrCode = Cache::get('settings.show_qr_on_card', false);
        
        // Generate QR code if enabled
        $qrCodeImage = null;
        if ($showQrCode) {
            // Generate QR code containing member information
            $qrData = json_encode([
                'id' => $member->id,
                'name' => $member->full_name,
                'nik' => $member->nik,
                'reg_num' => $member->registration_number,
            ]);
            
            // Generate QR code as SVG instead of PNG to avoid Imagick dependency
            $qrCodeImage = 'data:image/svg+xml;base64,' . base64_encode(
                QrCode::format('svg')
                    ->size(200)
                    ->errorCorrection('H')
                    ->generate($qrData)
            );
        }
        
        // Prepare card data
        $cardData = [
            'member' => $member,
            'photoUrl' => $photoDocument ? Storage::url($photoDocument->file_path) : null,
            'cardNumber' => $member->registration_number,
            'generatedAt' => $member->card_generated_at ? \Carbon\Carbon::parse($member->card_generated_at) : now(),
            'showQrCode' => $showQrCode,
            'qrCodeImage' => $qrCodeImage,
        ];
        
        // Create a filename exactly like the admin version
        $filename = Str::slug($member->full_name) . '-card.pdf';
        
        // Generate PDF using the exact same approach as admin
        $pdf = app()->make('dompdf.wrapper');
        $pdf->loadView('admin.cards.download-pdf', $cardData);
        
        return $pdf->stream($filename);
    }
}