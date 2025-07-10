@extends('admin.layouts.app')

@section('title', 'Member Details')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Member Details</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('admin.members.edit', $member->id) }}" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-pencil me-1"></i> Edit
            </a>
            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                <i class="bi bi-trash me-1"></i> Delete
            </button>
        </div>
        <a href="{{ route('admin.members.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back to List
        </a>
    </div>
</div>

<!-- Status Action Buttons -->
@if($member->status == 'pending')
<div class="alert alert-warning mb-4">
    <h5 class="alert-heading"><i class="bi bi-exclamation-triangle me-1"></i> Pending Approval</h5>
    <p class="mb-0">This member is waiting for approval. Review their details and documents before approving.</p>
    <hr>
    <div class="d-flex gap-2">
        <form action="{{ route('admin.verifications.verify', $member->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">
                <i class="bi bi-check-circle me-1"></i> Approve Member
            </button>
        </form>
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
            <i class="bi bi-x-circle me-1"></i> Reject
        </button>
    </div>
</div>
@elseif($member->status == 'rejected')
<div class="alert alert-danger mb-4">
    <h5 class="alert-heading"><i class="bi bi-x-circle me-1"></i> Rejected</h5>
    <p class="mb-0">This member was rejected. You can approve them if needed.</p>
    <hr>
    <form action="{{ route('admin.verifications.verify', $member->id) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-success">
            <i class="bi bi-check-circle me-1"></i> Approve Member
        </button>
    </form>
</div>
@elseif($member->status == 'inactive')
<div class="alert alert-secondary mb-4">
    <h5 class="alert-heading"><i class="bi bi-pause-circle me-1"></i> Inactive</h5>
    <p class="mb-0">This member is inactive. You can activate them if needed.</p>
    <hr>
    <form action="{{ route('admin.members.activate', $member->id) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-play-circle me-1"></i> Activate Member
        </button>
    </form>
</div>
@endif

<!-- Member Information -->
<div class="row">
    <div class="col-lg-8">
        <div class="card card-admin shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Personal Information</h6>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h5 class="text-primary">{{ $member->full_name }}</h5>
                        <p class="text-muted mb-0">Registration Number: {{ $member->registration_number }}</p>
                        <p class="badge {{ $member->status == 'active' ? 'bg-success' : ($member->status == 'pending' ? 'bg-warning' : ($member->status == 'rejected' ? 'bg-danger' : 'bg-secondary')) }}">
                            {{ ucfirst($member->status) }}
                        </p>
                    </div>
                </div>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label small text-muted">NIK</label>
                            <p class="mb-0">{{ $member->nik }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label small text-muted">Gender</label>
                            <p class="mb-0">{{ $member->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label small text-muted">Birth Place</label>
                            <p class="mb-0">{{ $member->birth_place }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label small text-muted">Birth Date</label>
                            <p class="mb-0">{{ $member->birth_date->format('d F Y') }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label small text-muted">Phone</label>
                            <p class="mb-0">{{ $member->phone }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label small text-muted">Email</label>
                            <p class="mb-0">{{ $member->user->email ?? 'No email registered' }}</p>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label small text-muted">Address</label>
                            <p class="mb-0">{{ $member->address }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label small text-muted">City</label>
                            <p class="mb-0">{{ $member->city ?? 'Not specified' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card card-admin shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Occupation Information</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label small text-muted">Occupation</label>
                            <p class="mb-0">{{ $member->occupation }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label small text-muted">Job Title</label>
                            <p class="mb-0">{{ $member->job_title ?? 'Not specified' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card card-admin shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Organization Information</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label small text-muted">Division</label>
                            <p class="mb-0">{{ $member->division->name ?? 'Not Assigned' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label small text-muted">Position</label>
                            <p class="mb-0">{{ $member->position->name ?? 'Not Assigned' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label small text-muted">Joined Date</label>
                            <p class="mb-0">{{ $member->created_at->format('d F Y') }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label small text-muted">Last Updated</label>
                            <p class="mb-0">{{ $member->updated_at->format('d F Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Member Profile Photo -->
        <div class="card card-admin shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Profile Photo</h6>
            </div>
            <div class="card-body text-center">
                @php
                    $photoDocument = $member->documents->where('type', 'photo')->first();
                @endphp
                
                @if($photoDocument)
                    <img src="{{ asset('storage/' . str_replace('public/', '', $photoDocument->file_path)) }}" alt="{{ $member->full_name }}" class="img-fluid rounded mb-3" style="max-height: 250px;">
                    <div class="d-grid">
                        <a href="{{ asset('storage/' . str_replace('public/', '', $photoDocument->file_path)) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-arrows-fullscreen me-1"></i> View Full Size
                        </a>
                    </div>
                @else
                    <div class="bg-light rounded d-flex align-items-center justify-content-center p-5 mb-3" style="height: 250px;">
                        <i class="bi bi-person-bounding-box fa-4x text-secondary"></i>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Member Documents -->
        <div class="card card-admin shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Documents</h6>
            </div>
            <div class="card-body">
                @php
                    $ktpDocument = $member->documents->where('type', 'ktp')->first();
                @endphp
                
                <div class="mb-3">
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-person-vcard me-2 text-primary"></i>
                        <strong>KTP Document</strong>
                    </div>
                    
                    @if($ktpDocument)
                        @if(in_array(pathinfo($ktpDocument->file_path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                            <div class="border rounded p-2 mb-2">
                                <img src="{{ asset('storage/' . str_replace('public/', '', $ktpDocument->file_path)) }}" alt="KTP Document" class="img-fluid">
                            </div>
                        @endif
                        
                        <div class="d-grid">
                            <a href="{{ asset('storage/' . str_replace('public/', '', $ktpDocument->file_path)) }}" target="_blank" class="btn btn-sm btn-primary">
                                <i class="bi bi-eye me-1"></i> View Document
                            </a>
                        </div>
                    @else
                        <div class="text-muted">No KTP document uploaded</div>
                    @endif
                </div>
                
                <hr>
                
                <div class="mb-3">
                    <label class="form-label small text-muted d-block">Card Status</label>
                    @if($member->card_generated_at)
                        <span class="badge bg-success me-2">Card Generated</span>
                        <small class="text-muted">on {{ \Carbon\Carbon::parse($member->card_generated_at)->format('d F Y') }}</small>
                    @else
                        <span class="badge bg-secondary">No Card Generated</span>
                    @endif
                </div>
                
                <!-- Actions -->
                <div class="d-grid gap-2 mt-4">
                    <a href="{{ route('admin.cards.generate', $member->id) }}" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-credit-card me-1"></i> Generate Card
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete {{ $member->full_name }}? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.members.destroy', $member->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Reject Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.verifications.reject', $member->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="rejection_reason" class="form-label">Rejection Reason</label>
                        <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3" required></textarea>
                        <div class="form-text">Please provide a reason for rejecting this member.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection