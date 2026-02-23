@extends('adminlte::page')

@section('title', 'Applications')

@section('content_header')
    <h1>Applications</h1>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/applicationview.css') }}">
@stop

@if(session('success'))
    <div class="alert-success-custom">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert-error-custom">
        {{ session('error') }}
    </div>
@endif

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Application List</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#AddApplicationForm">
                    <i class="fas fa-plus"></i> Add New Application
                </button>
            </div>
        </div>

        <div class="card-body">
            @if($applications->count() > 0)

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="bg-orange text-white">
                            <tr class="text-center">
                                <th>#</th>
                                <th>Student ID</th>
                                <th>Name</th>
                                <th>Sex</th>
                                <th>Program</th>
                                <th>Year Level</th>
                                <th>Contact Number</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th style="width: 170px;">Actions</th>

                                {{-- ✅ TH with approve/reject icons --}}
                                <th style="width: 170px;">
                                    <span class="d-inline-flex align-items-center justify-content-center" style="gap:8px;">
                                        <span>Approve/Reject</span>
                                        <span class="badge badge-success" title="Approve" style="padding:.35rem .5rem;">
                                            <i class="fas fa-check"></i>
                                        </span>
                                        <span class="badge badge-secondary" title="Reject" style="padding:.35rem .5rem;">
                                            <i class="fas fa-times"></i>
                                        </span>
                                    </span>
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($applications as $app)
                                <tr class="text-center align-middle">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $app->student_id ?? 'N/A' }}</td>
                                    <td>{{ $app->given_name }} {{ $app->middle_name ?? '' }} {{ $app->last_name }}</td>
                                    <td>{{ $app->sex ?? 'N/A' }}</td>
                                    <td>{{ $app->program_name ?? 'N/A' }}</td>
                                    <td>{{ $app->year_level ?? 'N/A' }}</td>
                                    <td>{{ $app->contact_number ?? 'N/A' }}</td>
                                    <td>{{ $app->email ?? 'N/A' }}</td>

                                    {{-- ✅ STATUS --}}
                                    <td>
                                        @php $status = $app->status ?? 'pending'; @endphp

                                        @if($status === 'pending')
                                            <span class="badge badge-warning">PENDING</span>
                                        @elseif($status === 'approved')
                                            <span class="badge badge-success">APPROVED</span>
                                        @elseif($status === 'rejected')
                                            <span class="badge badge-danger">REJECTED</span>
                                        @else
                                            <span class="badge badge-secondary">{{ strtoupper($status) }}</span>
                                        @endif
                                    </td>

                                    {{-- ✅ ACTIONS (View/Edit/Delete only) --}}
                                    <td>
                                        <div class="action-buttons">
                                            {{-- VIEW --}}
                                            <button type="button"
                                                    class="btn btn-info action-btn view-app-btn"
                                                    data-id="{{ $app->id }}"
                                                    data-toggle="modal"
                                                    data-target="#ViewApplicationModal"
                                                    title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </button>

                                            {{-- EDIT --}}
                                            <button type="button"
                                                    class="btn btn-warning action-btn edit-app-btn"
                                                    data-id="{{ $app->id }}"
                                                    data-toggle="modal"
                                                    data-target="#EditApplicationForm"
                                                    title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            {{-- DELETE --}}
                                            <button type="button"
                                                    class="btn btn-danger action-btn delete-app-btn"
                                                    data-id="{{ $app->id }}"
                                                    data-name="{{ $app->given_name }} {{ $app->last_name }}"
                                                    data-toggle="modal"
                                                    data-target="#DeleteApplicationModal"
                                                    title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>

                                    {{-- ✅ APPROVE/REJECT column --}}
                                    <td>
                                        <div class="action-buttons">
                                            @if(($app->status ?? 'pending') === 'pending')
                                                <form action="{{ route('applications.approve') }}" method="POST" class="action-form">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $app->id }}">
                                                    <button type="submit" class="btn btn-success action-btn" title="Approve">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>

                                                <form action="{{ route('applications.reject') }}" method="POST" class="action-form">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $app->id }}">
                                                    <button type="submit" class="btn btn-secondary action-btn" title="Reject">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            @else
                                                {{-- Not pending: show disabled --}}
                                                <button type="button" class="btn btn-success action-btn" disabled
                                                        title="Not available" style="opacity:.45; cursor:not-allowed;">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button type="button" class="btn btn-secondary action-btn" disabled
                                                        title="Not available" style="opacity:.45; cursor:not-allowed;">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center">
                    {{ $applications->links() }}
                </div>
            @else
                <div class="alert alert-info text-center">
                    No applications found.
                </div>
            @endif
        </div>
    </div>
</div>

