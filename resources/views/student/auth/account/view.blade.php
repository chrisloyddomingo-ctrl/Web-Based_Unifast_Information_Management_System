@extends('layouts.student')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="mb-3">
            <h1 class="h3">View My Account</h1>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mb-0">
                        <tr>
                            <th width="30%">Full Name</th>
                            <td>{{ $student->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $student->email }}</td>
                        </tr>
                        <tr>
                            <th>Course</th>
                            <td>{{ $student->course ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Year Level</th>
                            <td>{{ $student->year_level ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Grant Type</th>
                            <td>{{ $student->grant_type ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>{{ $student->status ?? 'Active' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection