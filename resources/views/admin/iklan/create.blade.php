@extends('template.app')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #42a5f5, #26c6da);
        font-family: "Poppins", sans-serif;
    }

    .iklan-form-card {
        background: #ffffff;
        border-radius: 15px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        width: 100%;
        max-width: 800px;
        margin: 60px auto;
        padding: 3rem;
        animation: fadeIn 0.8s ease-in-out;
    }

    .form-title {
        text-align: center;
        font-weight: 600;
        font-size: 1.8rem;
        color: #0d6efd;
        margin-bottom: 2rem;
    }

    .form-group label {
        font-weight: 500;
        color: #333;
        margin-bottom: 6px;
        display: block;
    }

    .form-control {
        border-radius: 10px;
        padding: 12px 14px;
        border: 1px solid #ced4da;
        transition: all 0.3s ease;
        font-size: 1rem;
    }

    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    textarea.form-control {
        resize: none;
    }

    .btn-submit {
        background-color: #0d6efd;
        border: none;
        border-radius: 30px;
        color: #fff;
        font-weight: 600;
        padding: 12px 35px;
        font-size: 1.05rem;
        transition: 0.3s;
    }

    .btn-submit:hover {
        background-color: #0b5ed7;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(13, 110, 253, 0.4);
    }

    .btn-secondary {
        border-radius: 30px;
        font-weight: 500;
        padding: 12px 35px;
        transition: 0.3s;
    }

    .btn-secondary:hover {
        background-color: #6c757d;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(108, 117, 125, 0.4);
    }

    .alert {
        border-radius: 10px;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
        .iklan-form-card {
            max-width: 90%;
            padding: 2rem;
        }
    }
</style>

<div class="iklan-form-card">
    <h2 class="form-title">Tambah Iklan Baru</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi Kesalahan!</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.iklan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group mb-3">
            <label for="nama">Nama Iklan</label>
            <input type="text" name="nama" class="form-control" placeholder="Masukkan nama iklan" required>
        </div>

        <div class="form-group mb-3">
            <label for="gambar">Gambar Iklan</label>
            <input type="file" name="gambar" class="form-control" accept="image/*" required>
        </div>

        <div class="form-group mb-3">
            <label for="keterangan">Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="4" placeholder="Tambahkan keterangan (opsional)"></textarea>
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn-submit">Simpan</button>
            <a href="{{ route('admin.iklan.index') }}" class="btn btn-secondary ms-2">Kembali</a>
        </div>
    </form>
</div>
@endsection
