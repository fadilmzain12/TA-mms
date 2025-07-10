@extends('admin.layouts.app')

@section('title', 'Member Cards')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Member ID Cards</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.members.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back to Members
        </a>
    </div>
</div>

<!-- Cards Table -->
<div class="card card-admin shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Members Eligible for Card Generation</h6>
        <span class="badge bg-primary">{{ $activeMembers->total() }} Active Members</span>
    </div>
    <div class="card-body">
        @if($activeMembers->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Reg. Number</th>
                            <th>Name</th>
                            <th>Division</th>
                            <th>Position</th>
                            <th>Card Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($activeMembers as $member)
                        <tr>
                            <td>{{ $member->registration_number }}</td>
                            <td>{{ $member->full_name }}</td>
                            <td>{{ $member->division->name ?? 'Not Assigned' }}</td>
                            <td>{{ $member->position->name ?? 'Not Assigned' }}</td>
                            <td>
                                @if($member->card_generated_at)
                                    <span class="badge bg-success">Generated</span>
                                    <small class="d-block text-muted">{{ \Carbon\Carbon::parse($member->card_generated_at)->format('d M Y') }}</small>
                                @else
                                    <span class="badge bg-secondary">Not Generated</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.cards.generate', $member->id) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-credit-card me-1"></i> Generate
                                    </a>
                                    @if($member->card_generated_at)
                                    <a href="{{ route('admin.cards.download', $member->id) }}" class="btn btn-sm btn-success">
                                        <i class="bi bi-download me-1"></i> Download
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $activeMembers->links() }}
            </div>
        @else
            <div class="alert alert-info">
                No active members available for card generation. Only members with 'active' status are eligible for ID cards.
            </div>
        @endif
    </div>
</div>

<!-- Card Generation Info -->
<div class="card card-admin shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">About Card Generation</h6>
    </div>
    <div class="card-body">
        <div class="alert alert-info mb-0">
            <i class="bi bi-info-circle-fill me-2"></i>
            <p class="mb-0">ID cards can only be generated for active members. Make sure members have a proper photo uploaded and verified before generating cards.</p>
        </div>
    </div>
</div>
@endsection