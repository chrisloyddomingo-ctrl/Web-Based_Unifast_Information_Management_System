<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Application Submitted</title>

  <link rel="stylesheet" href="{{ asset('css/application.css') }}?v={{ time() }}" />
</head>
<body>
  <main class="wrap">

    <header class="header header-top">
      <div class="logos-left">
        <img src="{{ asset('assets/img/ifsu.png') }}" alt="IFSU Logo" class="Ifsulogo">
        <img src="{{ asset('assets/img/unifastLogoclear.png') }}" alt="UNIFAST Logo" class="Unifastlogo">
      </div>

      <h1 class="header-title">Application Submitted</h1>
    </header>

    <section class="card">

      {{-- STATUS MESSAGE --}}
      @if(isset($application) && $application->status === 'approved')
        <div class="alert success" style="margin-bottom: 12px;">
          Congratulations! Your application has been <b>APPROVED</b>.
        </div>

      @elseif(isset($application) && $application->status === 'rejected')
        <div class="alert danger" style="margin-bottom: 12px;">
          Sorry, your application was <b>REJECTED</b>.
        </div>

      @elseif(isset($application) && $application->status === 'pending')
        <div class="alert warning" style="margin-bottom: 12px;">
          Your application is <b>PENDING</b> Goodluck!
        </div>

        <p style="margin: 0 0 10px;">
          Please wait for approval of the CHED. Kindly monitor official announcements for further updates.
        </p>

        <ul style="margin: 0; padding-left: 18px;">
          <li>Keep your contact number and email active.</li>
          <li>Check UniFAST and school announcements regularly.</li>
          <li>Prepare your documents in case verification is required.</li>
        </ul>

      @else
        {{-- if no record found or status is empty/unknown --}}
        <div class="alert warning" style="margin-bottom: 12px;">
           Application record not found or status not set yet. Please contact the admin.
        </div>
      @endif

      <div class="actions" style="margin-top: 16px;">
        <a href="{{ route('apply.create') }}" class="btn secondary">Back to Application Form</a>
        <a href="{{ url('/') }}" class="btn">Back to Home</a>
      </div>
    </section>

    <footer class="footer">
      <small>© Web-Based UniFAST Management System</small>
    </footer>

  </main>
</body>
</html>