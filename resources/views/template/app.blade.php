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
    <style>
        :root {
            --blue: #3a7bd5;
            --blue-light: #5eb8ff;
            --dark: #1b2a41;
            --gray: #6c7b8b;
            --white-glass: rgba(255, 255, 255, 0.85);
        }

        body {
            font-family: "Poppins", sans-serif;
            background-color: #f3f7fb;
        }

        .navbar {
            background: var(--white-glass);
            backdrop-filter: blur(12px);
            border-bottom: 1.8px solid rgba(58, 123, 213, 0.2);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        }

        .nav-link {
            font-weight: 550;
            font-size: 1rem;
            color: var(--dark) !important;
            transition: all 0.3s ease;
            border-radius: 9px;
            padding: 8px 14px;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--blue) !important;
            background: rgba(58, 123, 213, 0.08);
        }

        .btn-login-blue {
            border: 1.8px solid #3a7bd5;
            color: #3a7bd5;
            background: transparent;
            transition: all 0.3s ease;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(58, 123, 213, 0.15);
        }

        .btn-login-blue:hover {
            background: linear-gradient(135deg, #3a7bd5, #5eb8ff);
            color: #fff;
            transform: translateY(-2px);
        }

        .btn-signup-blue {
            background: linear-gradient(135deg, #5eb8ff, #3a7bd5);
            color: #fff;
            border: none;
            transition: all 0.3s ease;
            border-radius: 5px;
            box-shadow: 0 3px 12px rgba(94, 184, 255, 0.3);
        }

        .btn-signup-blue:hover {
            background: linear-gradient(135deg, #3a7bd5, #5eb8ff);
            transform: translateY(-2px);
            box-shadow: 0 5px 16px rgba(58, 123, 213, 0.5);
        }

        .footer-modern {
            background: linear-gradient(135deg, #3a7bd5, #5eb8ff);
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        .footer-modern::before {
            content: "";
            position: absolute;
            top: -80px;
            right: -100px;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.07);
            border-radius: 50%;
            filter: blur(60px);
        }

        .footer-link {
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .footer-link:hover {
            color: #fff;
            padding-left: 4px;
        }

        .social-link {
            color: #fff;
            font-size: 1.2rem;
            background: rgba(255, 255, 255, 0.1);
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .social-link:hover {
            background: #fff;
            color: #3a7bd5;
            transform: translateY(-3px);
        }

        .footer-bottom {
            background: rgba(0, 0, 0, 0.1);
            color: #f0f0f0;
            font-size: 0.9rem;
        }
    </style>


</head>

<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm sticky-top">
        <div class="container py-2">

            <a class="navbar-brand fw-bold text-uppercase" href="#">
                <div class="d-flex flex-column lh-1">
                    <span style="color: #3a7bd5;">RUMAH SAKIT</span>
                    <span class="fs-4" style="color: #5eb8ff;">DOA BAPAK</span>
                    <span class="fs-6" style="color: #6c7b8b;">GROUP</span>
                </div>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-start ms-4" id="navbarNav">
                <ul class="navbar-nav fw-semibold">
                    @if (Auth::check() && Auth::user()->role == 'admin')
                        <li class="nav-item"><a class="nav-link px-3" href="{{route('admin.dashboard')}}">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link px-3" href="{{route('admin.iklan.index')}}">Data
                                Iklan</a></li>
                        <li class="nav-item"><a class="nav-link px-3" href="{{route('admin.dokter.index')}}">Data
                                Dokter</a></li>
                        <li class="nav-item"><a class="nav-link px-3" href="{{route('admin.users.index')}}">Data
                                User</a></li>
                    @elseif (Auth::check() && Auth::user()->role == 'dokter')
                        <li class="nav-item"><a class="nav-link px-3" href="{{route('dokter.dashboard')}}">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link px-3" href="{{route('dokter.edit_profile')}}">Edit Data Dokter</a></li>
                        <li class="nav-item">
                            <a href="{{ route('caridok') }}" class="nav-link mx-2">Cari Dokter</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{route('home')}}" class="nav-link active mx-2">Beranda</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link mx-2" href="#center">Center of Excellence</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link mx-2" href="#promo">Promo & Paket</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link mx-2" href="#artikel">Artikel</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('caridok') }}" class="nav-link mx-2">Cari Dokter</a>
                        </li>
                    @endif
                </ul>
            </div>

            <div class="d-flex align-items-center gap-2 ms-auto">
                @if (Auth::check())
                    <a href="{{ route('logout') }}" class="btn btn-danger fw-semibold px-4">Logout</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-login-blue px-4 fw-semibold">Login</a>
                    <a href="{{ route('sign_up') }}" class="btn btn-signup-blue px-4 fw-semibold">Sign Up</a>
                @endif
            </div>

        </div>
    </nav>



    @yield('content')
    {{-- datatable --}}
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
<footer class="footer-modern text-white mt-auto">
    <div class="container py-5">
        <div class="row gy-4">
            <div class="col-lg-4 col-md-6">
                <h4 class="fw-bold mb-3 text-uppercase">
                    <span style="color:#fff;">RUMAH SAKIT</span>
                    <span style="color:#a6d1ff;">DOA BAPAK</span>
                </h4>
                <p class="text-light opacity-75">
                    Kami berkomitmen memberikan pelayanan kesehatan terbaik dengan teknologi modern dan tenaga medis profesional.
                </p>
            </div>

            <div class="col-lg-3 col-md-6">
                <h5 class="fw-semibold mb-3">Hubungi Kami</h5>
                <p class="mb-1"><i class="fas fa-phone me-2"></i> (021) 555-1234</p>
                <p class="mb-1"><i class="fas fa-envelope me-2"></i> info@rsdoabapak.com</p>
                <p><i class="fas fa-map-marker-alt me-2"></i> Jl. Sukasakit No.10, Sidoarjo</p>
            </div>

            <div class="col-lg-3 col-md-6 text-md-start text-center">
                <h5 class="fw-semibold mb-3">Ikuti Kami</h5>
                <div class="d-flex justify-content-md-start justify-content-center gap-3">
                    <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom text-center py-3 mt-4">
        © 2025 <span class="fw-semibold">RS DOA BAPAK GROUP</span>
    </div>
</footer>

</html>
