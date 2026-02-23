{{-- resources/views/vendor/adminlte/auth/register.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Web-based Unifast Management System</title>

    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/auth.css') }}" rel="stylesheet">
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-11 col-sm-9 col-md-6 col-lg-5">

            <div class="text-center mb-4">
                <img src="{{ asset('assets/img/logopng.png') }}" class="logo-img" alt="Unifast Logo">
                <h4 class="mt-2 fw-bold mb-0">UNIFAST</h4>
                <small class="text-muted">Web-based Unifast Management System</small>
            </div>

            <div class="card shadow border-0">
                <div class="card-header brand-orange text-white text-center py-3 border-0">
                    <strong>CREATE ACCOUNT</strong>
                </div>

                <div class="card-body p-4">

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text"
                                   name="name"
                                   value="{{ old('name') }}"
                                   class="form-control @error('name') is-invalid @enderror"
                                   required>

                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   class="form-control @error('email') is-invalid @enderror"
                                   required>

                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password"
                                   name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   required>

                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password"
                                   name="password_confirmation"
                                   class="form-control"
                                   required>
                        </div>

                        <button type="submit" class="btn btn-unifast text-white w-100">
                            Register
                        </button>

                        <div class="text-center mt-3">
                            <small class="text-muted">
                                Already have an account?
                                <a href="{{ route('login') }}">Login</a>
                            </small>
                        </div>

                        <div class="text-center mt-2">
                            <a href="{{ url('/') }}" class="small text-muted">← Back to Home</a>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
