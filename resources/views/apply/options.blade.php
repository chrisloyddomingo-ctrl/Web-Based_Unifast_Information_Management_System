<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Application Type</title>

    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/option-page.css') }}?v={{ time() }}">
    
</head>
<body>

    <header class="topbar topbar--nav">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3 header-logos">
                    <img src="{{ asset('assets/img/unifastLogoclear.png') }}" alt="UniFAST Logo" class="logo-img">
                    <img src="{{ asset('assets/img/ifsu.png') }}" alt="IFSU Logo" class="ifsu-logo">
                </div>

                <a href="{{ url('/') }}" class="apply-btn">
                    <i class="fas fa-arrow-left me-2"></i> Back to Welcome Page
                </a>
            </div>
        </div>
    </header>

    <main class="option-main">
        <div class="container">
            <div class="content-card content-card--option">
                <div class="option-header">
                    <div class="option-badge">
                        <i class="fas fa-file-signature"></i>
                    </div>

                    <h1 class="info-title">Select Grant Type</h1>
                </div>

                <div class="option-body">
                    <a href="{{ route('apply.create') }}" class="choice-card">
                        <div class="choice-content">
                            <div class="choice-left">
                                <div class="choice-icon tes-icon">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>
                                <div>
                                    <div class="choice-title">TES Application</div>
                                    <p class="choice-desc">
                                        Apply for the Tertiary Education Subsidy scholarship program.
                                    </p>
                                </div>
                            </div>
                            <div class="choice-arrow">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('apply.tdp.create') }}" class="choice-card">
                        <div class="choice-content">
                            <div class="choice-left">
                                <div class="choice-icon tdp-icon">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <div>
                                    <div class="choice-title">TDP Application</div>
                                    <p class="choice-desc">
                                        Apply for the Tulong Dunong Program scholarship.
                                    </p>
                                </div>
                            </div>
                            <div class="choice-arrow">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </div>
                    </a>

                    <div class="option-footer">
                        <a href="{{ url('/') }}" class="apply-btn">
                            <i class="fas fa-home me-2"></i> Return to Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="bottombar">
        <div class="container">
            <p class="footer-note mb-0">
                © {{ date('Y') }} UniFAST Information Management System. All rights reserved.
            </p>
        </div>
    </footer>

    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>