@extends('adminlte::page')

@section('title', 'Event Attendance')

@section('content_header')
    <div class="attendance-header-wrap">
        <div>
            <h1 class="attendance-page-title mb-1">Students Attended - {{ $event->event_name }}</h1>
            <div class="attendance-page-subtitle">
                <i class="far fa-calendar-alt mr-1"></i> {{ $event->event_date }}
            </div>
        </div>
    </div>
@stop

@section('content')

    <style>
        :root {
            --att-orange: #f28c28;
            --att-orange-dark: #d96d00;
            --att-orange-soft: #fff4e8;
            --att-orange-border: #ffd3a6;
            --att-text: #2f2f2f;
            --att-muted: #6c757d;
            --att-bg: #f8f9fb;
            --att-card: #ffffff;
            --att-border: #e9ecef;
            --att-success: #2e8b57;
            --att-warning: #b7791f;
            --att-secondary: #6b7280;
            --att-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
            --att-radius: 16px;
        }

        .content-wrapper,
        .content,
        .container-fluid {
            background: var(--att-bg);
        }

        .attendance-header-wrap {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .attendance-page-title {
            font-size: 1.7rem;
            font-weight: 700;
            color: var(--att-text);
        }

        .attendance-page-subtitle {
            color: var(--att-muted);
            font-size: 0.95rem;
            font-weight: 500;
        }

        .attendance-toolbar {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 18px;
        }

        .attendance-btn {
            border-radius: 12px !important;
            font-weight: 600;
            padding: 9px 16px !important;
            border-width: 1px !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .btn-att-back {
            background: #fff;
            color: #495057;
            border: 1px solid #d6dbe1;
        }

        .btn-att-back:hover,
        .btn-att-back:focus {
            background: #f1f3f5;
            color: #212529;
        }

        .btn-att-export {
            background: #198754;
            color: #fff;
            border: 1px solid #198754;
        }

        .btn-att-export:hover,
        .btn-att-export:focus {
            background: #157347;
            color: #fff;
        }

        .btn-att-print {
            background: var(--att-orange);
            color: #fff;
            border: 1px solid var(--att-orange);
        }

        .btn-att-print:hover,
        .btn-att-print:focus {
            background: var(--att-orange-dark);
            border-color: var(--att-orange-dark);
            color: #fff;
        }

        .attendance-alert {
            border: 0;
            border-left: 5px solid;
            border-radius: 14px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.04);
        }

        .attendance-alert.alert-success {
            border-left-color: var(--att-success);
        }

        .attendance-alert.alert-danger {
            border-left-color: #dc3545;
        }

        .attendance-alert.alert-warning {
            border-left-color: var(--att-orange);
        }

        .attendance-stats-row {
            margin-bottom: 18px;
        }

        .attendance-stat-card {
            background: var(--att-card);
            border-radius: var(--att-radius);
            box-shadow: var(--att-shadow);
            border: 1px solid var(--att-border);
            padding: 18px;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .attendance-stat-card::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 5px;
            height: 100%;
        }

        .attendance-stat-card.complete::before {
            background: var(--att-success);
        }

        .attendance-stat-card.incomplete::before {
            background: var(--att-orange);
        }

        .attendance-stat-label {
            font-size: 0.95rem;
            color: var(--att-muted);
            font-weight: 600;
            margin-bottom: 8px;
        }

        .attendance-stat-value {
            font-size: 2rem;
            font-weight: 800;
            color: var(--att-text);
            line-height: 1;
        }

        .attendance-card {
            background: var(--att-card);
            border: 1px solid var(--att-border);
            border-radius: var(--att-radius);
            box-shadow: var(--att-shadow);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .attendance-card-header {
            background: linear-gradient(135deg, #fff8f1 0%, #fff2e2 100%);
            border-bottom: 1px solid #f1dfcb;
            padding: 16px 20px;
        }

        .attendance-card-title {
            margin: 0;
            font-size: 1.08rem;
            font-weight: 700;
            color: #8a4b08;
        }

        .attendance-card-body {
            padding: 20px;
        }

        .attendance-mode-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 15px;
        }

        .attendance-mode-btn {
            min-width: 140px;
            border-radius: 12px !important;
            font-weight: 700;
            padding: 10px 16px !important;
        }

        .attendance-mode-status {
            background: #fffaf5;
            border: 1px solid var(--att-orange-border);
            border-radius: 14px;
            padding: 12px 14px;
            margin-bottom: 16px;
            color: var(--att-text);
        }

        .attendance-mode-badge {
            font-size: 0.9rem;
            font-weight: 700;
            border-radius: 999px;
            padding: 8px 14px;
            letter-spacing: 0.5px;
        }

        .attendance-form-label {
            font-weight: 700;
            color: var(--att-text);
            margin-bottom: 8px;
        }

        .attendance-scan-input {
            height: 58px;
            border-radius: 14px;
            border: 1px solid #d9dee5;
            font-size: 1.05rem;
            padding-left: 16px;
            box-shadow: none !important;
        }

        .attendance-scan-input:focus {
            border-color: var(--att-orange);
            box-shadow: 0 0 0 0.2rem rgba(242, 140, 40, 0.15) !important;
        }

        .attendance-help-text {
            color: var(--att-muted);
            font-size: 0.92rem;
        }

        .attendance-table-wrap {
            border: 1px solid var(--att-border);
            border-radius: 14px;
            overflow: hidden;
        }

        .attendance-table {
            margin-bottom: 0;
        }

        .attendance-table thead th {
            background: #fff4e8;
            color: #7a4306;
            border-bottom: 1px solid #f3d4b1 !important;
            font-weight: 700;
            font-size: 0.95rem;
            vertical-align: middle;
            white-space: nowrap;
        }

        .attendance-table th,
        .attendance-table td {
            vertical-align: middle !important;
            padding: 12px 14px;
        }

        .attendance-table tbody tr:hover {
            background: #fffaf5;
        }

        .attendance-empty {
            padding: 28px 12px !important;
            color: var(--att-muted);
            font-weight: 600;
        }

        .attendance-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border-radius: 999px;
            padding: 7px 12px;
            font-size: 0.82rem;
            font-weight: 700;
            border: 1px solid transparent;
        }

        .attendance-badge.complete {
            background: #eaf7f0;
            color: #1f6b43;
            border-color: #bfe7cf;
        }

        .attendance-badge.incomplete {
            background: #fff4e5;
            color: #9a5a00;
            border-color: #ffd8a8;
        }

        .attendance-badge.none {
            background: #f1f3f5;
            color: #5f6b76;
            border-color: #d9dee3;
        }

        .attendance-time {
            font-weight: 600;
            color: #374151;
            white-space: nowrap;
        }

        .attendance-muted-dash {
            color: #adb5bd;
            font-weight: 600;
        }

        .attendance-sr-note {
            font-size: 0.88rem;
            color: var(--att-muted);
            margin-top: 10px;
        }

        @media (max-width: 767.98px) {
            .attendance-page-title {
                font-size: 1.35rem;
            }

            .attendance-card-body,
            .attendance-card-header {
                padding: 15px;
            }

            .attendance-stat-value {
                font-size: 1.7rem;
            }

            .attendance-mode-btn {
                width: 100%;
            }
        }
    </style>

    <div class="attendance-toolbar">
        <a href="{{ route('attendance.index') }}" class="btn attendance-btn btn-att-back btn-sm">
            <i class="fas fa-arrow-left mr-1"></i> Back
        </a>

        <a href="{{ route('attendance.export', $event->id) }}" class="btn attendance-btn btn-att-export btn-sm">
            <i class="fas fa-file-excel mr-1"></i> Export Excel
        </a>

        <a href="{{ route('attendance.print', $event->id) }}" target="_blank" class="btn attendance-btn btn-att-print btn-sm">
            <i class="fas fa-print mr-1"></i> Print
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show attendance-alert" role="alert">
            <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show attendance-alert" role="alert">
            <i class="fas fa-exclamation-circle mr-1"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('info'))
        <div class="alert alert-warning alert-dismissible fade show attendance-alert" role="alert">
            <i class="fas fa-info-circle mr-1"></i> {{ session('info') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show attendance-alert" role="alert">
            <div class="font-weight-bold mb-1">
                <i class="fas fa-times-circle mr-1"></i> Please check the following:
            </div>
            <ul class="mb-0 pl-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row attendance-stats-row">
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="attendance-stat-card complete">
                <div class="attendance-stat-label">Complete Attendance</div>
                <div class="attendance-stat-value">{{ $completeAttendance }}</div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-3">
            <div class="attendance-stat-card incomplete">
                <div class="attendance-stat-label">Incomplete Attendance</div>
                <div class="attendance-stat-value">{{ $incompleteAttendance }}</div>
            </div>
        </div>
    </div>

    <div class="attendance-card">
        <div class="attendance-card-header">
            <h3 class="attendance-card-title">
                <i class="fas fa-barcode mr-2"></i>Barcode Scanner
            </h3>
        </div>

        <div class="attendance-card-body">
            <div class="attendance-mode-buttons">
                <button type="button" class="btn btn-success attendance-mode-btn" id="timeInBtn" onclick="setMode('in')">
                    <i class="fas fa-sign-in-alt mr-1"></i> Time In
                </button>

                <button type="button" class="btn btn-outline-warning attendance-mode-btn" id="timeOutBtn" onclick="setMode('out')">
                    <i class="fas fa-sign-out-alt mr-1"></i> Time Out
                </button>
            </div>

            <div class="attendance-mode-status">
                <strong class="mr-2">Current Mode:</strong>
                <span id="currentModeBadge" class="badge badge-success attendance-mode-badge">TIME IN</span>
            </div>

            <form id="scannerForm" action="{{ route('attendance.timein', $event->id) }}" method="POST">
                @csrf

                <div class="form-group mb-2">
                    <label for="barcode_input" class="attendance-form-label">
                        Scan Student ID
                    </label>
                    <input
                        type="text"
                        name="barcode"
                        id="barcode_input"
                        class="form-control form-control-lg attendance-scan-input"
                        placeholder="Scan student ID here..."
                        autocomplete="off"
                        required
                        aria-label="Scan student ID here"
                    >
                </div>

                <small class="attendance-help-text d-block">
                    Scanner-ready input. Selected mode will stay the same after every scan.
                </small>
            </form>
        </div>
    </div>

    <div class="attendance-card">
        <div class="attendance-card-header">
            <h3 class="attendance-card-title">
                <i class="fas fa-list-alt mr-2"></i>Attendance List
            </h3>
        </div>

        <div class="attendance-card-body">
            <div class="table-responsive attendance-table-wrap">
                <table class="table table-bordered table-striped attendance-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Student Number</th>
                            <th>Name</th>
                            <th>Course</th>
                            <th>Barcode</th>
                            <th>Time In</th>
                            <th>Time Out</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances as $attendance)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $attendance->student_number }}</td>
                                <td>{{ $attendance->name }}</td>
                                <td>{{ $attendance->course }}</td>
                                <td>{{ $attendance->barcode }}</td>
                                <td>
                                    @if($attendance->time_in)
                                        <span class="attendance-time">
                                            {{ \Carbon\Carbon::parse($attendance->time_in)->format('h:i A') }}
                                        </span>
                                    @else
                                        <span class="attendance-muted-dash">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($attendance->time_out)
                                        <span class="attendance-time">
                                            {{ \Carbon\Carbon::parse($attendance->time_out)->format('h:i A') }}
                                        </span>
                                    @else
                                        <span class="attendance-muted-dash">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($attendance->time_in && $attendance->time_out)
                                        <span class="attendance-badge complete">
                                            <i class="fas fa-check-circle"></i> Complete Attendance
                                        </span>
                                    @elseif($attendance->time_in || $attendance->time_out)
                                        <span class="attendance-badge incomplete">
                                            <i class="fas fa-exclamation-circle"></i> Incomplete Attendance
                                        </span>
                                    @else
                                        <span class="attendance-badge none">
                                            <i class="fas fa-minus-circle"></i> No Attendance
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center attendance-empty">
                                    <i class="fas fa-users-slash mr-1"></i> No students found for this event.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@stop

