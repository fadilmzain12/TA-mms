<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Member;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class RegistrationController extends Controller
{
    /**
     * Show the first step of registration form
     */
    public function showStep1()
    {
        return view('registration.step1');
    }
    
    /**
     * Process step 1 of registration (Account & Personal Info)
     */
    public function processStep1(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::defaults()],
            'full_name' => 'required|string|max:255',
            'nik' => 'required|string|size:16|unique:members,nik',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date|before:today',
            'gender' => 'required|in:male,female',
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'occupation' => 'required|string|max:255',
            'job_title' => 'nullable|string|max:255',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('registration.step1')
                ->withErrors($validator)
                ->withInput();
        }
        
        try {
            DB::beginTransaction();
            
            // Create user account
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            
            // Create member profile
            $member = Member::create([
                'user_id' => $user->id,
                'full_name' => $request->full_name,
                'nik' => $request->nik,
                'birth_place' => $request->birth_place,
                'birth_date' => $request->birth_date,
                'gender' => $request->gender,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'occupation' => $request->occupation,
                'job_title' => $request->job_title,
                'status' => 'pending',
            ]);
            
            // Generate registration number
            $registrationNumber = $member->generateRegistrationNumber();
            
            // Create registration record
            Registration::create([
                'member_id' => $member->id,
                'registration_number' => $registrationNumber,
                'personal_info_completed' => true,
                'status' => 'draft',
            ]);
            
            // Update member with registration number
            $member->update(['registration_number' => $registrationNumber]);
            
            DB::commit();
            
            // Authenticate the user
            Auth::login($user);
            
            return redirect()->route('registration.step2')
                ->with('success', 'Personal information saved successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('registration.step1')
                ->with('error', 'Error during registration: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    /**
     * Show the second step of registration form
     */
    public function showStep2()
    {
        // Check if step 1 is completed
        $member = Auth::user()->member;
        $registration = $member->registration;
        
        if (!$registration || !$registration->personal_info_completed) {
            return redirect()->route('registration.step1')
                ->with('error', 'Please complete the personal information first.');
        }
        
        return view('registration.step2', compact('member'));
    }
    
    /**
     * Process step 2 of registration (Document Upload)
     */
    public function processStep2(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ktp_document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'photo' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('registration.step2')
                ->withErrors($validator)
                ->withInput();
        }
        
        try {
            $member = Auth::user()->member;
            
            // Handle KTP document upload
            if ($request->hasFile('ktp_document')) {
                $ktpDocument = $request->file('ktp_document');
                $ktpFileName = 'ktp_' . time() . '.' . $ktpDocument->getClientOriginalExtension();
                $ktpPath = $ktpDocument->storeAs('members/documents/' . $member->id, $ktpFileName, 'public');
                
                // Delete existing KTP document if exists
                $existingKtp = Document::where('member_id', $member->id)
                    ->where('type', 'ktp')
                    ->first();
                    
                if ($existingKtp) {
                    Storage::disk('public')->delete($existingKtp->file_path);
                    $existingKtp->delete();
                }
                
                Document::create([
                    'member_id' => $member->id,
                    'type' => 'ktp',
                    'file_name' => $ktpFileName,
                    'original_name' => $ktpDocument->getClientOriginalName(),
                    'file_path' => $ktpPath,
                    'mime_type' => $ktpDocument->getMimeType(),
                    'file_size' => $ktpDocument->getSize(),
                ]);
            }
            
            // Handle Photo upload
            if ($request->hasFile('photo')) {
                $photoFile = $request->file('photo');
                $photoFileName = 'photo_' . time() . '.' . $photoFile->getClientOriginalExtension();
                $photoPath = $photoFile->storeAs('members/documents/' . $member->id, $photoFileName, 'public');
                
                // Delete existing photo if exists
                $existingPhoto = Document::where('member_id', $member->id)
                    ->where('type', 'photo')
                    ->first();
                    
                if ($existingPhoto) {
                    Storage::disk('public')->delete($existingPhoto->file_path);
                    $existingPhoto->delete();
                }
                
                Document::create([
                    'member_id' => $member->id,
                    'type' => 'photo',
                    'file_name' => $photoFileName,
                    'original_name' => $photoFile->getClientOriginalName(),
                    'file_path' => $photoPath,
                    'mime_type' => $photoFile->getMimeType(),
                    'file_size' => $photoFile->getSize(),
                ]);
            }
            
            // Update registration record
            $member->registration->update([
                'documents_uploaded' => true,
            ]);
            
            return redirect()->route('registration.step3')
                ->with('success', 'Documents uploaded successfully!');
        } catch (\Exception $e) {
            return redirect()->route('registration.step2')
                ->with('error', 'Error uploading documents: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    /**
     * Show the third step of registration form
     */
    public function showStep3()
    {
        // Check if step 2 is completed
        $member = Auth::user()->member;
        $registration = $member->registration;
        
        if (!$registration || !$registration->documents_uploaded) {
            return redirect()->route('registration.step2')
                ->with('error', 'Please upload the required documents first.');
        }
        
        return view('registration.step3', compact('member', 'registration'));
    }
    
    /**
     * Process step 3 of registration (Terms & Confirmation)
     */
    public function processStep3(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'terms_accepted' => 'required|accepted',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('registration.step3')
                ->withErrors($validator)
                ->withInput();
        }
        
        try {
            $member = Auth::user()->member;
            $registration = $member->registration;
            
            // Update registration record
            $registration->update([
                'terms_accepted' => true,
            ]);
            
            // Mark registration as submitted
            $registration->markAsSubmitted();
            
            return redirect()->route('registration.complete')
                ->with('success', 'Registration completed successfully!');
        } catch (\Exception $e) {
            return redirect()->route('registration.step3')
                ->with('error', 'Error completing registration: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    /**
     * Show registration completion page
     */
    public function complete()
    {
        $member = Auth::user()->member;
        $registration = $member->registration;
        
        if (!$registration || $registration->status != 'submitted') {
            return redirect()->route('registration.step1');
        }
        
        $registration_number = $registration->registration_number;
        
        return view('registration.complete', compact('member', 'registration', 'registration_number'));
    }
}
