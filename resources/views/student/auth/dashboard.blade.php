<!doctype html>
<html>
<head>
    <title>Student Dashboard</title>
</head>
<body>
    <h1>Student Dashboard</h1>
    <p>Welcome, {{ $student->name }} ({{ $student->email }})</p>

    <form method="POST" action="{{ route('student.logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>