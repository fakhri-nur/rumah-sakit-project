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

    .iklan-img {
        border-radius: 10px;
        transition: 0.3s ease;
    }

    .iklan-img:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    }

    /* DataTables Custom */
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

    .dataTables_paginate .paginate_button {
        border: none !important;
        background: transparent !important;
        color: #1e3a8a !important;
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
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

</style>

<div class="container py-4">
    
    @if (Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-3" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ Session::get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="page-title"><i class="bi bi-badge-ad me-2"></i>Daftar Iklan</h4>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.iklan.trash') }}" class="btn btn-outline-success btn-modern">
                <i class="bi bi-trash3 me-1"></i> Data Sampah
            </a>
            <a href="{{ route('admin.iklan.export') }}" class="btn btn-outline-primary btn-modern">
                <i class="bi bi-file-earmark-excel me-1"></i> Export (.xlsx)
            </a>
            <a href="{{ route('admin.iklan.create') }}" class="btn btn-primary btn-modern">
                <i class="bi bi-plus-circle me-1"></i> Tambah Iklan
            </a>
        </div>
    </div>

    {{-- Card Table --}}
    <div class="card card-modern">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center" id="iklanTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Nama Iklan</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($iklan as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    @if ($item->gambar)
                                        <img src="{{ asset('storage/' . $item->gambar) }}" width="100" height="70" class="iklan-img shadow-sm">
                                    @else
                                        <span class="text-muted fst-italic">Tidak ada gambar</span>
                                    @endif
                                </td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->keterangan ?? '-' }}</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('admin.iklan.edit', $item->id) }}"
                                           class="btn btn-warning text-white btn-sm btn-modern">
                                           <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.iklan.delete', $item->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus iklan ini?')">
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
        $('#iklanTable').DataTable({
            dom: '<"d-flex justify-content-between align-items-center mb-3"lf>rt<"d-flex justify-content-between align-items-center"ip>',
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari iklan...",
                lengthMenu: "Tampilkan _MENU_ data",
                info: ""
            }
        });
    });
</script>
@endpush
