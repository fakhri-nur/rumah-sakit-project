@extends('template.app')

@section('content')
<div class="container my-5">
    <h3 class="mb-4">Form Booking Janji Temu</h3>

    <form action="{{ route('booking.submit') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="patient_name" class="form-label">Nama Pasien</label>
            <input type="text" class="form-control" id="patient_name" name="patient_name" required>
        </div>

        <div class="mb-3">
            <label for="doctor_id" class="form-label">Pilih Dokter</label>
            <select class="form-select" id="doctor_id" name="doctor_id" required>
                @foreach ($doctors as $doctor)
                    <option value="{{ $doctor->id }}" {{ isset($selectedDoctorId) && $selectedDoctorId == $doctor->id ? 'selected' : '' }}>
                        {{ $doctor->user ? $doctor->user->name : 'Unknown' }} - {{ $doctor->specialty }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="appointment_date" class="form-label">Tanggal Janji Temu</label>
            <input type="date" class="form-control" id="appointment_date" name="appointment_date" required>
        </div>

        <div class="mb-3">
            <label for="appointment_time" class="form-label">Waktu Janji Temu</label>
            <input type="time" class="form-control" id="appointment_time" name="appointment_time" required>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
