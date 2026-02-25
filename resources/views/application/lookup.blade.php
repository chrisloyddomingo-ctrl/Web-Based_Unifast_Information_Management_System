<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <title>Check Application Status</title>
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
</head>

<body class="bg-light">
<div class="container-fluid py-4 py-md-5">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
            <div class="card shadow-sm">
                <div class="card-body p-3 p-sm-4 p-md-5">

                    <h3 class="mb-4 text-center">Check Application Status</h3>

                    <form method="GET" action="{{ route('application.status') }}">
                        <div class="mb-3">
                            <label for="student_id" class="form-label">Student ID Number</label>
                            <input
                                id="student_id"
                                type="text"
                                name="student_id"
                                class="form-control form-control-lg"
                                required
                                inputmode="numeric"
                                autocomplete="off"
                                value="{{ request('student_id') }}"
                            >
                        </div>

                        <div class="d-grid d-sm-flex justify-content-sm-center">
                            <button type="submit" class="btn btn-primary w-100 w-sm-auto px-sm-5 bg-warning">
                                Check Status
                            </button>
                        </div>
                    </form>

                    @if(request()->filled('student_id'))
                        <hr class="my-4">

                        @if(!$application)
                            <div class="alert alert-danger mt-3 mb-0">
                                No application found for Student ID:
                                <strong class="text-break">{{ request('student_id') }}</strong>
                            </div>
                        @else
                            @php
                                $status = strtolower($application->status ?? 'pending');
                                $badge = match ($status) {
                                    'pending' => 'bg-warning text-dark',
                                    'approved' => 'bg-primary',
                                    'accepted' => 'bg-success',
                                    'disapproved', 'rejected' => 'bg-danger',
                                    default => 'bg-secondary',
                                };
                            @endphp

                            <div class="text-center mt-4">
                                <h5 class="mb-3">Application Status:</h5>

                                <span class="badge {{ $badge }} px-4 py-2 text-uppercase fs-6">
                                    {{ $application->status ?? 'Pending' }}
                                </span>

                                <p class="text-muted mt-3 mb-0">
                                    Last updated:
                                    {{ optional($application->updated_at)->format('F d, Y h:i A') }}
                                </p>
                            </div>
                        @endif
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>