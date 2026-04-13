@extends('adminlte::page')

@section('title', 'Add Semester')

@section('content_header')
    <h1>Add New Semester</h1>
@stop

@section('content')

    <div class="card">
        <div class="card-body">
            <form action="{{ route('semesters.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Semester Name</label>
                    <input type="text" name="semester_name" class="form-control" placeholder="e.g. 1st Semester" value="{{ old('semester_name') }}">
                    @error('semester_name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>School Year</label>
                    <input type="text" name="school_year" class="form-control" placeholder="e.g. 2025-2026" value="{{ old('school_year') }}">
                    @error('school_year')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Start Date</label>
                    <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}">
                    @error('start_date')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>End Date</label>
                    <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}">
                    @error('end_date')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Save Semester
                </button>

                <a href="{{ route('semesters.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
            </form>
        </div>
    </div>

@stop