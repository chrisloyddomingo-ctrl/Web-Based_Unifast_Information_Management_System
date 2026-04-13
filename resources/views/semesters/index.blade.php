@extends('adminlte::page')

@section('title', 'Manage Semesters')

@section('content_header')
    <h1>Manage Semesters</h1>
@stop

@section('content')

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('semesters.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Semester
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Semester List</h3>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Semester</th>
                        <th>School Year</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Current</th>
                        <th>Application Status</th>
                        <th width="180">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($semesters as $index => $semester)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $semester->semester_name }}</td>
                            <td>{{ $semester->school_year }}</td>
                            <td>{{ $semester->start_date }}</td>
                            <td>{{ $semester->end_date }}</td>
                            <td>
                                @if($semester->is_current)
                                    <span class="badge badge-success">Yes</span>
                                @else
                                    <span class="badge badge-secondary">No</span>
                                @endif
                            </td>
                            <td>
                                @if($semester->application_status == 'open')
                                    <span class="badge badge-primary">Open</span>
                                @else
                                    <span class="badge badge-danger">Closed</span>
                                @endif
                            </td>
                            <td>
                                @if(!$semester->is_current)
                                    <form action="{{ route('semesters.setCurrent', $semester->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Set this as current semester?')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-sm btn-secondary" disabled>
                                        Current
                                    </button>
                                @endif

                                @if($semester->application_status == 'closed')
                                    <form action="{{ route('semesters.openApplication', $semester->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-primary" onclick="return confirm('Open application for this semester?')">
                                            Open
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('semesters.closeApplication', $semester->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-dark" onclick="return confirm('Close application for this semester?')">
                                            Close
                                        </button>
                                    </form>
                                @endif

                                <a href="{{ route('semesters.edit', $semester->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('semesters.destroy', $semester->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this semester?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No semesters found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@stop