@extends('admin.layouts.app')

@section('title', 'Edit Member')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Member</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.members.show', $member->id) }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back to Details
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card card-admin shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Member Information</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.members.update', $member->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <!-- Personal Information -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Personal Information</h5>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="full_name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('full_name') is-invalid @enderror" id="full_name" name="full_name" value="{{ old('full_name', $member->full_name) }}" required>
                                    @error('full_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nik" class="form-label">NIK <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" value="{{ old('nik', $member->nik) }}" required>
                                    @error('nik')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                                    <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                                        <option value="male" {{ old('gender', $member->gender) == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="female" {{ old('gender', $member->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="birth_place" class="form-label">Birth Place <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('birth_place') is-invalid @enderror" id="birth_place" name="birth_place" value="{{ old('birth_place', $member->birth_place) }}" required>
                                    @error('birth_place')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="birth_date" class="form-label">Birth Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('birth_date') is-invalid @enderror" id="birth_date" name="birth_date" value="{{ old('birth_date', $member->birth_date->format('Y-m-d')) }}" required>
                                    @error('birth_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $member->phone) }}" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3" required>{{ old('address', $member->address) }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" value="{{ old('city', $member->city) }}" required>
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Occupation Information -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Occupation Information</h5>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="occupation" class="form-label">Occupation <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('occupation') is-invalid @enderror" id="occupation" name="occupation" value="{{ old('occupation', $member->occupation) }}" required>
                                    @error('occupation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="job_title" class="form-label">Job Title</label>
                                    <input type="text" class="form-control @error('job_title') is-invalid @enderror" id="job_title" name="job_title" value="{{ old('job_title', $member->job_title) }}">
                                    @error('job_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Organization Information -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Organization Information</h5>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="division_id" class="form-label">Division</label>
                                    <select class="form-select @error('division_id') is-invalid @enderror" id="division_id" name="division_id">
                                        <option value="">-- Select Division --</option>
                                        @foreach($divisions as $division)
                                            <option value="{{ $division->id }}" {{ old('division_id', $member->division_id) == $division->id ? 'selected' : '' }}>
                                                {{ $division->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('division_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="position_id" class="form-label">Position</label>
                                    <select class="form-select @error('position_id') is-invalid @enderror" id="position_id" name="position_id">
                                        <option value="">-- Select Position --</option>
                                        @foreach($positions as $position)
                                            <option value="{{ $position->id }}" {{ old('position_id', $member->position_id) == $position->id ? 'selected' : '' }}>
                                                {{ $position->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('position_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="pending" {{ old('status', $member->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="active" {{ old('status', $member->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status', $member->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        <option value="rejected" {{ old('status', $member->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Documents -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Documents</h5>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="photo" class="form-label">Profile Photo</label>
                                    <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo">
                                    <div class="form-text">Leave empty to keep the current photo. Upload a new photo to replace the current one.</div>
                                    @error('photo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    
                                    @php
                                        $photoDocument = $member->documents->where('type', 'photo')->first();
                                    @endphp
                                    
                                    @if($photoDocument)
                                        <div class="mt-2">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ Storage::url($photoDocument->file_path) }}" alt="Current Photo" class="img-thumbnail me-2" style="height: 60px;">
                                                <span class="text-muted small">Current Photo</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="ktp_document" class="form-label">KTP Document</label>
                                    <input type="file" class="form-control @error('ktp_document') is-invalid @enderror" id="ktp_document" name="ktp_document">
                                    <div class="form-text">Leave empty to keep the current document. Upload a new document to replace the current one.</div>
                                    @error('ktp_document')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    
                                    @php
                                        $ktpDocument = $member->documents->where('type', 'ktp')->first();
                                    @endphp
                                    
                                    @if($ktpDocument)
                                        <div class="mt-2">
                                            <div class="d-flex align-items-center">
                                                <a href="{{ Storage::url($ktpDocument->file_path) }}" target="_blank" class="btn btn-sm btn-outline-info me-2">
                                                    <i class="bi bi-eye me-1"></i> View Current Document
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('admin.members.show', $member->id) }}" class="btn btn-secondary me-md-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Member</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card card-admin shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Member Information</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label small text-muted">Registration Number</label>
                    <p class="mb-0 fw-bold">{{ $member->registration_number }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label small text-muted">Registration Date</label>
                    <p class="mb-0">{{ $member->created_at->format('d F Y') }}</p>
                </div>
                
                @if($member->user)
                <hr>
                <div class="mb-3">
                    <label class="form-label small text-muted">User Account</label>
                    <p class="mb-0">{{ $member->user->email }}</p>
                </div>
                @endif
                
                <hr>
                <div class="alert alert-info mb-0">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    <small>When you update a member's information, all previous data will be replaced with the new data you enter.</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection