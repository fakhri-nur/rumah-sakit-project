<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .receipt-card {
            max-width: 480px;
            width: 100%;
            background: #ffffff;
            border: 1px solid #e5e5e5;
            border-radius: 20px;
            padding: 20px 20px 30px;
            margin: 0 auto;
        }
        .text-center { text-align: center; }
        .mb-4 { margin-bottom: 1.5rem; }
        .fw-bold { font-weight: bold; }
        .text-muted { color: #6c757d; }
        .small { font-size: 0.875rem; }

        .receipt-section { margin-bottom: 1rem; }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            font-size: 14px;
        }
        .info-row span { color: #6c757d; }

        .qr-wrapper {
            margin-top: 20px;
            text-align: center;
            padding-top: 10px;
            border-top: 1px dashed #d0d0d0;
        }
        .qr-wrapper img {
            margin-top: 10px;
            width: 120px;
            height: 120px;
        }
    </style>
</head>
<body>
    <div class="receipt-card">
        <div class="text-center mb-4">
            <h4 class="fw-bold mb-1">Struk Booking Janji Temu</h4>
            <p class="text-muted small m-0">
                Terima kasih telah melakukan pendaftaran, silahkan tunjukkan struk ini kepada staff Rumah Sakit.
            </p>
        </div>

        <div class="receipt-section mb-3">
            <div class="info-row">
                <span>No.Id:</span>
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

        <div class="qr-wrapper">
            <div class="small text-muted">Scan QR Code untuk verifikasi</div>
            <img src="{{ $qrCode }}" alt="QR Code">
        </div>

    </div>
</body>
</html>
