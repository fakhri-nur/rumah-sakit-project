@extends('template.app')

@section('content')
    <div class="row g-1 justify-content-center">
        <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2500">
            <div class="carousel-inner">
                @foreach ($iklans as $index => $iklan)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <img src="{{ asset('storage/' . $iklan->gambar) }}" class="d-block w-100 carousel-img"
                            alt="Iklan {{ $index + 1 }}">
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <section class="container py-5">
        <h2 class="section-title" id="center">Center of Excellence</h2>

        <div class="row g-4">
            <div class="col-md-3">
                <div class="card service-card">
                    <img src="{{ asset('storage/home/jantung.jpeg') }}" />
                    <div class="card-body">
                        <h5>Pondok Indah Health Centre</h5>
                        <p>Layanan spesialis jantung terbaik untuk pasien.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card service-card">
                    <img src="{{ asset('storage/home/skin.jpeg') }}" />
                    <div class="card-body">
                        <h5>Skin & Aesthetic Clinic</h5>
                        <p>Perawatan kulit modern & profesional.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card service-card">
                    <img src="{{ asset('storage/home/ortho.jpg') }}" />
                    <div class="card-body">
                        <h5>Orthopedic Center</h5>
                        <p>Solusi cedera tulang & otot.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card service-card">
                    <img src="{{ asset('storage/home/bidan.png') }}" />
                    <div class="card-body">
                        <h5>Klinik Kebidanan</h5>
                        <p>Layanan kehamilan & persalinan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container py-5" id="promo">
        <h2 class="section-title">Promo & Paket</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card">
                    <img class="border-radius" src="{{ asset('storage/home/bayi tabung.png') }}" />
                    <div class="card-body">
                        <h5>Program Bayi Tabung Bisa Cicilan 0% hingga 6 bulan dengan Kartu Kredit Mandiri</h5>
                        <p>Promo program bayi tabung (IVF) di RS Pondok Indah IVF Centre menjadi lebih ringan
                            menggunakan kartu kredit Mandiri.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <img class="border-radius" src="{{ asset('storage/home/kedua.png') }}" />
                    <div class="card-body">
                        <h5>Program Bayi Tabung Bisa Cicilan 0% hingga 6 bulan dengan Kartu Kredit HSBC</h5>
                        <p>Promo program bayi tabung (IVF) di RS Pondok Indah IVF Centre menjadi lebih ringan
                            menggunakan kartu kredit HSBC.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <img class="border-radius" src="{{ asset('storage/home/ketiga.png') }}" />
                    <div class="card-body">
                        <h5>Private Parenting Class - Puri Indah
                        </h5>
                        <p>Kelas Newborn (Newborn Care) di Jakarta Barat bagi orang tua untuk melatih merawat bayi yang
                            baru lahir, mulai dari cara memandikan, menggendong, hingga menyusui.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container py-5" id="artikel">
        <h2 class="section-title">Artikel Kesehatan</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card">
                    <img src="{{ asset('storage/home/maxresdefault.jpg') }}"" />
                    <div class="card-body">
                        <h5>Tips Cegah Diabetes</h5>
                        <p>8 Cara Mencegah Diabetes Melitus yang Bisa Diterapkan Sejak Dini</p>
                        <a href="https://www.siloamhospitals.com/informasi-siloam/artikel/cara-mencegah-diabetes"
                            class="btn btn-outline-primary">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <img
                        src="https://mysiloam-api.siloamhospitals.com/public-asset/website-cms/website-cms-16801862312083656.webp" />
                    <div class="card-body">
                        <h5>Pertolongan Pertama Cedera</h5>
                        <p>Cara pertolongan Pertama pada Cedera Saat Berolahraga dengan benar.</p>
                        <a href="https://www.siloamhospitals.com/informasi-siloam/artikel/pertolongan-pertama-pada-cedera-saat-berolahraga"
                            class="btn btn-outline-primary">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <img
                        src="https://res.cloudinary.com/dk0z4ums3/image/upload/v1751425270/attached_image/manajemen-stres-cara-jitu-agar-hidup-lebih-tenang-0-alodokter.jpg" />
                    <div class="card-body">
                        <h5>Manajemen Stres</h5>
                        <p>Manajemen Stres, Cara Jitu agar Hidup Lebih Tenang</p>
                        <a href="https://www.alodokter.com/manajemen-stres-cara-jitu-agar-hidup-lebih-tenang"
                            class="btn btn-outline-primary">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .carousel-img {
            max-height: 700px;
            object-fit: cover;
        }

        @media (max-width: 768px) {
            .carousel-img {
                max-height: 250px;
            }
        }

        /* === PERBAIKAN AGAR CARD SEJAJAR === */
        .service-card,
        .card {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .card img,
        .service-card img {
            height: 200px;
            object-fit: cover;
            width: 100%;
            border-radius: 10px 10px 0 0;
        }

        .card-body {
            flex-grow: 1;
        }

        .border-radius {
            border-radius: 10px;
            width: 100%;
            height: auto;
            object-fit: cover;
        }
    </style>
@endsection
