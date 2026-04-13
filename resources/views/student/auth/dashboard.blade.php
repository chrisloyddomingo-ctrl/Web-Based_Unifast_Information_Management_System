@extends('layouts.student')

@section('content')

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                    <div>
                        <h3 class="fw-bold mb-1">Welcome, {{ $student->name ?? 'Student' }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                             style="width: 60px; height: 60px;">
                            <i class="fas fa-id-card fa-lg"></i>
                        </div>
                    </div>
                    <div>
                        <p class="text-muted mb-1">Student ID</p>
                        <h5 class="fw-bold mb-0">{{ $student->student_id ?? 'N/A' }}</h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center"
                             style="width: 60px; height: 60px;">
                            <i class="fas fa-book fa-lg"></i>
                        </div>
                    </div>
                    <div>
                        <p class="text-muted mb-1">Course/Program</p>
                        <h5 class="fw-bold mb-0">{{ $application->program_name ?? 'N/A' }}</h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center"
                             style="width: 60px; height: 60px;">
                            <i class="fas fa-graduation-cap fa-lg"></i>
                        </div>
                    </div>
                    <div>
                        <p class="text-muted mb-1">Year Level</p>
                        <h5 class="fw-bold mb-0">{{ $application->year_level ?? 'N/A' }}</h5>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Student Summary</h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <p class="text-muted mb-1">Full Name</p>
                            <p class="fw-semibold mb-0">{{ $student->name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <p class="text-muted mb-1">Course</p>
                            <p class="fw-semibold mb-0">{{ $application->program_name ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection