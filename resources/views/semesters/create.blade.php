@extends('adminlte::page')

@section('title', 'Add Semester')

@section('content_header')
    <div class="semester-form-header">
        <div>
            <h1 class="semester-form-title">Add New Semester</h1>
        </div>
        <div>
            <a href="{{ route('semesters.index') }}" class="btn btn-semester-back">
                <i class="fas fa-arrow-left mr-1"></i> Back to List
            </a>
        </div>
    </div>
@stop

@section('content')

    <div class="card semester-form-card">
        <div class="card-header semester-form-card-header">
            <h3 class="card-title semester-form-card-title">
                <i class="fas fa-plus-circle mr-2"></i> Semester Information
            </h3>
        </div>

        <div class="card-body semester-form-card-body">
            <form action="{{ route('semesters.store') }}" method="POST">
                @csrf

                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="semester-label">Semester Name</label>
                            <input
                                type="text"
                                name="semester_name"
                                class="form-control semester-input @error('semester_name') is-invalid @enderror"
                                placeholder="e.g. 1st Semester"
                                value="{{ old('semester_name') }}"
                            >
                            @error('semester_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="semester-label">School Year</label>
                            <input
                                type="text"
                                name="school_year"
                                class="form-control semester-input @error('school_year') is-invalid @enderror"
                                placeholder="e.g. 2025-2026"
                                value="{{ old('school_year') }}"
                            >
                            @error('school_year')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="semester-label">Start Date</label>
                            <input
                                type="date"
                                name="start_date"
                                class="form-control semester-input @error('start_date') is-invalid @enderror"
                                value="{{ old('start_date') }}"
                            >
                            @error('start_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="semester-label">End Date</label>
                            <input
                                type="date"
                                name="end_date"
                                class="form-control semester-input @error('end_date') is-invalid @enderror"
                                value="{{ old('end_date') }}"
                            >
                            @error('end_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                </div>

                <div class="semester-form-actions">
                    <button type="submit" class="btn btn-semester-save">
                        <i class="fas fa-save mr-1"></i> Save Semester
                    </button>

                    <a href="{{ route('semesters.index') }}" class="btn btn-semester-cancel">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

@stop

@section('css')
<style>
    .semester-form-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        flex-wrap: wrap;
        margin-bottom: 18px;
    }

    .semester-form-title {
        margin: 0;
        font-size: 1.8rem;
        font-weight: 700;
        color: #2f2f2f;
    }

    .semester-form-subtitle {
        margin: 6px 0 0;
        color: #6c757d;
        font-size: 0.95rem;
    }

    .btn-semester-back {
        background: #ffffff;
        color: #ff7a00 !important;
        border: 1px solid #ffd2a8;
        border-radius: 10px;
        padding: 10px 16px;
        font-weight: 600;
        transition: 0.2s ease-in-out;
    }

    .btn-semester-back:hover,
    .btn-semester-back:focus {
        background: #fff4ea;
        color: #e56d00 !important;
    }

    .semester-form-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
        overflow: hidden;
    }

    .semester-form-card-header {
        background: linear-gradient(135deg, #fff7f0, #ffffff);
        border-bottom: 1px solid #f1e4d8;
        padding: 16px 20px;
    }

    .semester-form-card-title {
        margin: 0;
        font-size: 1.05rem;
        font-weight: 700;
        color: #2f2f2f;
    }

    .semester-form-card-body {
        padding: 24px;
    }

    .semester-label {
        font-weight: 700;
        color: #444;
        margin-bottom: 8px;
    }

    .semester-input {
        height: 44px;
        border-radius: 10px;
        border: 1px solid #dcdfe3;
        box-shadow: none !important;
    }

    .semester-input:focus {
        border-color: #ff9b47;
        box-shadow: 0 0 0 0.15rem rgba(255, 122, 0, 0.12) !important;
    }

    .semester-form-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 10px;
    }

    .btn-semester-save {
        background: linear-gradient(135deg, #ff8a00, #ff6a00);
        color: #fff !important;
        border: none;
        border-radius: 10px;
        padding: 10px 18px;
        font-weight: 600;
        box-shadow: 0 8px 18px rgba(255, 122, 0, 0.18);
        transition: 0.2s ease-in-out;
    }

    .btn-semester-save:hover,
    .btn-semester-save:focus {
        background: linear-gradient(135deg, #f57c00, #e65c00);
        color: #fff !important;
        transform: translateY(-1px);
    }

    .btn-semester-cancel {
        background: #6c757d;
        color: #fff !important;
        border: none;
        border-radius: 10px;
        padding: 10px 18px;
        font-weight: 600;
    }

    .btn-semester-cancel:hover,
    .btn-semester-cancel:focus {
        background: #5a6268;
        color: #fff !important;
    }

    @media (max-width: 768px) {
        .semester-form-title {
            font-size: 1.45rem;
        }

        .semester-form-card-body {
            padding: 18px;
        }
    }
</style>
@stop