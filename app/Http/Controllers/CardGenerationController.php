<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CardGenerationController extends Controller
{
    /**
     * Display a listing of members eligible for card generation
     */
    public function index()
    {
        $activeMembers = Member::where('status', 'active')
            ->with(['division', 'position', 'user'])
            ->orderBy('updated_at', 'desc')
            ->paginate(10);
            
        return view('admin.cards.index', compact('activeMembers'));
    }
    
    /**
     * Generate card for a specific member
     */
    public function generate($id)
    {
        $member = Member::with(['division', 'position', 'documents'])
            ->findOrFail($id);
            
        // Check if member is active
        if ($member->status !== 'active') {
            return redirect()->route('admin.cards.index')
                ->with('error', 'Hanya anggota aktif yang dapat dicetak kartunya.');
        }
        
        // Check if member has photo
        $photoDocument = $member->documents()->where('type', 'photo')->first();
        if (!$photoDocument) {
            return redirect()->route('admin.cards.index')
                ->with('error', 'Anggota belum mengunggah foto.');
        }
        
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
        
        // Generate ID card data
        $cardData = [
            'member' => $member,
            'photoUrl' => Storage::url($photoDocument->file_path),
            'cardNumber' => $member->registration_number,
            'generatedAt' => now(),
            'showQrCode' => $showQrCode,
            'qrCodeImage' => $qrCodeImage,
        ];
        
        return view('admin.cards.preview', $cardData);
    }
    
    /**
     * Save card generation and mark member card as generated
     */
    public function save($id)
    {
        $member = Member::findOrFail($id);
        
        // Update member with card generation timestamp
        $member->card_generated_at = now();
        $member->save();
        
        return redirect()->route('admin.cards.download', $id)
            ->with('success', 'Kartu anggota berhasil dibuat!');
    }
    
    /**
     * Download card for a specific member
     */
    public function download($id)
    {
        $member = Member::with(['division', 'position', 'documents'])
            ->findOrFail($id);
            
        // Filename for the card
        $filename = Str::slug($member->full_name) . '-card.pdf';
        
        // Check if member has photo
        $photoDocument = $member->documents()->where('type', 'photo')->first();
        
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
        
        // Return the web view for download display
        return view('admin.cards.download', $cardData);
    }
    
    /**
     * Generate PDF for download
     * 
     * @param int $id Member ID
     * @return \Illuminate\Http\Response
     */
    public function generatePdf($id)
    {
        $member = Member::with(['division', 'position', 'documents'])
            ->findOrFail($id);
            
        // Filename for the card
        $filename = Str::slug($member->full_name) . '-card.pdf';
        
        // Check if member has photo
        $photoDocument = $member->documents()->where('type', 'photo')->first();
        
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
        
        // Generate PDF using the exact same approach as member area
        $pdf = app()->make('dompdf.wrapper');
        $pdf->loadView('admin.cards.download-pdf', $cardData);
        
        return $pdf->stream($filename);
    }
}
