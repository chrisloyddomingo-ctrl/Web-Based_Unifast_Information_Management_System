@extends('adminlte::page')

@section('title', 'Scan Attendance')

@section('content_header')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
        <div>
            <h1 class="mb-1">Scan Attendance</h1>
            <p class="text-muted mb-0">Select an event, then scan the student's barcode or enter the student ID manually.</p>
        </div>

        <div class="mt-3 mt-md-0">
            <a href="{{ route('attendance.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left mr-1"></i> Back
            </a>
        </div>
    </div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-lg-7 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-barcode mr-2"></i> Barcode Scanner
                    </h3>
                </div>

                <form id="scanForm" method="POST">
                    @csrf

                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle mr-1"></i>
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ session('error') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if(session('info'))
                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                <i class="fas fa-info-circle mr-1"></i>
                                {{ session('info') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-times-circle mr-1"></i>
                                Please check the input fields.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="mb-4">
                            <label for="event_id" class="font-weight-bold">Select Event</label>
                            <select name="event_id" id="event_id" class="form-control" required>
                                <option value="">-- Select Event --</option>
                                @foreach($events as $event)
                                    <option value="{{ $event->id }}">
                                        {{ $event->event_name }}{{ $event->event_date ? ' - ' . \Carbon\Carbon::parse($event->event_date)->format('F d, Y') : '' }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted mt-2">
                                Choose the event where attendance will be recorded.
                            </small>
                        </div>

                        <div class="mb-4">
                            <label for="student_id" class="font-weight-bold">Student ID / Barcode</label>
                            <div class="input-group input-group-lg">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-id-card"></i>
                                    </span>
                                </div>
                                <input
                                    type="text"
                                    name="student_id"
                                    id="student_id"
                                    class="form-control @error('student_id') is-invalid @enderror"
                                    placeholder="Scan barcode here"
                                    value="{{ old('student_id') }}"
                                    autocomplete="off"
                                    autofocus
                                    required
                                >
                            </div>
                            @error('student_id')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror

                            <small class="form-text text-muted mt-2">
                                Tip: Most barcode scanners automatically type the value here and submit with Enter.
                            </small>
                        </div>

                        <div class="row text-center">
                            <div class="col-12 col-md-4 mb-3 mb-md-0">
                                <div class="border rounded p-3 h-100 bg-light">
                                    <i class="fas fa-qrcode fa-2x text-primary mb-2"></i>
                                    <h6 class="mb-1">Fast Scanning</h6>
                                    <small class="text-muted">Ready for barcode input</small>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mb-3 mb-md-0">
                                <div class="border rounded p-3 h-100 bg-light">
                                    <i class="fas fa-user-check fa-2x text-success mb-2"></i>
                                    <h6 class="mb-1">Instant Lookup</h6>
                                    <small class="text-muted">Checks student in grantees table</small>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="border rounded p-3 h-100 bg-light">
                                    <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                                    <h6 class="mb-1">Attendance Log</h6>
                                    <small class="text-muted">Saves attendance record</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-white d-flex flex-column flex-sm-row justify-content-between align-items-stretch align-items-sm-center">
                        <button type="submit" class="btn btn-primary btn-lg mb-2 mb-sm-0">
                            <i class="fas fa-paper-plane mr-1"></i> Submit Scan
                        </button>

                        <button type="button" class="btn btn-outline-secondary btn-lg" onclick="clearScanForm()">
                            <i class="fas fa-eraser mr-1"></i> Clear
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-12 col-lg-5 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-success text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-user-graduate mr-2"></i> Student Details
                    </h3>
                </div>

                <div class="card-body">
                    @if(session('student'))
                        <div class="text-center mb-4">
                            <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center" style="width: 90px; height: 90px;">
                                <i class="fas fa-user fa-2x text-secondary"></i>
                            </div>
                            <h4 class="mt-3 mb-1">{{ session('student')['name'] }}</h4>
                            <p class="text-muted mb-0">{{ session('student')['course'] }}</p>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mb-0">
                                <tbody>
                                    <tr>
                                        <th style="width: 35%;">Student ID</th>
                                        <td>{{ session('student')['student_id'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>Full Name</th>
                                        <td>{{ session('student')['name'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>Course</th>
                                        <td>{{ session('student')['course'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            <span class="badge badge-success px-3 py-2">
                                                Scanned Successfully
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="d-flex flex-column justify-content-center align-items-center text-center" style="min-height: 320px;">
                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                                <i class="fas fa-search fa-2x text-muted"></i>
                            </div>
                            <h5 class="mb-2">No Student Scanned Yet</h5>
                            <p class="text-muted mb-0 px-3">
                                Once a barcode is scanned, the student's information will appear here.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    .card {
        border-radius: 12px;
    }

    .card-header {
        border-top-left-radius: 12px !important;
        border-top-right-radius: 12px !important;
    }

    .input-group-text {
        border-radius: 0.3rem 0 0 0.3rem;
    }

    @media (max-width: 767.98px) {
        .content-header h1 {
            font-size: 1.6rem;
        }

        .btn-lg {
            width: 100%;
        }
    }
</style>
@stop

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('student_id');
        const eventSelect = document.getElementById('event_id');
        const form = document.getElementById('scanForm');

        if (input) {
            input.focus();
        }

        form.addEventListener('submit', function (e) {
            const eventId = eventSelect.value;

            if (!eventId) {
                e.preventDefault();
                alert('Please select an event first.');
                eventSelect.focus();
                return;
            }

            form.action = '/attendance/event/' + eventId + '/scan';
        });

        input.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                form.requestSubmit();
            }
        });
    });

    function clearScanForm() {
        document.getElementById('student_id').value = '';
        document.getElementById('student_id').focus();
    }
</script>
@stop