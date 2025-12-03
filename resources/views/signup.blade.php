@extends('template.app')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #42a5f5, #26c6da);
        font-family: "Poppins", sans-serif;
    }

    .signup-card {
        background: #ffffff;
        border-radius: 15px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        width: 100%;
        max-width: 700px;
        margin: 80px auto;
        padding: 3.5rem 4rem;
        animation: fadeIn 0.8s ease-in-out;
    }

    .signup-card h3 {
        color: #0d6efd;
        font-weight: 600;
        margin-bottom: 2rem;
        text-align: center;
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
        font-size: 1.1rem;
        width: 100%;
        transition: 0.3s;
    }

    .btn-primary:hover {
        background-color: #0b5ed7;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(13, 110, 253, 0.4);
    }

    .form-check-label {
        font-weight: 500;
        color: #333;
    }

    .alert {
        border-radius: 10px;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
        .signup-card {
            max-width: 90%;
            padding: 2rem;
        }
    }
</style>

<div class="signup-card">
    @if (Session::get('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif
    @if (Session::get('error'))
        <div class="alert alert-danger">{{ Session::get('error') }}</div>
    @endif

    <h3>Daftar Akun Baru</h3>

    <form method="POST" action="{{ route('sign_up.add') }}">
        @csrf

        <div class="row mb-4">
            <div class="col-md-6">
                <label for="form3Example1" class="form-label">Nama Depan</label>
                <input type="text" id="form3Example1" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{old('first_name')}}" placeholder="Nama depan" />
                @error('first_name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="form3Example2" class="form-label">Nama Belakang</label>
                <input type="text" id="form3Example2" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{old('last_name')}}" placeholder="Nama belakang" />
                @error('last_name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="form3Example3" class="form-label">Email</label>
            <input type="email" id="form3Example3" class="form-control @error('email') is-invalid @enderror" name="email" value="{{old('email')}}" placeholder="Masukkan email Anda" />
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="form3Example4" class="form-label">Kata Sandi</label>
            <input type="password" id="form3Example4" class="form-control @error('password') is-invalid @enderror" name="password" value="{{old('password')}}" placeholder="Masukkan kata sandi" />
            @error('password')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-check d-flex justify-content-center mb-4">
            <input class="form-check-input me-2" type="checkbox" id="form2Example33" checked />
            <label class="form-check-label" for="form2Example33">
                Berlangganan newsletter kami
            </label>
        </div>

        <button type="submit" class="btn btn-primary">Daftar</button>

        <div class="text-center mt-4">
            <p>Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
        </div>
    </form>
</div>
@endsection
