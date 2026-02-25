<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Application Status</title>
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
  <div class="card shadow-sm">
    <div class="card-body text-center">
      <h3 class="mb-3">Application Status</h3>

      @if(!$application)
        <div class="alert alert-warning mb-0">
          Wala ka pang application.
          <a href="{{ route('apply.create') }}" class="alert-link">Apply now</a>
        </div>
      @else
        @php
          $status = strtolower($application->status); // status column sa DB
          $badge = match ($status) {
            'pending' => 'bg-warning text-dark',
            'approved' => 'bg-primary',
            'accepted' => 'bg-success',
            default => 'bg-secondary',
          };
        @endphp

        <p class="mb-2">Current Status:</p>
        <span class="badge {{ $badge }} px-4 py-2 text-uppercase">
          {{ $application->status }}
        </span>

        <p class="text-muted mt-3 mb-0">
          Last updated: {{ optional($application->updated_at)->format('F d, Y h:i A') }}
        </p>
      @endif

    </div>
  </div>
</div>

<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>