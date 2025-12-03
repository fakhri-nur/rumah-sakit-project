@extends('template.app')

@section('content')
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f6f9fc;
    }

    .card-modern {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(8px);
        border: none;
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
    }

    .page-title {
        font-weight: 600;
        color: #1e3a8a;
    }

    .btn-modern {
        border-radius: 10px;
        transition: all 0.2s ease;
    }

    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 12px rgba(0, 0, 0, 0.1);
    }

    .table th {
        background-color: #f0f4f8 !important;
    }

    .table-hover tbody tr:hover {
        background-color: #eef6ff;
    }

    .dataTables_length select {
        border-radius: 8px;
        padding: 4px 10px;
        border: 1px solid #d0d7de;
        background-color: white;
    }

    .dataTables_filter input {
        border-radius: 8px;
        padding: 6px 10px;
        border: 1px solid #d0d7de;
    }

    .dataTables_info {
        font-size: 0.9rem;
        color: #6c757d;
        margin-top: 10px;
    }

    .dataTables_paginate {
        margin-top: 10px !important;
    }

    .dataTables_paginate .paginate_button {
        border: none !important;
        background: transparent !important;
        color: #1e3a8a !important;
        font-weight: 500;
        border-radius: 50% !important;
        transition: all 0.2s ease;
        margin: 0 4px;
        padding: 6px 12px;
    }

    .dataTables_paginate .paginate_button:hover {
        background-color: #e3edff !important;
        color: #0d47a1 !important;
    }

    .dataTables_paginate .paginate_button.current {
        background-color: #1e3a8a !important;
        color: #fff !important;
        font-weight: 600;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

</style>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="page-title"><i class="bi bi-clipboard-data me-2"></i>Data Petugas</h4>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.users.trash') }}" class="btn btn-outline-success btn-modern">
                <i class="bi bi-trash3 me-1"></i> Data Sampah
            </a>
            <a href="{{ route('admin.users.export') }}" class="btn btn-outline-primary btn-modern">
                <i class="bi bi-file-earmark-excel me-1"></i> Export (.xlsx)
            </a>
            <a href="{{ route('admin.users.create') }}" class="btn btn-success btn-modern">
                <i class="bi bi-plus-circle me-1"></i> Tambah Admin
            </a>
        </div>
    </div>

    <div class="card card-modern">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center" id="usersTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Petugas</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $key => $user)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->role == 'admin')
                                        <span class="badge bg-success">Admin</span>
                                    @elseif($user->role == 'dokter')
                                        <span class="badge bg-primary">Dokter</span>
                                    @elseif($user->role == 'user')
                                        <span class="badge bg-secondary text-dark">User</span>
                                    @else
                                        {{ $user->role }}
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('admin.users.edit', $user->id)}}"
                                           class="btn btn-warning text-white btn-sm btn-modern">
                                           <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm btn-modern">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    $(function() {
        $('#usersTable').DataTable({
            dom: '<"d-flex justify-content-between align-items-center mb-3"lf>rt<"d-flex justify-content-between align-items-center"ip>',
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari data...",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_–_END_ dari _TOTAL_ data"
            }
        });
    });
</script>
@endpush
