@extends('template.app')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #42a5f5, #26c6da);
        font-family: "Poppins", sans-serif;
    }

    .login-card {
        background: #ffffff;
        border-radius: 15px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        width: 100%;
        max-width: 650px;
        margin: 80px auto;
        padding: 3.5rem 4rem;
        animation: fadeIn 0.8s ease-in-out;
    }

    .login-card h3 {
        color: #0d6efd;
        font-weight: 600;
        text-align: center;
        margin-bottom: 2rem;
        font-size: 2rem;
    }

    .form-label {
        font-weight: 500;
        color: #333;
        margin-bottom: 6px;
        display: block;
    }

    .form-control {
        border-radius: 10px;
        padding: 14px 16px;
        border: 1px solid #ced4da;
        transition: all 0.3s ease;
        font-size: 1.05rem;
    }

    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    .btn-primary {
        background-color: #0d6efd;
        border: none;
        border-radius: 30px;
        padding: 14px 35px;
        font-weight: 600;
        width: 100%;
        font-size: 1.1rem;
        transition: 0.3s;
    }

    .btn-primary:hover {
        background-color: #0b5ed7;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(13, 110, 253, 0.4);
    }

    .text-center a {
        color: #0d6efd;
        text-decoration: none;
        font-weight: 500;
    }

    .text-center a:hover {
        text-decoration: underline;
    }

    .alert {
        border-radius: 10px;
    }

    .form-check-label {
        font-weight: 500;
        color: #333;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
        .login-card {
            max-width: 90%;
            padding: 2rem;
        }
    }
</style>

<div class="login-card">
    @if (Session::get('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif
    @if (Session::get('error'))
        <div class="alert alert-danger">{{ Session::get('error') }}</div>
    @endif

    <h3>Masuk ke Akun Anda</h3>

    <form method="POST" action="{{ route('login.auth') }}">
        @csrf

        <div class="mb-3">
            <label for="form2Example1" class="form-label">Email</label>
            <input type="email" id="form2Example1" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Masukkan email Anda" />
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="form2Example2" class="form-label">Kata Sandi</label>
            <input type="password" id="form2Example2" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Masukkan kata sandi" />
            @error('password')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="form2Example34" checked />
                <label class="form-check-label" for="form2Example34">Ingat saya</label>
            </div>
            <a href="#!" class="small">Lupa kata sandi?</a>
        </div>

        <button type="submit" class="btn btn-primary">Masuk</button>

        <div class="text-center mt-4">
            <p>Belum punya akun? <a href="#!">Daftar</a></p>
        </div>
    </form>
</div>
@endsection
