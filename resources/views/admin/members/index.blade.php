@extends('admin.layouts.app')

@section('title', 'Members')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Member Management</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('admin.members.export') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-download me-1"></i> Export
            </a>
            <a href="{{ route('admin.members.create') }}" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-plus-lg me-1"></i> Add Member
            </a>
        </div>
    </div>
</div>

<!-- Search and Filter -->
<div class="card card-admin mb-4">
    <div class="card-body">
        <form action="{{ route('admin.members.index') }}" method="GET" class="mb-0">
            <div class="row g-3 align-items-center">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" id="search" name="search" placeholder="Search by name, registration number, or NIK" value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-4">
                    <select class="form-select" name="status" id="status" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <div class="col-md-2 text-end">
                    @if(request('search') || request('status'))
                        <a href="{{ route('admin.members.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-1"></i> Clear
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Members Table -->
<div class="card card-admin shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">All Members</h6>
        <span class="badge bg-primary">{{ $members->total() }} Members</span>
    </div>
    <div class="card-body">
        @if($members->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Reg. Number</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Division</th>
                            <th>Position</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($members as $member)
                        <tr>
                            <td>{{ $member->registration_number }}</td>
                            <td>{{ $member->full_name }}</td>
                            <td>{{ $member->phone }}</td>
                            <td>{{ $member->division->name ?? 'Not Assigned' }}</td>
                            <td>{{ $member->position->name ?? 'Not Assigned' }}</td>
                            <td>
                                @if($member->status == 'active')
                                    <span class="badge bg-success">Active</span>
                                @elseif($member->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($member->status == 'inactive')
                                    <span class="badge bg-secondary">Inactive</span>
                                @elseif($member->status == 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.members.show', $member->id) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.members.edit', $member->id) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $member->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                                
                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $member->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $member->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $member->id }}">Confirm Delete</h5>
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
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $members->links() }}
            </div>
        @else
            <div class="text-center py-4">
                <i class="bi bi-people fa-3x text-secondary mb-3"></i>
                <p class="text-secondary">No members found.</p>
            </div>
        @endif
    </div>
</div>
@endsection