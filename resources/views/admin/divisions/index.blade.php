@extends('admin.layouts.app')

@section('title', 'Manage Divisions')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Divisi</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createDivisionModal">
                <i class="bi bi-plus-circle me-1"></i> Tambah Divisi
            </button>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Divisions Table -->
    <div class="card card-admin shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Divisi</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th>Jumlah Anggota</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($divisions as $division)
                            <tr>
                                <td>{{ $division->code }}</td>
                                <td>{{ $division->name }}</td>
                                <td>{{ $division->description ?? '-' }}</td>
                                <td>
                                    @if($division->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td>{{ $division->members_count ?? $division->members->count() }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editDivisionModal{{ $division->id }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteDivisionModal{{ $division->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Edit Division Modal -->
                            <div class="modal fade" id="editDivisionModal{{ $division->id }}" tabindex="-1" aria-labelledby="editDivisionModalLabel{{ $division->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('admin.divisions.update', $division->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editDivisionModalLabel{{ $division->id }}">Edit Divisi</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="code" class="form-label">Kode Divisi</label>
                                                    <input type="text" class="form-control" id="code" name="code" value="{{ $division->code }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Nama Divisi</label>
                                                    <input type="text" class="form-control" id="name" name="name" value="{{ $division->name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="description" class="form-label">Deskripsi</label>
                                                    <textarea class="form-control" id="description" name="description" rows="3">{{ $division->description }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ $division->is_active ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="is_active">
                                                            Aktif
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Delete Division Modal -->
                            <div class="modal fade" id="deleteDivisionModal{{ $division->id }}" tabindex="-1" aria-labelledby="deleteDivisionModalLabel{{ $division->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('admin.divisions.destroy', $division->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteDivisionModalLabel{{ $division->id }}">Konfirmasi Hapus</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Apakah Anda yakin ingin menghapus divisi <strong>{{ $division->name }}</strong>?</p>
                                                @if($division->members_count > 0 || $division->members->count() > 0)
                                                    <div class="alert alert-warning">
                                                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                                        Divisi ini memiliki {{ $division->members_count ?? $division->members->count() }} anggota. Menghapus divisi ini akan mengubah anggota yang berada dalam divisi ini menjadi tidak memiliki divisi.
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="bi bi-inbox fs-1 text-muted mb-2"></i>
                                        <h5 class="text-muted">Belum ada data divisi</h5>
                                        <p class="text-muted mb-0">Klik tombol "Tambah Divisi" untuk membuat divisi baru</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination if needed -->
            @if(isset($divisions) && $divisions instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="mt-4">
                    {{ $divisions->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Create Division Modal -->
<div class="modal fade" id="createDivisionModal" tabindex="-1" aria-labelledby="createDivisionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.divisions.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createDivisionModalLabel">Tambah Divisi Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="code" class="form-label">Kode Divisi</label>
                        <input type="text" class="form-control" id="code" name="code" required>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Divisi</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                            <label class="form-check-label" for="is_active">
                                Aktif
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection