@extends('landing.layouts.app')

@section('title', 'Kebencanaan & Tanggap Darurat')

@section('content')
    <!-- Masthead-->
    <header class="masthead">
        <div class="container position-relative">
            <div class="row justify-content-center">
                <div class="col-xl-6">
                    <div class="text-center text-white">
                        <!-- Page heading -->
                        <h1 class="mb-3 fw-bold">
                            Kebencanaan &amp; Tanggap Darurat
                        </h1>
                        <p class="lead mb-5">
                            Sistem pendataan warga, kejadian bencana, dan posko darurat
                            untuk mendukung respon cepat, terukur, dan terkoordinasi.
                        </p>

                        <!-- TOMBOL LOGIN PROFESIONAL - HANYA INI YANG DIPERBAIKI -->
                        <div class="mt-5 pt-2">
                            <!-- TOMBOL DENGAN LINK KE HALAMAN LOGIN -->
                            <a href="{{ route('login') }}" class="btn btn-login-custom btn-lg px-5 py-3 rounded-pill shadow-lg text-decoration-none d-inline-flex align-items-center justify-content-center">
                                <i class="bi bi-box-arrow-in-right me-2"></i>
                                <span class="fw-bold fs-5">LOGIN KE SISTEM</span>
                            </a>
                            <p class="text-light mt-3 mb-0 small opacity-75">
                                <i class="bi bi-info-circle me-1"></i>
                                Akses untuk Admin, Petugas, dan Warga terdaftar
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Bagian-bagian lain TETAP SAMA PERSIS -->
    <!-- Icons Grid-->
    <section class="features-icons bg-light text-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
                        <div class="features-icons-icon d-flex">
                            <i class="bi-window m-auto text-primary"></i>
                        </div>
                        <h3>Fully Responsive</h3>
                        <p class="lead mb-0">This theme will look great on any device, no matter the size!</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
                        <div class="features-icons-icon d-flex">
                            <i class="bi-layers m-auto text-primary"></i>
                        </div>
                        <h3>Bootstrap 5 Ready</h3>
                        <p class="lead mb-0">Featuring the latest build of the new Bootstrap 5 framework!</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="features-icons-item mx-auto mb-0 mb-lg-3">
                        <div class="features-icons-icon d-flex">
                            <i class="bi-terminal m-auto text-primary"></i>
                        </div>
                        <h3>Easy to Use</h3>
                        <p class="lead mb-0">Ready to use with your own content, or customize the source files!</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Image Showcases-->
    <section class="showcase">
        <div class="container-fluid p-0">
            <div class="row g-0">
                <div class="col-lg-6 order-lg-2 text-white showcase-img"
                     style="background-image: url('{{ asset('landing/assets/img/bg-showcase-1.jpg') }}')"></div>
                <div class="col-lg-6 order-lg-1 my-auto showcase-text">
                    <h2>Fully Responsive Design</h2>
                    <p class="lead mb-0">
                        When you use a theme created by Start Bootstrap, you know that the theme will look great on any device,
                        whether it's a phone, tablet, or desktop the page will behave responsively!
                    </p>
                </div>
            </div>
            <div class="row g-0">
                <div class="col-lg-6 text-white showcase-img"
                     style="background-image: url('{{ asset('landing/assets/img/bg-showcase-2.jpg') }}')"></div>
                <div class="col-lg-6 my-auto showcase-text">
                    <h2>Updated For Bootstrap 5</h2>
                    <p class="lead mb-0">
                        Newly improved, and full of great utility classes, Bootstrap 5 is leading the way in mobile responsive web development!
                        All of the themes on Start Bootstrap are now using Bootstrap 5!
                    </p>
                </div>
            </div>
            <div class="row g-0">
                <div class="col-lg-6 order-lg-2 text-white showcase-img"
                     style="background-image: url('{{ asset('landing/assets/img/bg-showcase-3.jpg') }}')"></div>
                <div class="col-lg-6 order-lg-1 my-auto showcase-text">
                    <h2>Easy to Use & Customize</h2>
                    <p class="lead mb-0">
                        Landing Page is just HTML and CSS with a splash of SCSS for users who demand some deeper customization options.
                        Out of the box, just add your content and images, and your new landing page will be ready to go!
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials-->
    <section class="testimonials text-center bg-light">
        <div class="container">
            <h2 class="mb-5">What people are saying...</h2>
            <div class="row">
                <div class="col-lg-4">
                    <div class="testimonial-item mx-auto mb-5 mb-lg-0">
                        <img class="img-fluid rounded-circle mb-3"
                             src="{{ asset('landing/assets/img/testimonials-1.jpg') }}" alt="..." />
                        <h5>Margaret E.</h5>
                        <p class="font-weight-light mb-0">"This is fantastic! Thanks so much guys!"</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="testimonial-item mx-auto mb-5 mb-lg-0">
                        <img class="img-fluid rounded-circle mb-3"
                             src="{{ asset('landing/assets/img/testimonials-2.jpg') }}" alt="..." />
                        <h5>Fred S.</h5>
                        <p class="font-weight-light mb-0">
                            "Bootstrap is amazing. I've been using it to create lots of super nice landing pages."
                        </p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="testimonial-item mx-auto mb-5 mb-lg-0">
                        <img class="img-fluid rounded-circle mb-3"
                             src="{{ asset('landing/assets/img/testimonials-3.jpg') }}" alt="..." />
                        <h5>Sarah W.</h5>
                        <p class="font-weight-light mb-0">
                            "Thanks so much for making these free resources available to us!"
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action-->
    <section class="call-to-action text-white text-center" id="signup">
        <div class="container position-relative">
            <div class="row justify-content-center">
                <div class="col-xl-6">
                    <h2 class="mb-4">Ready to get started? Sign up now!</h2>

                    <!-- Form dummy lagi (tidak ke dashboard) -->
                    <form class="form-subscribe" onsubmit="return false;">
                        <div class="row">
                            <div class="col">
                                <input class="form-control form-control-lg"
                                       type="email"
                                       placeholder="Email Address"
                                />
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-primary btn-lg" type="button">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <style>
        /* HANYA STYLE UNTUK TOMBOL LOGIN - TIDAK MENGUBAH STYLE LAIN */
        .btn-login-custom {
            background: linear-gradient(135deg, #0069d9 0%, #0056b3 100%);
            border: none;
            color: white;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            cursor: pointer;
            display: inline-block;
        }

        .btn-login-custom:hover {
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            background: linear-gradient(135deg, #0056b3 0%, #004a99 100%);
        }

        .btn-login-custom:active {
            transform: translateY(0);
        }

        .btn-login-custom::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-login-custom:hover::after {
            left: 100%;
        }
    </style>
@endsection
