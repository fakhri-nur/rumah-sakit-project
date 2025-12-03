@extends('template.app')

@section('content')
<div class="container my-5">

    <form action="{{ route('caridok.search') }}" method="get">
        @csrf
        <div class="row align-items-center g-2">
            <div class="col-10">
                <input type="text" name="search_doctor" placeholder="Cari nama dokter"
                    value="{{ request('search_doctor') }}" class="form-control shadow-sm">
            </div>
            <div class="col-2">
                <button type="submit" class="btn btn-primary w-100 shadow-sm">Cari</button>
            </div>
        </div>
    </form>

    <hr class="my-4">

    <div class="d-flex align-items-center mb-3">
        <div class="fw-bold d-flex align-items-center gap-2">
            <i class="fa-solid fa-user-md"></i>
            <h5 class="m-0">Daftar Dokter</h5>
        </div>

        {{-- <a href="{{ route('booking.form') }}"
            class="btn btn-primary btn-sm px-3 ms-auto shadow-sm"
            style="font-size: 13px; border-radius: 20px;">
            Booking
        </a> --}}
    </div>

    {{-- FILTER KATEGORI --}}
    <div class="d-flex gap-2 flex-wrap mb-4">
        <a href="{{ route('caridok.search', ['category' => 'all']) }}"
            class="btn rounded-pill {{ request('category') == 'all' ? 'btn-primary text-white shadow-sm' : 'btn-outline-secondary' }}">
            Semua Dokter
        </a>

        <a href="{{ route('caridok.search', ['category' => 'Umum']) }}"
            class="btn rounded-pill {{ request('category') == 'Umum' ? 'btn-primary text-white shadow-sm' : 'btn-outline-secondary' }}">
            Umum
        </a>

        <a href="{{ route('caridok.search', ['category' => 'Spesialis']) }}"
            class="btn rounded-pill {{ request('category') == 'Spesialis' ? 'btn-primary text-white shadow-sm' : 'btn-outline-secondary' }}">
            Spesialis
        </a>

        <a href="{{ route('caridok.search', ['category' => 'ibu dan anak']) }}"
            class="btn rounded-pill {{ request('category') == 'ibu dan anak' ? 'btn-primary text-white shadow-sm' : 'btn-outline-secondary' }}">
            Ibu dan Anak
        </a>
    </div>

<div class="row g-4">
    @foreach ($doctors as $doctor)
    <div class="col-12 col-md-6">
        <div class="doctor-card-new shadow-sm p-3 rounded-4 d-flex align-items-center">

            <div class="doctor-photo-wrapper me-3">
                <img src="{{ $doctor->photo ? asset('storage/' . $doctor->photo) : asset('images/default-doctor.png') }}"
                     alt="{{ $doctor->user->name }}"
                     class="doctor-photo rounded-circle">
            </div>

            <div class="grow">
                <h5 class="fw-semibold mb-1">{{ $doctor->user->name }}</h5>

                <span class="badge specialty-badge px-3 py-2">
                    <i class="fa-solid fa-stethoscope me-1"></i>
                    {{ $doctor->user->specialty }}
                </span>
            </div>

            <a href="{{ route('booking.form', ['doctor_id' => $doctor->id]) }}"
               class="btn btn-light btn-sm rounded-pill shadow-sm ms-auto">
               <i class="fa-solid fa-calendar-check"></i>
            </a>
        </div>
    </div>
    @endforeach
</div>
</div>

<style>
    .doctor-card-new {
        border: 1px solid #eaeaea;
        background: #ffffff;
        transition: .25s ease;
        border-left: 6px solid #007bff20;
    }

    .doctor-card-new:hover {
        transform: translateY(-4px);
        border-left: 6px solid #0d6efd;
        box-shadow: 0 8px 18px rgba(0,0,0,0.08) !important;
    }

    .doctor-photo-wrapper {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        padding: 3px;
        background: linear-gradient(135deg, #0d6efd, #6ea8fe);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .doctor-photo {
        width: 63px;
        height: 63px;
        object-fit: cover;
        border-radius: 50%;
    }

    .specialty-badge {
        background: #f0f7ff;
        color: #0d6efd;
        font-size: 12px;
        font-weight: 600;
        border-radius: 20px;
    }

    @media (max-width: 576px) {
        .doctor-card-new {
            padding: 15px;
        }

        .doctor-photo-wrapper {
            width: 60px;
            height: 60px;
        }

        .doctor-photo {
            width: 55px;
            height: 55px;
        }
    }
</style>



@endsection
