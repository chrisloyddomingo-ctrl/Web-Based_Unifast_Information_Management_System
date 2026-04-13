{{-- resources/views/auth/passwords/reset.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | Web-based Unifast Management Information System</title>

    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}?v={{ time() }}">
</head>
<body>

    <header class="topbar">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-md-6 d-flex justify-content-center justify-content-md-start align-items-center mb-3 mb-md-0">
                    <img src="{{ asset('assets/img/ifsu.png') }}" class="logo-img me-3" alt="IFSU Logo">
                    <img src="{{ asset('assets/img/unifastLogoclear.png') }}" class="logo-img" alt="UNIFAST Logo">
                </div>
            </div>
        </div>
    </header>

    <main class="welcome-main">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-11 col-sm-9 col-md-6 col-lg-5">

                    <div class="card shadow border-0">
                        <div class="card-header brand-orange text-white text-center py-3 border-0">
                            <strong>Reset Password</strong>
                        </div>

                        <div class="card-body p-4">

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    Please check the form and try again.
                                </div>
                            @endif

                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf

                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input
                                        id="email"
                                        type="email"
                                        name="email"
                                        value="{{ $email ?? old('email') }}"
                                        class="form-control @error('email') is-invalid @enderror"
                                        required
                                        autofocus
                                    >

                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">New Password</label>
                                    <input
                                        id="password"
                                        type="password"
                                        name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        required
                                    >

                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password-confirm" class="form-label">Confirm Password</label>
                                    <input
                                        id="password-confirm"
                                        type="password"
                                        name="password_confirmation"
                                        class="form-control"
                                        required
                                    >
                                </div>

                                <button type="submit" class="btn btn-unifast text-white w-100">
                                    Reset Password
                                </button>

                                <div class="text-center mt-3">
                                    <a href="{{ route('login') }}" class="small text-muted text-decoration-none">
                                        ← Back to Login
                                    </a>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <footer class="bottombar">
        <div class="container">
            <div class="footer">
                <small>© Web-Based UniFAST Information Management System</small>
            </div>
        </div>
    </footer>

    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>