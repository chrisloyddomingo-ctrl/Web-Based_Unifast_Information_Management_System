@extends('adminlte::page')

@section('title', 'New Grantees')

@section('content')
<div class="container">

    <div class="row mb-3">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0">New Grantees</h4>
                </div>

                <div class="card-body">
                    @if($newGrantees->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Student ID</th>
                                        <th>Full Name</th>
                                        <th>Sex</th>
                                        <th>Program</th>
                                        <th>Year Level</th>
                                        <th>Contact Number</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($newGrantees as $index => $student)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $student->student_id }}</td>
                                            <td>
                                                {{ $student->last_name }},
                                                {{ $student->given_name }}
                                                {{ $student->middle_name ?? '' }}
                                                {{ $student->ext_name ?? '' }}
                                            </td>
                                            <td>{{ $student->sex }}</td>
                                            <td>{{ $student->program_name }}</td>
                                            <td>{{ $student->year_level }}</td>
                                            <td>{{ $student->contact_number }}</td>
                                            <td>{{ $student->email }}</td>
                                            <td>
                                                <span class="badge bg-success">
                                                    {{ ucfirst($student->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info mb-0">
                            No new grantees found.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
@stop