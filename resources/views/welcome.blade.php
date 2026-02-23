<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web-based Unifast Management Information System</title>

    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script>
        document.addEventListener("DOMContentLoaded", function () {
            const modalEl = document.getElementById('welcomeModal');
            const modal = new bootstrap.Modal(modalEl, {
            backdrop: true,
            keyboard: true
            });
            modal.show();
        });
        </script>

 
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}?v={{ time() }}">
</head>

<div class="modal fade" id="welcomeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl welcome-modal-dialog">
    <div class="modal-content welcome-modal-content">

   
      <button type="button" class="btn-close welcome-close" data-bs-dismiss="modal" aria-label="Close"></button>

      <div class="modal-body welcome-modal-body">

 
        <h2 class="welcome-title">Welcome to UniFAST</h2>

        <div class="welcome-logos">
          <img src="{{ asset('assets/img/ifsu.png') }}" alt="IFSU" class="welcome-logo">
          <img src="{{ asset('assets/img/unifastLogoclear.png') }}" alt="Bagong Pilipinas" class="welcome-logo">
        </div>

    
        <p class="welcome-subtext">
          Please click/tap the appropriate link to help you in your navigation of our services
        </p>

  
        <div class="welcome-actions">
          <a href="{{ route('apply.create') }}" class="welcome-btn">Apply For Scholarships</a>
          <a href="#" class="welcome-btn">Check Application Status</a>
        </div>


        <div class="welcome-footer-logos">
          <img src="{{ asset('assets/img/ifsu_awards_certifications.png') }}" alt="IFSU Awards and Certifications" class="welcome-footer-logo">
        </div>

      </div>
    </div>
  </div>
</div>

<body>

<!-- HEADER -->
<header class="topbar">
    <div class="container">
        <div class="row align-items-center">

            <!-- LOGOS -->
            <div class="col-12 col-md-6 d-flex justify-content-center justify-content-md-start align-items-center mb-3 mb-md-0">
                <img src="{{ asset('assets/img/ifsu.png') }}" class="logo-img me-3" alt="IFSU Logo">
                <img src="{{ asset('assets/img/unifastLogoclear.png') }}" class="logo-img" alt="UNIFAST Logo">
            </div>

            <!-- LOGIN BUTTONS -->
            <div class="col-12 col-md-6 d-flex justify-content-center justify-content-md-end flex-wrap gap-2">
                <a href="{{ route('login') }}" class="pill-btn">EMPLOYEE LOGIN</a>
                <a href="{{ route('login') }}" class="pill-btn">STUDENT LOGIN</a>
            </div>

        </div>
    </div>
</header>

<!-- MAIN -->
<main class="welcome-main">
    <div class="container">
        <div class="row align-items-center">

            <!-- SLIDESHOW -->
            <div class="col-12 col-lg-7 mb-4 mb-lg-0">
                <div id="welcomeCarousel"
                     class="carousel slide welcome-carousel"
                     data-bs-ride="carousel"
                     data-bs-interval="2500">

                    <div class="carousel-inner">

                        <div class="carousel-item active">
                            <img src="{{ asset('assets/img/slides/slide1.jpg') }}" class="d-block w-100" alt="Slide 1">
                        </div>

                        <div class="carousel-item">
                            <img src="{{ asset('assets/img/slides/slide2.jpg') }}" class="d-block w-100" alt="Slide 2">
                        </div>

                        <div class="carousel-item">
                            <img src="{{ asset('assets/img/slides/slide3.jpg') }}" class="d-block w-100" alt="Slide 3">
                        </div>

                    </div>

                </div>
            </div>

            <!-- INFO -->
            <div class="col-12 col-lg-5 text-center">
                <h2 class="info-title mb-3">
                    WEB-BASED UNIFAST MANAGEMENT INFORMATION SYSTEM
                </h2>

                <p class="info-line">
                    Efficiently manage and monitor UniFAST grantees.
                </p>

                <p class="info-line">
                    Secure, organized, and centralized data management.
                </p>

                <a href="{{ route('apply.create') }}" class="apply-btn mt-3">
                    APPLY NOW!
                </a>
            </div>

        </div>
    </div>
</main>

<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>