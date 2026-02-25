<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Web-based Unifast Management Information System</title>

  <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/welcome.css') }}?v={{ time() }}">
</head>

<body>

  <!-- MODAL -->
  <div class="modal fade" id="welcomeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl welcome-modal-dialog">
      <div class="modal-content welcome-modal-content">
        <button type="button" class="btn-close welcome-close" data-bs-dismiss="modal" aria-label="Close"></button>

        <div class="modal-body welcome-modal-body">
          <h2 class="info-title info-title--modal">
            WEB-BASED <span class="orange-accent">UNIFAST</span> INFORMATION MANAGEMENT SYSTEM
          </h2>

          <div class="welcome-logos">
            <img src="{{ asset('assets/img/ifsu.png') }}" alt="IFSU" class="welcome-logo">
            <img src="{{ asset('assets/img/unifastLogoclear.png') }}" alt="Ched Unifast" class="welcome-logo">
          </div>

          <p class="welcome-subtext">
            Please click/tap the appropriate link to help you in your navigation of our services
          </p>

          <div class="welcome-actions">
            <a href="{{ route('apply.create') }}" class="welcome-btn">Apply For Scholarships</a>
            <a href="{{ route('application.status') }}" class="welcome-btn">Check Application Status</a>
          </div>

          <div class="welcome-footer-logos">
            <img src="{{ asset('assets/img/ifsu_awards_certifications.png') }}" alt="IFSU Awards and Certifications" class="welcome-footer-logo">
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- HEADER -->
  <header class="topbar">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-12 col-md-6 d-flex justify-content-center justify-content-md-start align-items-center mb-3 mb-md-0">
          <img src="{{ asset('assets/img/ifsu.png') }}" class="logo-img me-3" alt="IFSU Logo">
          <img src="{{ asset('assets/img/unifastLogoclear.png') }}" class="logo-img" alt="UNIFAST Logo">
        </div>

        <div class="col-12 col-md-6 d-flex justify-content-center justify-content-md-end flex-wrap gap-2">
          <a href="{{ route('login') }}" class="pill-btn">EMPLOYEE LOGIN</a>
          <a href="{{ route('student.login') }}" class="pill-btn">STUDENT LOGIN</a>
        </div>
      </div>
    </div>
  </header>

  <!-- MAIN -->
  <main class="welcome-main">
    <div class="container py-4">
      <div class="row g-4 align-items-start">

        <!-- SLIDESHOW CARD -->
        <div class="col-12 col-lg-7">
          <div class="content-card content-card--carousel">
            <div id="welcomeCarousel" class="carousel carousel-fade welcome-carousel"
                 data-bs-ride="carousel" data-bs-interval="3200" data-bs-touch="true">

              <!-- Indicators -->
              <div class="carousel-indicators">
                <button type="button" data-bs-target="#welcomeCarousel" data-bs-slide-to="0"
                        class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#welcomeCarousel" data-bs-slide-to="1"
                        aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#welcomeCarousel" data-bs-slide-to="2"
                        aria-label="Slide 3"></button>
              </div>

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
        </div>

        <!-- INFO CARD (✅ centered vertically & horizontally) -->
        <div class="col-12 col-lg-5 info-col">
          <div class="content-card content-card--info text-center d-flex flex-column justify-content-center">
            <h2 class="info-title mb-3">
              WEB-BASED UNIFAST MANAGEMENT INFORMATION SYSTEM
            </h2>

            <p class="info-line mb-2">
              Efficiently manage and monitor UniFAST grantees.
            </p>
            <p class="info-line mb-4">
              Secure, organized, and centralized data management.
            </p>

            <div>
              <a href="{{ route('apply.create') }}" class="apply-btn">
                APPLY NOW!
              </a>
            </div>
          </div>
        </div>

      </div>
    </div>
  </main>

  <!-- FOOTER -->
  <footer class="bottombar">
    <div class="container">
      <div class="footer">
         <small>© Web-Based UniFAST Information Management System</small>
      </div>
    </div>
  </footer>

  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const modalEl = document.getElementById('welcomeModal');
      const modal = new bootstrap.Modal(modalEl, { backdrop: true, keyboard: true });
      modal.show();
    });
  </script>
</body>
</html>