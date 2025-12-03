<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Rumah Sakit</title>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.1.0/mdb.min.css" rel="stylesheet" />
    {{-- cdn jquery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.damin.css">
<head>
    <style>
        .receipt-card {
            max-width: 480px;
            width: 100%;
            background: #ffffff;
            border: 1px solid #e5e5e5;
            border-radius: 20px;
            position: relative;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            font-size: 14px;
        }

        .info-row span {
            color: #6c757d;
        }

        .qr-wrapper {
            background: #f4f8ff;
            border: 1px solid #dce6f7;
            width: fit-content;
        }

        .qr-img {
            width: 170px;
            height: 170px;
            display: block;
        }
    </style>
</head>
<body>

<div class="container my-5 d-flex justify-content-center">
    <div class="receipt-card shadow-lg p-4 rounded-4">

        <div class="text-center mb-4">
            <h4 class="fw-bold mb-1">Struk Booking Janji Temu</h4>
            <p class="text-muted small m-0">Terima kasih telah melakukan pendaftaran</p>
        </div>

        <div class="receipt-section mb-3">
            <div class="info-row">
                <span>No.Id :</span>
                <strong>{{ $booking->id }}</strong>
            </div>

            <div class="info-row">
                <span>Nama Pasien</span>
                <strong>{{ $booking->patient_name }}</strong>
            </div>

            <div class="info-row">
                <span>Dokter</span>
                <strong>{{ $booking->doctor->user->name }}</strong>
            </div>

            <div class="info-row">
                <span>Spesialis</span>
                <strong>{{ $booking->doctor->specialty }}</strong>
            </div>

            <div class="info-row">
                <span>Tanggal</span>
                <strong>{{ $booking->appointment_date }}</strong>
            </div>

            <div class="info-row">
                <span>Waktu</span>
                <strong>{{ $booking->appointment_time }}</strong>
            </div>
        </div>

        <hr>

        <div class="qr-code position-absolute bottom-0 end-0 p-2">
            {{ $qrCode }}
        </div>

        <div class="text-center">
            <a href="{{ route('booking.form') }}" class="btn btn-primary px-4 py-2 rounded-pill me-2">
                Kembali
            </a>
            <a href="{{ route('receipt.pdf', $booking->id) }}" class="btn btn-success px-4 py-2 rounded-pill">
                Download PDF
            </a>
        </div>

    </div>
</div>

<script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>
<!-- MDB -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"
    integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous">
</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.1.0/mdb.umd.min.js"></script>
@stack('script')
</body>
</html>

