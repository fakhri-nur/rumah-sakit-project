@extends('template.app')

@section('content')
    <div class="container mt-5">
        @if (Session::get('success'))
            <div class="alert alert-success my-3">
                {{ Session::get('success') }}
            </div>
        @endif

        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('admin.iklan.index') }}" class="btn btn-secondary">Kembali</a>
        </div>

        <h3 class="mb-3">Data Iklan Terhapus</h3>

        <table class="table table-bordered table-striped align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>No.</th>
                    <th>Gambar</th>
                    <th>Nama Iklan</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($iklanTrash as $key => $iklan)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>
                            @if ($iklan->gambar)
                                <img src="{{ asset('storage/' . $iklan->gambar) }}" width="80" class="rounded shadow-sm">
                            @else
                                <span class="text-muted">Tidak ada gambar</span>
                            @endif
                        </td>
                        <td>{{ $iklan->nama }}</td>
                        <td>{{ $iklan->keterangan ?? '-' }}</td>
                        <td class="d-flex justify-content-center gap-2">
                            <form action="{{ route('admin.iklan.restore', $iklan->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success btn-sm">Kembalikan</button>
                            </form>
                            <form action="{{ route('admin.iklan.delete_permanent', $iklan->id) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus permanen iklan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus Permanen</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Tidak ada data iklan terhapus</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
