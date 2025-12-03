@extends('template.app')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #2196f3, #00bcd4);
        font-family: "Poppins", sans-serif;
    }

    .user-form-card {
        background: #ffffff;
        border-radius: 15px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        width: 100%;
        max-width: 800px;
        margin: 60px auto;
        padding: 3rem;
        animation: fadeIn 1s ease-in-out;
    }

    .form-title {
        text-align: center;
        font-weight: 600;
        font-size: 1.8rem;
        color: #0d6efd;
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 500;
        color: #333;
    }

    .form-control {
        border-radius: 10px;
        padding: 12px 16px;
        border: 1px solid #ced4da;
        transition: all 0.3s ease;
        font-size: 1rem;
    }

    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
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

    .breadcrumb-container {
        text-align: center;
        color: #fff;
        margin-top: 40px;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
        .user-form-card {
            max-width: 90%;
            padding: 2rem;
        }
    }
</style>

<div class="user-form-card">
    <h2 class="form-title">Buat Data Pengguna</h2>

    @if (Session::get('failed'))
        <div class="alert alert-danger text-center">
            {{ Session::get('failed') }}
        </div>
    @endif

    <form action="{{ route('admin.users.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Masukkan nama pengguna" value="{{ old('name') }}">
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Alamat Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="contoh@email.com" value="{{ old('email') }}">
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Kata Sandi</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Masukkan password" value="{{ old('password') }}">
            @error('password')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn-submit">Simpan Data</button>
        </div>
    </form>
</div>
@endsection
