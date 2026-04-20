@extends('adminlte::page')

@section('title', 'Applications')

@section('content_header')
    @php
        $totalApplications = $applications->count();
        $pendingCount = $applications->where('status', 'pending')->count();
        $approvedCount = $applications->where('status', 'approved')->count();
        $rejectedCount = $applications->where('status', 'rejected')->count();
    @endphp

    <div class="application-page-header">
        <div class="page-title-wrap">
            <div class="page-title-icon">
                <i class="fas fa-file-alt"></i>
            </div>
            <div>
                <h1 class="mb-1">Applications</h1>
            </div>
        </div>

        <div class="page-actions">
            <a href="{{ route('applications.export.excel') }}" class="btn btn-app-primary btn-sm">
                <i class="fas fa-file-excel mr-1"></i> Export Excel
            </a>

            <a href="{{ route('approve_list.approved') }}" class="btn btn-success btn-sm">
                <i class="fas fa-check-circle mr-1"></i> Approved List
            </a>

            <a href="{{ route('approve_list.rejected') }}" class="btn btn-danger btn-sm">
                <i class="fas fa-times-circle mr-1"></i> Rejected List
            </a>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/applicationview.css') }}">
@stop

@section('content')
    @if(isset($viewingSemester) && $viewingSemester)
        <div class="alert alert-info">
            <i class="fas fa-eye mr-2"></i>
            Viewing Semester:
            <strong>{{ $viewingSemester->semester_name }} - {{ $viewingSemester->school_year }}</strong>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show app-alert app-alert-success" role="alert">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close success message">
                <span>&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show app-alert app-alert-danger" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close error message">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <div class="row app-stats-row">
        <div class="col-lg-3 col-sm-6">
            <div class="app-stat-card">
                <div class="app-stat-icon total">
                    <i class="fas fa-folder-open"></i>
                </div>
                <div>
                    <div class="app-stat-label">Total Applications</div>
                    <div class="app-stat-value">{{ $totalApplications }}</div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6">
            <div class="app-stat-card">
                <div class="app-stat-icon pending">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <div>
                    <div class="app-stat-label">Pending</div>
                    <div class="app-stat-value">{{ $pendingCount }}</div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6">
            <div class="app-stat-card">
                <div class="app-stat-icon approved">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <div class="app-stat-label">Approved</div>
                    <div class="app-stat-value">{{ $approvedCount }}</div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6">
            <div class="app-stat-card">
                <div class="app-stat-icon rejected">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div>
                    <div class="app-stat-label">Rejected</div>
                    <div class="app-stat-value">{{ $rejectedCount }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card application-card">
        <div class="card-header application-card-header">
            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center w-100">
                <div class="app-toolbar">
                    <div class="app-search-box">
                        <label for="applicationSearch" class="sr-only">Search applications</label>
                        <i class="fas fa-search"></i>
                        <input type="text" id="applicationSearch" class="form-control" placeholder="Search student, ID, program, email...">
                    </div>

                    <div class="filter-wrap">
                        <label for="statusFilter" class="sr-only">Filter by status</label>
                        <select id="statusFilter" class="form-control app-filter-select">
                            <option value="">All Status</option>
                            <option value="pending" selected>Pending</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body pt-3">
            @if($applications->count() > 0)
                <div class="application-table-wrapper">
                    <div class="table-responsive application-table-responsive">
                        <table class="table table-bordered table-hover mb-0 application-table" id="applicationTable">
                            <thead>
                                <tr class="text-center">
                                    <th style="min-width: 60px;">#</th>
                                    <th style="min-width: 120px;">Student ID</th>
                                    <th style="min-width: 220px;">Name</th>
                                    <th style="min-width: 80px;">Sex</th>
                                    <th style="min-width: 160px;">Semester</th>
                                    <th style="min-width: 180px;">Program</th>
                                    <th style="min-width: 110px;">Year Level</th>
                                    <th style="min-width: 130px;">Contact</th>
                                    <th style="min-width: 220px;">Email</th>
                                    <th style="min-width: 120px;">Status</th>
                                    <th style="min-width: 170px;">Manage</th>
                                    <th style="min-width: 150px;">Decision</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($applications as $app)
                                    @php
                                        $status = strtolower($app->status ?? 'pending');
                                        $fullName = trim(($app->given_name ?? '') . ' ' . ($app->middle_name ?? '') . ' ' . ($app->last_name ?? ''));
                                    @endphp

                                    <tr data-status="{{ $status }}">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $app->student_id ?? 'N/A' }}</td>

                                        <td>
                                            <div class="student-name">{{ $fullName ?: 'N/A' }}</div>
                                        </td>

                                        <td class="text-center">{{ $app->sex ?? 'N/A' }}</td>

                                        <td class="text-center">
                                            @if($app->semester)
                                                <div class="font-weight-bold">
                                                    {{ $app->semester->semester_name }}
                                                </div>
                                                <small class="text-muted">
                                                    {{ $app->semester->school_year }}
                                                </small>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>

                                        <td>{{ $app->program_name ?? 'N/A' }}</td>
                                        <td class="text-center">{{ $app->year_level ?? 'N/A' }}</td>
                                        <td>{{ $app->contact_number ?? 'N/A' }}</td>
                                        <td>{{ $app->email ?? 'N/A' }}</td>

                                        <td class="text-center">
                                            @if($status === 'pending')
                                                <span class="badge badge-status badge-pending">
                                                    <i class="fas fa-clock mr-1"></i>Pending
                                                </span>
                                            @elseif($status === 'approved')
                                                <span class="badge badge-status badge-approved">
                                                    <i class="fas fa-check-circle mr-1"></i>Approved
                                                </span>
                                            @elseif($status === 'rejected')
                                                <span class="badge badge-status badge-rejected">
                                                    <i class="fas fa-times-circle mr-1"></i>Rejected
                                                </span>
                                            @else
                                                <span class="badge badge-status badge-secondary">
                                                    <i class="fas fa-question-circle mr-1"></i>Unknown
                                                </span>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            <div class="action-btn-group manage-btn-group">
                                                <button
                                                    class="btn btn-info btn-sm view-app-btn"
                                                    data-id="{{ $app->id }}"
                                                    data-toggle="modal"
                                                    data-target="#ViewApplicationModal"
                                                    title="View application"
                                                    aria-label="View application">
                                                    <i class="fas fa-eye"></i>
                                                </button>

                                                <button
                                                    class="btn btn-warning btn-sm edit-app-btn"
                                                    data-id="{{ $app->id }}"
                                                    data-toggle="modal"
                                                    data-target="#EditApplicationForm"
                                                    title="Edit application"
                                                    aria-label="Edit application">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <button
                                                    class="btn btn-danger btn-sm delete-app-btn"
                                                    data-id="{{ $app->id }}"
                                                    data-name="{{ $fullName }}"
                                                    data-toggle="modal"
                                                    data-target="#DeleteApplicationModal"
                                                    title="Delete application"
                                                    aria-label="Delete application">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>

                                        <td class="text-center">
                                            @if($status === 'pending')
                                                <div class="action-btn-group decision-btn-group">
                                                    <button
                                                        class="btn btn-success btn-sm approve-app-btn"
                                                        data-id="{{ $app->id }}"
                                                        data-name="{{ $fullName }}"
                                                        data-toggle="modal"
                                                        data-target="#ApproveApplicationModal"
                                                        title="Approve application"
                                                        aria-label="Approve application">
                                                        <i class="fas fa-check"></i>
                                                    </button>

                                                    <button
                                                        class="btn btn-secondary btn-sm reject-app-btn"
                                                        data-id="{{ $app->id }}"
                                                        data-toggle="modal"
                                                        data-target="#RejectApplicationModal"
                                                        title="Reject application"
                                                        aria-label="Reject application">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            @else
                                                <div class="action-btn-group decision-btn-group">
                                                    <button class="btn btn-light btn-sm" disabled aria-label="Approve disabled">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                    <button class="btn btn-light btn-sm" disabled aria-label="Reject disabled">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="noSearchResults" class="empty-state mt-3 d-none">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <h5 class="mb-2">No matching applications found</h5>
                    <p class="text-muted mb-0">Try another keyword or change the status filter.</p>
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                    <h5 class="mb-2">No applications found</h5>
                    <p class="text-muted mb-0">New student applications will appear here once submitted.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- VIEW MODAL --}}
    <div class="modal fade" id="ViewApplicationModal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header modal-header-info">
                    <h5 class="modal-title">
                        <i class="fas fa-user-graduate mr-2"></i>
                        Application Details
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body" id="view-app-content">
                    Loading...
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- EDIT MODAL --}}
    <div class="modal fade" id="EditApplicationForm" tabindex="-1" role="dialog" aria-labelledby="EditApplicationFormLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content" style="max-height: 90vh;">
                <form method="POST" action="{{ route('applications.update') }}" class="d-flex flex-column h-100">
                    @csrf

                    <div class="modal-header modal-header-warning">
                        <h4 class="modal-title" id="EditApplicationFormLabel">
                            <i class="fas fa-edit mr-2"></i>Edit Application
                        </h4>
                        <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body modal-section-body">
                        <input type="hidden" name="ea_id" id="edit_app_id">

                        <div class="form-section-title">Basic Information</div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Student ID</label>
                                <input type="text" name="ea_student_id" id="edit_student_id" class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Email</label>
                                <input type="email" name="ea_email" id="edit_email" class="form-control">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Last Name</label>
                                <input type="text" name="ea_last_name" id="edit_last_name" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Middle Name</label>
                                <input type="text" name="ea_middle_name" id="edit_middle_name" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Given Name</label>
                                <input type="text" name="ea_given_name" id="edit_given_name" class="form-control">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Sex</label>
                                <input type="text" name="ea_sex" id="edit_sex" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Birth Date</label>
                                <input type="date" name="ea_birth_date" id="edit_birth_date" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Year Level</label>
                                <input type="text" name="ea_year_level" id="edit_year_level" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Program Name</label>
                            <input type="text" name="ea_program_name" id="edit_program_name" class="form-control">
                        </div>

                        <hr>

                        <div class="form-section-title">Family Background</div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Father Last Name</label>
                                <input type="text" name="ea_father_last_name" id="edit_father_last_name" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Father Given Name</label>
                                <input type="text" name="ea_father_given_name" id="edit_father_given_name" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Father Middle Name</label>
                                <input type="text" name="ea_father_middle_name" id="edit_father_middle_name" class="form-control">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Mother Last Name</label>
                                <input type="text" name="ea_mother_last_name" id="edit_mother_last_name" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Mother Given Name</label>
                                <input type="text" name="ea_mother_given_name" id="edit_mother_given_name" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Mother Middle Name</label>
                                <input type="text" name="ea_mother_middle_name" id="edit_mother_middle_name" class="form-control">
                            </div>
                        </div>

                        <hr>

                        <div class="form-section-title">Contact and Other Details</div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Street / Barangay</label>
                                <input type="text" name="ea_street_barangay" id="edit_street_barangay" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Zip Code</label>
                                <input type="text" name="ea_zipcode" id="edit_zipcode" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Contact Number</label>
                                <input type="text" name="ea_contact_number" id="edit_contact_number" class="form-control">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Disability</label>
                                <input type="text" name="ea_disability" id="edit_disability" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Indigenous Group</label>
                                <input type="text" name="ea_indigenous_group" id="edit_indigenous_group" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer bg-light">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save mr-1"></i> Update
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Close
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- DELETE MODAL --}}
    <div class="modal fade" id="DeleteApplicationModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('applications.destroy') }}">
                    @csrf

                    <div class="modal-header modal-header-danger">
                        <h4 class="modal-title">
                            <i class="fas fa-trash-alt mr-2"></i>Delete Application
                        </h4>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;</button>
                    </div>

                    <div class="modal-body text-center">
                        <input type="hidden" name="da_id" id="delete_app_id">
                        <p>Are you sure you want to delete this application?</p>
                        <h4 id="delete-app-name" class="font-weight-bold"></h4>
                        <p class="text-muted">This action cannot be undone.</p>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Delete</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- REJECT MODAL --}}
    <div class="modal fade" id="RejectApplicationModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('applications.reject') }}">
                    @csrf

                    <div class="modal-header modal-header-danger">
                        <h5 class="modal-title">
                            <i class="fas fa-times-circle mr-1"></i> Reject Application
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" name="id" id="reject_app_id">

                        <div class="form-group mb-0">
                            <label>Reason for Rejection</label>
                            <textarea name="reason" class="form-control" rows="4" required placeholder="Enter rejection reason..."></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Reject</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- APPROVE MODAL --}}
    <div class="modal fade" id="ApproveApplicationModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('applications.approve') }}">
                    @csrf
                    <input type="hidden" name="id" id="approve_app_id">

                    <div class="modal-header modal-header-success">
                        <h5 class="modal-title">
                            <i class="fas fa-check-circle mr-1"></i> Approve Application
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body text-center">
                        <p>Are you sure you want to approve this student?</p>
                        <h4 id="approve-app-name" class="font-weight-bold"></h4>
                        <p class="text-muted mb-0">
                            This will generate a student account and send login credentials to the student email.
                        </p>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Yes, Approve</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@stop

