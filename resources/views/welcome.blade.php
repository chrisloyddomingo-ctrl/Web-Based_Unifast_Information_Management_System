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
            <a href="{{ route('apply.options') }}" class="welcome-btn">Apply For Scholarships</a>
            <a href="{{ route('application.status') }}" class="welcome-btn">Check Application Status</a>
          </div>

          <div class="welcome-footer-logos">
            <img src="{{ asset('assets/img/ifsu_awards_certifications.png') }}" alt="IFSU Awards and Certifications" class="welcome-footer-logo">
          </div>
        </div>
      </div>
    </div>
  </div>


  <header class="topbar topbar--nav sticky-top">
    <div class="container">
      <div class="row align-items-center g-2">

        <!-- LEFT: Logos -->
        <div class="col-12 col-lg-3 d-flex justify-content-center justify-content-lg-start align-items-center">
          <img src="{{ asset('assets/img/ifsu.png') }}" class="logo-img me-3" alt="IFSU Logo">
          <img src="{{ asset('assets/img/unifastLogoclear.png') }}" class="logo-img" alt="UNIFAST Logo">
        </div>

        <!-- MIDDLE: One-page Nav -->
        <div class="col-12 col-lg-6">
          <nav class="page-nav d-flex justify-content-center">
            <a class="page-nav-link" href="#home">Home</a>
            <a class="page-nav-link" href="#about">About</a>
            <a class="page-nav-link" href="#features">Features</a>
            <a class="page-nav-link" href="#location">Location</a>
          </nav>
        </div>

        <!-- RIGHT: Sign in buttons -->
        <div class="col-12 col-lg-3 d-flex justify-content-center justify-content-lg-end flex-wrap gap-2">
          <a href="{{ route('login') }}" class="pill-btn">EMPLOYEE SIGN IN</a>
          <a href="{{ route('student.login') }}" class="pill-btn">STUDENT SIGN IN</a>
        </div>

      </div>
    </div>
  </header>

  <!-- MAIN -->
  <main class="welcome-main">

    <!-- HOME SECTION -->
    <section id="home" class="section-anchor">
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
                          class="active" aria-current="true" aria-label="Slide 0"></button>
                  <button type="button" data-bs-target="#welcomeCarousel" data-bs-slide-to="1"
                          aria-label="Slide 1"></button>
                  <button type="button" data-bs-target="#welcomeCarousel" data-bs-slide-to="2"
                          aria-label="Slide 2"></button>
                  <button type="button" data-bs-target="#welcomeCarousel" data-bs-slide-to="3"
                          aria-label="Slide 3"></button>
                  <button type="button" data-bs-target="#welcomeCarousel" data-bs-slide-to="4"
                          aria-label="Slide 4"></button>
                  <button type="button" data-bs-target="#welcomeCarousel" data-bs-slide-to="5"
                          aria-label="Slide 5"></button>  
                  <button type="button" data-bs-target="#welcomeCarousel" data-bs-slide-to="6"
                          aria-label="Slide 6"></button>
                  <button type="button" data-bs-target="#welcomeCarousel" data-bs-slide-to="7"
                          aria-label="Slide 7"></button>                      
                </div>

                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img src="{{ asset('assets/img/slides/background.png') }}" class="d-block w-100" alt="Slide 0">
                  </div>
                  <div class="carousel-item">
                    <img src="{{ asset('assets/img/slides/pic1.jpg') }}" class="d-block w-100" alt="Slide 1">
                  </div>
                  <div class="carousel-item">
                    <img src="{{ asset('assets/img/slides/pic2.jpg') }}" class="d-block w-100" alt="Slide 2">
                  </div>
                    <div class="carousel-item">
                    <img src="{{ asset('assets/img/slides/pic3.jpg') }}" class="d-block w-100" alt="Slide 3">
                  </div>
                  <div class="carousel-item">
                    <img src="{{ asset('assets/img/slides/pic4.jpg') }}" class="d-block w-100" alt="Slide 4">
                  </div>
                  <div class="carousel-item">
                    <img src="{{ asset('assets/img/slides/pic5.jpg') }}" class="d-block w-100" alt="Slide 5">
                  </div>
                  <div class="carousel-item">
                    <img src="{{ asset('assets/img/slides/pic6.jpg') }}" class="d-block w-100" alt="Slide 6">
                  </div>
                  <div class="carousel-item">
                    <img src="{{ asset('assets/img/slides/pic7.jpg') }}" class="d-block w-100" alt="Slide 7">
                  </div>
                </div>

              </div>
            </div>
          </div>

          <!-- INFO CARD -->
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
                <a href="{{ route('apply.options') }}" class="apply-btn">
                  APPLY NOW!
                </a>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- ABOUT SECTION -->
    <section id="about" class="section-anchor">
      <div class="container py-5">
        <div class="content-card p-4">
          <h3 class="mb-3">About</h3>
          <p class="mb-0">
            This system helps manage UniFAST scholarship processes—application, monitoring, and reporting—
            with secure and centralized data management for better tracking and transparency.
          </p>
        </div>
      </div>
    </section>

    <!--FEATURES SECTION -->
    <section id="features" class="section-anchor">
      <div class="container py-5">
        <div class="content-card p-4">
          <h3 class="mb-3">Features</h3>
          <div class="row g-3">
            <div class="col-12 col-md-4">
              <div class="feature-box p-3 h-100">
                <h6 class="mb-2">Application Management</h6>
                <p class="mb-0">Streamlined submission and tracking of scholarship applications.</p>
              </div>
            </div>
            <div class="col-12 col-md-4">
              <div class="feature-box p-3 h-100">
                <h6 class="mb-2">Monitoring & Reports</h6>
                <p class="mb-0">View status, generate summaries, and monitor grantee data efficiently.</p>
              </div>
            </div>
            <div class="col-12 col-md-4">
              <div class="feature-box p-3 h-100">
                <h6 class="mb-2">Secure & Centralized</h6>
                <p class="mb-0">Organized records and controlled access for employees/students.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- LOCATION SECTION -->
    <section id="location" class="section-anchor">
      <div class="container py-5">
        <div class="content-card p-4">
          <h3 class="mb-3">Location</h3>
          <p class="mb-3">Ifugao State University <br>
            Nayon, Lamut, Ifugao <br>
            CCS Building, ABB Second Floor
          </p>

          <div class="ratio ratio-16x9">
            <iframe
              src="https://www.google.com/maps?q=Ifugao%20State%20University&output=embed"
              loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"
              title="Map">
            </iframe>
          </div>
        </div>
      </div>
    </section>

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
      // Show welcome modal
      const modalEl = document.getElementById('welcomeModal');
      const modal = new bootstrap.Modal(modalEl, { backdrop: true, keyboard: true });
      modal.show();

      // Smooth scroll for header nav
      document.querySelectorAll('a.page-nav-link[href^="#"]').forEach(link => {
        link.addEventListener('click', function (e) {
          const targetId = this.getAttribute('href');
          const targetEl = document.querySelector(targetId);
          if (!targetEl) return;

          e.preventDefault();

          const headerH = document.querySelector('.topbar--nav')?.offsetHeight || 0;
          const y = targetEl.getBoundingClientRect().top + window.pageYOffset - headerH - 10;

          window.scrollTo({ top: y, behavior: 'smooth' });
        });
      });
    });
  </script>
</body>
</html>