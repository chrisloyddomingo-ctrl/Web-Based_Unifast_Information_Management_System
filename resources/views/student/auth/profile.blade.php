@extends('layouts.student') {{-- change this if your layout file has a different name --}}

@section('content')
@php
    $student = Auth::guard('student')->user();
@endphp

<div class="row">
    <div class="col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile text-center">
                <img class="profile-user-img img-fluid img-circle"
                     src="https://ui-avatars.com/api/?name={{ urlencode($student->name) }}&size=128"
                     alt="Student profile picture">

                <h3 class="profile-username text-center mt-2">{{ $student->name }}</h3>
                <p class="text-muted text-center">Student</p>

                <ul class="list-group list-group-unbordered mb-3 text-left">
                    <li class="list-group-item">
                        <b>Grant Type</b> <span class="float-right">{{ $student->grant_type ?? 'N/A' }}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Status</b> <span class="float-right">{{ $student->status ?? 'Active' }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Student Information</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">Full Name</th>
                        <td>{{ $student->name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $student->email ?? 'N/A' }}</td>
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
                        <th>School</th>
                        <td>{{ $student->school ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Grant Type</th>
                        <td>{{ $student->grant_type ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection