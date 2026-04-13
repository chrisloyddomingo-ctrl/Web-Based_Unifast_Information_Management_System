@extends('adminlte::page')

@section('title', 'Rejected Applications')

@section('content_header')
<h1>Rejected Applications</h1>
@stop

@section('content')

<div class="card">

<div class="card-header d-flex justify-content-between align-items-center">
    <h3 class="card-title mb-0">Rejected Students</h3>

    <a href="{{ url()->previous() }}" class="btn btn-sm btn-secondary">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<div class="card-body">

@if($applications->count() > 0)

<table class="table table-bordered table-hover">

<thead class="bg-danger text-white">
<tr class="text-center">
<th>#</th>
<th>Student ID</th>
<th>Name</th>
<th>Program</th>
<th>Year</th>
<th>Email</th>
<th>Status</th>
</tr>
</thead>

<tbody>

@foreach($applications as $app)

<tr class="text-center">

<td>{{ $loop->iteration }}</td>
<td>{{ $app->student_id }}</td>
<td>{{ $app->given_name }} {{ $app->last_name }}</td>
<td>{{ $app->program_name }}</td>
<td>{{ $app->year_level }}</td>
<td>{{ $app->email }}</td>
<td><span class="badge badge-danger">REJECTED</span></td>

</tr>

@endforeach

</tbody>

</table>

{{ $applications->links() }}

@else

<div class="alert alert-info text-center">
No rejected applications.
</div>

@endif

</div>
</div>

@stop