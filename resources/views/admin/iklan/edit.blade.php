@extends('template.app')

@section('content')
<div class="w-75 mx-auto my-5">
    <h3>Edit Iklan</h3>
    <form action="{{ route('admin.iklan.update', $iklan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Nama Iklan --}}
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Iklan</label>
            <input
                type="text"
                name="nama"
                class="form-control @error('nama') is-invalid @enderror"
                value="{{ old('nama', $iklan->nama) }}"
                placeholder="Masukkan nama iklan">
            @error('nama')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Gambar Iklan --}}
        <div class="mb-3">
            <label for="gambar" class="form-label">Gambar Iklan</label><br>
            @if($iklan->gambar)
                <img src="{{ asset('storage/' . $iklan->gambar) }}" width="150" class="rounded mb-2">
            @endif
            <input
                type="file"
                name="gambar"
                class="form-control @error('gambar') is-invalid @enderror"
                accept="image/*">
            <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar.</small>
            @error('gambar')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Keterangan --}}
        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea
                name="keterangan"
                class="form-control @error('keterangan') is-invalid @enderror"
                rows="5"
                placeholder="Tambahkan keterangan iklan (opsional)">{{ old('keterangan', $iklan->keterangan) }}</textarea>
            @error('keterangan')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('admin.iklan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
