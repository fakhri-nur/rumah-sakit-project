@extends('template.app')
@section('content')
    <div class="container mt-5">
        @if (Session::get('success'))
            <div class="alert alert-success my-3">
                {{ Session::get('success') }}
            </div>

        @endif
        <div class="d-flex justify-content-end">
            <a href="{{ route('admin.users.index')}}" class="btn btn-secondary">Kembali</a>
        </div>
        <h3 class="my-3">Data User Terhapus</h3>
        <table class="table table-bordered">
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
            @foreach ($users as $key => $user)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td class="d-flex">
                        <form action="{{ route('admin.users.restore', $user->id)}}" method="POST">
                            @csrf
                            @method('patch')
                            <button type="submit" class="btn btn-warning ms-2">Kembalikan</button>
                        </form>
                        <form action="{{ route('admin.users.delete_permanent', $user->id)}}" method="POST">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger ms-2">Hapus permanen</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