<!-- ADD -->
<div class="modal fade" id="AddApplicationForm" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Application</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <form method="POST" action="{{ route('applications.store') }}">
                @csrf
                <div class="modal-body">

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Student ID</label>
                            <input type="text" class="form-control" name="a_student_id" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Sex</label>
                            <select class="form-control" name="a_sex">
                                <option value="">Select</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Last Name</label>
                            <input type="text" class="form-control" name="a_last_name" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Given Name</label>
                            <input type="text" class="form-control" name="a_given_name" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Middle Name</label>
                            <input type="text" class="form-control" name="a_middle_name">
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Ext Name</label>
                                <input type="text" class="form-control" name="a_ext_name">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Birthdate</label>
                            <input type="date" class="form-control" name="a_birthdate">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Program</label>
                            <input type="text" class="form-control" name="a_program_name">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Year Level</label>
                            <input type="text" class="form-control" name="a_year_level">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Contact Number</label>
                            <input type="text" class="form-control" name="a_contact_number">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="a_email">
                    </div>

                    <div class="form-group">
                        <label>Address (Street/Barangay)</label>
                        <input type="text" class="form-control" name="a_street_barangay">
                    </div>

                    <div class="form-group">
                        <label>Zip Code</label>
                        <input type="text" class="form-control" name="a_zipcode">
                    </div>

                    <hr>
                    <h5><b>Father Information</b></h5>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Father Last Name</label>
                            <input type="text" class="form-control" name="a_father_last_name">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Father Given Name</label>
                            <input type="text" class="form-control" name="a_father_given_name">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Father Middle Name</label>
                            <input type="text" class="form-control" name="a_father_middle_name">
                        </div>
                    </div>

                    <hr>
                    <h5><b>Mother Information</b></h5>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Mother Last Name</label>
                            <input type="text" class="form-control" name="a_mother_last_name">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Mother Given Name</label>
                            <input type="text" class="form-control" name="a_mother_given_name">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Mother Middle Name</label>
                            <input type="text" class="form-control" name="a_mother_middle_name">
                        </div>
                    </div>

                    <hr>
                    <h5><b>Other</b></h5>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Disability</label>
                            <input type="text" class="form-control" name="a_disability">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Indigenous Group</label>
                            <input type="text" class="form-control" name="a_indigenous_group">
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Application</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- EDIT -->
<div class="modal fade" id="EditApplicationForm" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Application</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <form method="POST" action="{{ route('applications.update') }}">
                @csrf
                <input type="hidden" name="ea_id" id="edit_app_id">

                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Student ID</label>
                            <input type="text" class="form-control" name="ea_student_id" id="edit_student_id">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Sex</label>
                            <select class="form-control" name="ea_sex" id="edit_sex">
                                <option value="">Select</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Last Name</label>
                            <input type="text" class="form-control" name="ea_last_name" id="edit_last_name">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Given Name</label>
                            <input type="text" class="form-control" name="ea_given_name" id="edit_given_name">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Middle Name</label>
                            <input type="text" class="form-control" name="ea_middle_name" id="edit_middle_name">
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Ext Name</label>
                                <input type="text" class="form-control" name="ea_ext_name" id="edit_ext_name">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Birthdate</label>
                            <input type="date" class="form-control" name="ea_birthdate" id="edit_birthdate">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Program</label>
                            <input type="text" class="form-control" name="ea_program_name" id="edit_program_name">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Year Level</label>
                            <input type="text" class="form-control" name="ea_year_level" id="edit_year_level">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Contact Number</label>
                            <input type="text" class="form-control" name="ea_contact_number" id="edit_contact_number">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="ea_email" id="edit_email">
                    </div>

                    <div class="form-group">
                        <label>Address (Street/Barangay)</label>
                        <input type="text" class="form-control" name="ea_street_barangay" id="edit_street_barangay">
                    </div>

                    <div class="form-group">
                        <label>Zip Code</label>
                        <input type="text" class="form-control" name="ea_zipcode" id="edit_zipcode">
                    </div>

                    <hr>
                    <h5><b>Father Information</b></h5>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Father Last Name</label>
                            <input type="text" class="form-control" name="ea_father_last_name" id="edit_father_last_name">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Father Given Name</label>
                            <input type="text" class="form-control" name="ea_father_given_name" id="edit_father_given_name">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Father Middle Name</label>
                            <input type="text" class="form-control" name="ea_father_middle_name" id="edit_father_middle_name">
                        </div>
                    </div>

                    <hr>
                    <h5><b>Mother Information</b></h5>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Mother Last Name</label>
                            <input type="text" class="form-control" name="ea_mother_last_name" id="edit_mother_last_name">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Mother Given Name</label>
                            <input type="text" class="form-control" name="ea_mother_given_name" id="edit_mother_given_name">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Mother Middle Name</label>
                            <input type="text" class="form-control" name="ea_mother_middle_name" id="edit_mother_middle_name">
                        </div>
                    </div>

                    <hr>
                    <h5><b>Other</b></h5>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Disability</label>
                            <input type="text" class="form-control" name="ea_disability" id="edit_disability">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Indigenous Group</label>
                            <input type="text" class="form-control" name="ea_indigenous_group" id="edit_indigenous_group">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Application</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- VIEW -->
<div class="modal fade" id="ViewApplicationModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Application Details</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div id="view-app-content">
                    <p class="text-center text-muted">Loading...</p>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- DELETE -->
<div class="modal fade" id="DeleteApplicationModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Delete Application</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <p>Are you sure you want to delete this application?</p>
                <p><strong id="delete-app-name"></strong></p>
                <p class="text-muted">Note: This action cannot be undone!</p>
            </div>

            <form method="POST" action="{{ route('applications.destroy') }}">
                @csrf
                <input type="hidden" name="da_id" id="delete_app_id">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
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
@stop