@section('js')
    <script>
        window.APP_URL = "{{ url('') }}";
    </script>

    <script src="{{ asset('js/application.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('applicationSearch');
            const statusFilter = document.getElementById('statusFilter');
            const table = document.getElementById('applicationTable');
            const noResults = document.getElementById('noSearchResults');

            if (!table) return;

            const rows = table.querySelectorAll('tbody tr');

            function filterTable() {
                const search = (searchInput.value || '').toLowerCase().trim();
                const status = (statusFilter.value || '').toLowerCase().trim();
                let visibleCount = 0;
                let rowNumber = 1;

                rows.forEach((row) => {
                    const rowText = row.innerText.toLowerCase();
                    const rowStatus = (row.getAttribute('data-status') || '').toLowerCase();
                    const numberCell = row.querySelector('td:first-child');

                    const matchesSearch = !search || rowText.includes(search);
                    const matchesStatus = !status || rowStatus === status;

                    if (matchesSearch && matchesStatus) {
                        row.style.display = '';
                        if (numberCell) {
                            numberCell.textContent = rowNumber;
                        }
                        rowNumber++;
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                if (noResults) {
                    noResults.classList.toggle('d-none', visibleCount !== 0);
                }
            }

            searchInput.addEventListener('input', filterTable);
            statusFilter.addEventListener('change', filterTable);

            filterTable();
        });
    </script>
@stop