@section('js')
<script>
    const scannerForm = document.getElementById('scannerForm');
    const barcodeInput = document.getElementById('barcode_input');
    const currentModeBadge = document.getElementById('currentModeBadge');
    const timeInBtn = document.getElementById('timeInBtn');
    const timeOutBtn = document.getElementById('timeOutBtn');
    const eventId = "{{ $event->id }}";

    const modeStorageKey = `attendance_mode_event_${eventId}`;

    function setMode(mode) {
        if (mode === 'in') {
            scannerForm.action = `/attendance/${eventId}/time-in`;
            currentModeBadge.textContent = 'TIME IN';
            currentModeBadge.className = 'badge badge-success attendance-mode-badge';

            timeInBtn.classList.remove('btn-outline-success');
            timeInBtn.classList.add('btn-success');

            timeOutBtn.classList.remove('btn-warning');
            timeOutBtn.classList.add('btn-outline-warning');
        } else {
            scannerForm.action = `/attendance/${eventId}/time-out`;
            currentModeBadge.textContent = 'TIME OUT';
            currentModeBadge.className = 'badge badge-warning attendance-mode-badge';

            timeOutBtn.classList.remove('btn-outline-warning');
            timeOutBtn.classList.add('btn-warning');

            timeInBtn.classList.remove('btn-success');
            timeInBtn.classList.add('btn-outline-success');
        }

        localStorage.setItem(modeStorageKey, mode);

        barcodeInput.value = '';
        barcodeInput.focus();
    }

    document.addEventListener('DOMContentLoaded', function () {
        const savedMode = localStorage.getItem(modeStorageKey) || 'in';
        setMode(savedMode);
        barcodeInput.focus();
    });

    barcodeInput.addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();

            if (barcodeInput.value.trim() !== '') {
                scannerForm.submit();
            }
        }
    });

    window.addEventListener('load', function () {
        barcodeInput.focus();
    });
</script>
@stop