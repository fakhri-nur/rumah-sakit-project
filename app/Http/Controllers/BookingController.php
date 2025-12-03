<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokter;
use App\Models\Booking;
use App\Models\User;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BookingController extends Controller
{
    public function form() {
        $doctors = Dokter::with('user')->get();
        $selectedDoctorId = request('doctor_id');
        return view('booking', compact('doctors', 'selectedDoctorId'));
    }

    public function submit(Request $request) {
        $booking = Booking::create([
            'patient_name' => $request->patient_name,
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
        ]);

        return redirect()->route('receipt', $booking->id)->with('success', 'Janji temu berhasil dibuat!');
    }

    public function receipt($id)
    {
        $booking = Booking::with('doctor.user')->findOrFail($id);

        $qrCode = QrCode::format('svg')->size(80)->generate($booking->id);

        return view('receipt', compact('booking', 'qrCode'));
    }


    public function downloadReceipt($id)
    {
        $booking = Booking::findOrFail($id);

        // biar qr qode-nya pakai PNG dan bisa di pdf
        $qrCode = base64_encode(
            QrCode::format('png')
    ->size(200)
    ->errorCorrection('H')
    ->generate($booking->id)
        );

        return view('receipt-pdf', compact('booking', 'qrCode'));
    }

    public function downloadPdf($id)
    {
        $booking = Booking::with('doctor.user')->findOrFail($id);

        $qrCodeSvg = QrCode::format('svg')
            ->size(150)
            ->generate($booking->id);

        $qrCode = "data:image/svg+xml;base64," . base64_encode($qrCodeSvg);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('receipt_pdf', compact('booking', 'qrCode'));

        return $pdf->download('receipt_' . $booking->id . '.pdf');
    }

}
