@extends('template.app')

@section('content')
    <div class="mt-5 w-75 d-block m-auto">
        @if (Session::get('failed'))
            <div class="alert alert-danger">
                {{ Session::get('failed') }}
            </div>
        @endif
    </div>

    <div class="card w-75 mx-auto my-5 p-4">
        <h5 class="text-center my-3">Edit Data Dokter</h5>

        <form action="{{ route('admin.dokter.update', $user->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input type="text"
                    class="form-control @error('name') is-invalid @enderror"
                    name="name"
                    value="{{ old('name', $user->name) }}">

                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Alamat Email</label>
                <input type="email"
                    class="form-control @error('email') is-invalid @enderror"
                    name="email"
                    value="{{ old('email', $user->email) }}">

                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Kata Sandi (Opsional)</label>
                <input type="password"
                    class="form-control @error('password') is-invalid @enderror"
                    name="password">

                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label for="specialty" class="form-label">Spesialisasi</label>
                <input type="text"
                    class="form-control @error('specialty') is-invalid @enderror"
                    name="specialty"
                    value="{{ old('specialty', $dokter->specialty ?? '') }}">

                @error('specialty') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label for="photo" class="form-label">Foto Profil</label>
                <input type="file"
                    class="form-control @error('photo') is-invalid @enderror"
                    name="photo"
                    accept="image/*">

                @if($dokter && $dokter->photo)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $dokter->photo) }}"
                             width="100"
                             height="100"
                             style="object-fit: cover"
                             class="rounded">

                        <small class="text-muted d-block">Foto saat ini</small>
                    </div>
                @endif

                @error('photo') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update Data</button>
        </form>
    </div>
@endsection
