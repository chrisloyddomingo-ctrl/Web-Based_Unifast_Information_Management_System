@extends('adminlte::page')

@section('title', 'Edit Semester')

@section('content_header')
    <h1>Edit Semester</h1>
@stop

@section('content')

    <div class="card">
        <div class="card-body">
            <form action="{{ route('semesters.update', $semester->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Semester Name</label>
                    <input type="text" name="semester_name" class="form-control" value="{{ old('semester_name', $semester->semester_name) }}">
                    @error('semester_name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>School Year</label>
                    <input type="text" name="school_year" class="form-control" value="{{ old('school_year', $semester->school_year) }}">
                    @error('school_year')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Start Date</label>
                    <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $semester->start_date) }}">
                    @error('start_date')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>End Date</label>
                    <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $semester->end_date) }}">
                    @error('end_date')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Semester
                </button>

                <a href="{{ route('semesters.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
            </form>
        </div>
    </div>

@stop