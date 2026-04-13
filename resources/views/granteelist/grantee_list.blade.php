@extends('adminlte::page')

@section('title', 'All Grantees List')

@section('content_header')
    <div class="dashboard-like-header">
        <div class="dashboard-like-header__left">
            <h1 class="dashboard-title mb-2" id="pageMainTitle">All Grantees List</h1>
        </div>
    </div>
@stop

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
        <i class="fas fa-times-circle mr-1"></i> {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
        <strong><i class="fas fa-exclamation-circle mr-1"></i> Please fix the following:</strong>
        <ul class="mb-0 mt-2 pl-3">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
@endif

@php
    $totalTES = $grantees->filter(function ($g) {
        $name = strtoupper(
            optional($g->scholarship)->name
            ?? optional(optional($g->batch)->scholarship)->name
            ?? ''
        );

        return in_array($name, [
            'TES',
            'TERTIARY EDUCATION SUBSIDY'
        ]);
    })->count();

    $totalTDP = $grantees->filter(function ($g) {
        $name = strtoupper(
            optional($g->scholarship)->name
            ?? optional(optional($g->batch)->scholarship)->name
            ?? ''
        );

        return in_array($name, [
            'TDP',
            'TULONG DUNONG PROGRAM'
        ]);
    })->count();
@endphp

<div class="row mb-4 justify-content-start">
    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
        <div class="small-box stats-soft-card stats-soft-card--orange shadow-sm small-summary-card">
            <div class="inner">
                <div class="stats-soft-top">
                    <div>
                        <p class="stats-soft-label">Tertiary Education Subsidy (TES)</p>
                        <h3>{{ $totalTES }}</h3>
                    </div>
                    <div class="stats-soft-icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
        <div class="small-box stats-soft-card stats-soft-card--amber shadow-sm small-summary-card">
            <div class="inner">
                <div class="stats-soft-top">
                    <div>
                        <p class="stats-soft-label">Tulong Dunong Program (TDP)</p>
                        <h3>{{ $totalTDP }}</h3>
                    </div>
                    <div class="stats-soft-icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card card-outline card-warning shadow-sm dashboard-style-card">
    <div class="card-header border-0">
        <div class="d-flex justify-content-between align-items-center flex-wrap" style="gap: 12px;">
            <h3 class="card-title font-weight-bold mb-0" id="directoryTitle">
                <i class="fas fa-list mr-2 text-warning"></i> Grantees Directory
            </h3>

            <div class="d-flex flex-wrap top-action-buttons" style="gap:10px;">
                <button type="button" class="btn btn-success btn-sm dashboard-btn" data-toggle="modal" data-target="#ImportGranteeModal">
                    <i class="fas fa-file-import mr-1"></i> Import
                </button>

                <button type="button" class="btn btn-warning btn-sm dashboard-btn" id="exportExcelBtn">
                    <i class="fas fa-file-excel mr-1"></i> Export Excel
                </button>

                <button type="button" class="btn btn-secondary btn-sm dashboard-btn" id="exportCsvBtn">
                    <i class="fas fa-file-csv mr-1"></i> Export CSV
                </button>

                <button type="button" class="btn btn-dark btn-sm dashboard-btn" id="printTableBtn">
                    <i class="fas fa-print mr-1"></i> Print
                </button>
            </div>
        </div>
    </div>

    <div class="card-body">

        <div class="grantee-toolbar dashboard-filter-box">
            <div class="row mb-0">
                <div class="col-lg-3 col-md-6 mb-3">
                    <label for="globalSearch">Search Grantee</label>
                    <input type="text" id="globalSearch" class="form-control form-control-sm" placeholder="Type name, email, course, or mobile number">
                </div>

                <div class="col-lg-2 col-md-6 mb-3">
                    <label for="batchFilter">Batch</label>
                    <select id="batchFilter" class="form-control form-control-sm">
                        <option value="">All Batches</option>
                        @foreach($batches as $batch)
                            <option value="{{ $batch->name }}">{{ $batch->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2 col-md-6 mb-3">
                    <label for="scholarshipFilter">Scholarship</label>
                    <select id="scholarshipFilter" class="form-control form-control-sm">
                        <option value="">All Scholarships</option>
                        @foreach($scholarships as $scholarship)
                            <option value="{{ $scholarship->name }}">{{ $scholarship->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2 col-md-6 mb-3">
                    <label for="statusFilter">Status</label>
                    <select id="statusFilter" class="form-control form-control-sm">
                        <option value="">All Status</option>
                        <option value="ENROLLED">Enrolled</option>
                        <option value="GRADUATED">Graduated</option>
                        <option value="DROPPED">Dropped</option>
                        <option value="DELISTED">Delisted</option>
                        <option value="NOT ENROLLED">Not Enrolled</option>
                    </select>
                </div>

                <div class="col-lg-2 col-md-6 mb-3">
                    <label for="yearFilter">Year Level</label>
                    <input type="text" id="yearFilter" class="form-control form-control-sm" placeholder="Example: 1st Year">
                </div>

                <div class="col-lg-2 col-md-6 mb-3 d-flex align-items-end">
                    <div class="w-100">
                        <button type="button" id="resetFilters" class="btn btn-secondary btn-sm w-100 dashboard-btn">
                            Reset
                        </button>
                    </div>
                </div>
            </div>
        </div>

        @if($grantees->count() > 0)
            <div class="excel-table-wrapper">
                <div class="excel-table-scroll">
                    <table id="granteesTable" class="table table-bordered table-hover table-striped mb-0 w-100">
                        <thead>
                            <tr class="text-center main-header-row">
                                <th>SEQ</th>
                                <th>Last Name</th>
                                <th>First Name</th>
                                <th>Middle Name</th>
                                <th>Extension</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>Course</th>
                                <th>Year</th>
                                <th>Years of Stay</th>
                                <th>Batch</th>
                                <th>Scholarship</th>
                                <th>Status</th>
                                <th>Remarks</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($grantees as $grantee)
                                @php
                                    $status = strtoupper($grantee->status_of_student ?? 'N/A');
                                    $statusClass = 'secondary';

                                    if ($status === 'ENROLLED') $statusClass = 'success';
                                    elseif ($status === 'GRADUATED') $statusClass = 'primary';
                                    elseif ($status === 'DROPPED') $statusClass = 'danger';
                                    elseif ($status === 'DELISTED') $statusClass = 'warning';
                                @endphp

                                <tr>
                                    <td class="text-center seq-cell">{{ $loop->iteration }}</td>
                                    <td>{{ $grantee->last_name ?? 'N/A' }}</td>
                                    <td>{{ $grantee->first_name ?? 'N/A' }}</td>
                                    <td>{{ $grantee->middle_name ?? 'N/A' }}</td>
                                    <td class="text-center">{{ $grantee->extension_name ?? '—' }}</td>
                                    <td>{{ $grantee->mobile_number ?? 'N/A' }}</td>
                                    <td>{{ $grantee->email ?? 'N/A' }}</td>
                                    <td>{{ $grantee->course ?? 'N/A' }}</td>
                                    <td class="text-center">{{ $grantee->year ?? 'N/A' }}</td>
                                    <td class="text-center">{{ $grantee->years_of_stay ?? 'N/A' }}</td>
                                    <td class="text-center">{{ optional($grantee->batch)->name ?? 'N/A' }}</td>
                                    <td class="text-center">
                                        {{ optional($grantee->scholarship)->name ?? optional(optional($grantee->batch)->scholarship)->name ?? 'N/A' }}
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-{{ $statusClass }} px-3 py-2" title="Student Status: {{ $status }}">
                                            {{ $status }}
                                        </span>
                                    </td>
                                    <td>{{ $grantee->remarks ?? '—' }}</td>
                                    <td class="text-center">
                                        <div class="btn-group action-btn-group" role="group" aria-label="Grantee actions">
                                            <button
                                                type="button"
                                                class="btn btn-info btn-sm view-grantee-btn action-btn"
                                                data-id="{{ $grantee->id }}"
                                                data-toggle="modal"
                                                data-target="#ViewGranteeModal"
                                                title="View Grantee">
                                                <i class="fas fa-eye"></i>
                                            </button>

                                            <button
                                                type="button"
                                                class="btn btn-warning btn-sm edit-grantee-btn action-btn"
                                                data-id="{{ $grantee->id }}"
                                                data-toggle="modal"
                                                data-target="#EditGranteeModal"
                                                title="Edit Grantee">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <button
                                                type="button"
                                                class="btn btn-danger btn-sm delete-grantee-btn action-btn"
                                                data-id="{{ $grantee->id }}"
                                                data-name="{{ ($grantee->first_name ?? '') . ' ' . ($grantee->last_name ?? '') }}"
                                                data-toggle="modal"
                                                data-target="#DeleteGranteeModal"
                                                title="Delete Grantee">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="alert alert-info text-center mb-0">No grantees found.</div>
        @endif
    </div>
</div>

<div class="modal fade" id="ViewGranteeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-title font-weight-bold">
                    <i class="fas fa-eye mr-1"></i> View Grantee
                </h4>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="viewGranteeContent">
                <div class="text-center py-4">
                    <i class="fas fa-spinner fa-spin fa-2x text-muted"></i>
                    <p class="mt-2 mb-0">Loading grantee details...</p>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary dashboard-btn" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="EditGranteeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <form method="POST" id="editGranteeForm" class="h-100 d-flex flex-column">
                @csrf
                @method('PUT')

                <div class="modal-header bg-warning">
                    <h4 class="modal-title font-weight-bold">
                        <i class="fas fa-edit mr-1"></i> Edit Grantee
                    </h4>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body edit-grantee-modal-body">
                    <input type="hidden" id="edit_grantee_id">

                    <div class="card card-outline card-warning mb-3">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold mb-0">Personal Information</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input type="text" name="last_name" id="edit_last_name" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input type="text" name="first_name" id="edit_first_name" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Middle Name</label>
                                        <input type="text" name="middle_name" id="edit_middle_name" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Extension Name</label>
                                        <input type="text" name="extension_name" id="edit_extension_name" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Mobile Number</label>
                                        <input type="text" name="mobile_number" id="edit_mobile_number" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email Address</label>
                                        <input type="email" name="email" id="edit_email" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-outline card-warning mb-0">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold mb-0">Academic Information</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Course / Program Enrolled</label>
                                        <input type="text" name="course" id="edit_course" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Year</label>
                                        <input type="text" name="year" id="edit_year" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Years of Stay</label>
                                        <input type="text" name="years_of_stay" id="edit_years_of_stay" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Scholarship</label>
                                        <select name="scholarship_id" id="edit_scholarship_id" class="form-control">
                                            <option value="">Select Scholarship</option>
                                            @foreach($scholarships as $scholarship)
                                                <option value="{{ $scholarship->id }}">{{ $scholarship->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Batch</label>
                                        <input
                                            type="text"
                                            name="batch_name"
                                            id="edit_batch_name"
                                            class="form-control"
                                            placeholder="Enter batch name">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status_of_student" id="edit_status" class="form-control">
                                            <option value="Enrolled">Enrolled</option>
                                            <option value="Graduated">Graduated</option>
                                            <option value="Dropped">Dropped</option>
                                            <option value="Delisted">Delisted</option>
                                            <option value="Not Enrolled">Not Enrolled</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-0">
                                <label>Remarks</label>
                                <textarea name="remarks" id="edit_remarks" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="submit" class="btn btn-warning dashboard-btn">
                        <i class="fas fa-save mr-1"></i> Update
                    </button>
                    <button type="button" class="btn btn-secondary dashboard-btn" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="DeleteGranteeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" id="deleteGranteeForm">
                @csrf
                @method('DELETE')

                <div class="modal-header bg-danger">
                    <h4 class="modal-title font-weight-bold">Delete Grantee</h4>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body text-center">
                    <p>Are you sure you want to delete this grantee?</p>
                    <h5 id="delete-grantee-name" class="font-weight-bold"></h5>
                    <p class="text-muted mb-0">This action cannot be undone.</p>
                </div>

                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-danger dashboard-btn">Delete</button>
                    <button type="button" class="btn btn-secondary dashboard-btn" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="ImportGranteeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('grantees.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-success">
                    <h4 class="modal-title font-weight-bold">
                        <i class="fas fa-file-import mr-1"></i> Import Grantees
                    </h4>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Select Excel / CSV File</label>
                        <input type="file" name="file" class="form-control" accept=".xlsx,.xls,.csv" required>
                    </div>
                    <small class="text-muted">Accepted formats: .xlsx, .xls, .csv</small>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success dashboard-btn">
                        <i class="fas fa-upload mr-1"></i> Import File
                    </button>
                    <button type="button" class="btn btn-secondary dashboard-btn" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

@stop

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/colreorder/1.6.2/css/colReorder.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('css/granteelist/grantee_list.css') }}">

<style>
    #EditGranteeModal .modal-dialog {
        max-width: 1140px;
    }

    #EditGranteeModal .modal-content {
        max-height: 90vh;
        display: flex;
        flex-direction: column;
    }

    #EditGranteeModal .modal-body {
        overflow-y: auto;
        overflow-x: hidden;
        max-height: calc(90vh - 140px);
        padding-right: 12px;
    }

    #EditGranteeModal .card {
        margin-bottom: 1rem;
    }

    #EditGranteeModal .card:last-child {
        margin-bottom: 0;
    }

    #EditGranteeModal .form-group {
        margin-bottom: 1rem;
    }

    #EditGranteeModal textarea.form-control {
        resize: vertical;
    }

    #EditGranteeModal .modal-header,
    #EditGranteeModal .modal-footer {
        flex-shrink: 0;
    }

    .small-summary-card {
        min-height: 112px !important;
    }

    .small-summary-card .inner {
        padding: 14px 16px !important;
    }

    .small-summary-card .stats-soft-label {
        margin-bottom: 6px !important;
        font-size: 13px;
    }

    .small-summary-card h3 {
        font-size: 32px !important;
        margin: 0 !important;
    }

    .small-summary-card .stats-soft-icon {
        width: 46px;
        height: 46px;
        font-size: 20px;
        border-radius: 14px;
    }
</style>
@stop

@section('js')
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
<script src="https://cdn.datatables.net/colreorder/1.6.2/js/dataTables.colReorder.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script>
    window.GranteeListConfig = {
        viewUrlTemplate: "{{ url('/grantees/__ID__') }}",
        editUrlTemplate: "{{ url('/grantees/__ID__/edit') }}",
        updateUrlTemplate: "{{ url('/grantees/__ID__') }}",
        destroyUrlTemplate: "{{ url('/grantees/__ID__') }}",
        printHeaderImage: "{{ asset('assets/img/Picture1.jpg') }}",
        printPreviewUrl: "{{ route('grantees.print.preview') }}"
    };
</script>

<script src="{{ asset('js/granteelist/grantee_list.js') }}"></script>
@stop