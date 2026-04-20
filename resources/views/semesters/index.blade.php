@extends('adminlte::page')

@section('title', 'Manage Semesters')

@section('content_header')
    <div class="semester-page-header">
        <div>
            <h1 class="semester-page-title">Manage Semesters</h1>
        </div>
        <div class="semester-header-actions">
            <a href="{{ route('semesters.create') }}" class="btn btn-semester-add">
                <i class="fas fa-plus mr-1"></i> Add New Semester
            </a>
        </div>
    </div>
@stop

@section('content')

    @if(session('success'))
        <div class="alert alert-success semester-alert" role="alert">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger semester-alert" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
        </div>
    @endif

    <div class="card semester-card">
        <div class="card-header semester-card-header">
            <div class="semester-card-title-wrap">
                <h3 class="card-title semester-card-title">
                    <i class="fas fa-calendar-alt mr-2"></i> Semester List
                </h3>
                <span class="semester-record-count">
                    Total: {{ $semesters->count() }}
                </span>
            </div>
        </div>

        <div class="card-body semester-card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover semester-table mb-0">
                    <thead>
                        <tr>
                            <th style="width: 70px;">#</th>
                            <th>Semester</th>
                            <th>School Year</th>
                            <th style="width: 120px;">Current</th>
                            <th style="width: 140px;">View Semester</th>
                            <th style="width: 170px;">Application Status</th>
                            <th style="width: 320px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($semesters as $index => $semester)
                            <tr>
                                <td class="semester-row-number">{{ $index + 1 }}</td>

                                <td>
                                    <div class="semester-main-text">{{ $semester->semester_name }}</div>
                                </td>

                                <td>
                                    <span class="semester-muted-text">{{ $semester->school_year }}</span>
                                </td>

                                <td>
                                    @if($semester->is_current)
                                        <span class="badge semester-badge semester-badge-current">
                                            <i class="fas fa-check-circle mr-1"></i> Current
                                        </span>
                                    @else
                                        <span class="badge semester-badge semester-badge-not-current">
                                            <i class="fas fa-circle mr-1"></i> No
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    @if($semester->is_viewing)
                                        <span class="badge semester-badge semester-badge-viewing">
                                            <i class="fas fa-eye mr-1"></i> Viewing Semester
                                        </span>
                                    @else
                                        <span class="badge semester-badge semester-badge-not-current">
                                            <i class="fas fa-eye-slash mr-1"></i> No
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    @if($semester->application_status == 'open')
                                        <span class="badge semester-badge semester-badge-open">
                                            <i class="fas fa-unlock-alt mr-1"></i> Open
                                        </span>
                                    @else
                                        <span class="badge semester-badge semester-badge-closed">
                                            <i class="fas fa-lock mr-1"></i> Closed
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <div class="semester-action-group">

                                        @if(!$semester->is_current)
                                            <form action="{{ route('semesters.setCurrent', $semester->id) }}" method="POST" class="d-inline-block semester-confirm-form">
                                                @csrf
                                                <button type="submit"
                                                        class="btn btn-sm semester-btn semester-btn-current semester-confirm-current"
                                                        data-semester="{{ $semester->school_year }} {{ $semester->semester_name }}"
                                                        title="Set as Current">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        @else
                                            <button class="btn btn-sm semester-btn semester-btn-disabled" disabled title="Currently Active">
                                                <i class="fas fa-star mr-1"></i> Current
                                            </button>
                                        @endif

                                        @if($semester->application_status == 'closed')
                                            <form action="{{ route('semesters.openApplication', $semester->id) }}" method="POST" class="d-inline-block semester-confirm-form">
                                                @csrf
                                                <button type="submit"
                                                        class="btn btn-sm semester-btn semester-btn-open semester-confirm-open"
                                                        data-semester="{{ $semester->school_year }} {{ $semester->semester_name }}"
                                                        title="Open Application">
                                                    Open
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('semesters.closeApplication', $semester->id) }}" method="POST" class="d-inline-block semester-confirm-form">
                                                @csrf
                                                <button type="submit"
                                                        class="btn btn-sm semester-btn semester-btn-close semester-confirm-close"
                                                        data-semester="{{ $semester->school_year }} {{ $semester->semester_name }}"
                                                        title="Close Application">
                                                    Close
                                                </button>
                                            </form>
                                        @endif

                                        @if(!$semester->is_viewing)
                                            <form action="{{ route('semesters.setViewing', $semester->id) }}" method="POST" class="d-inline-block semester-confirm-form">
                                                @csrf
                                                <button type="submit"
                                                        class="btn btn-sm semester-btn semester-btn-view semester-confirm-view"
                                                        data-semester="{{ $semester->school_year }} {{ $semester->semester_name }}"
                                                        title="View Semester">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </form>
                                        @else
                                            <button class="btn btn-sm semester-btn semester-btn-disabled" disabled title="Currently Viewing">
                                                <i class="fas fa-eye mr-1"></i> Viewing
                                            </button>
                                        @endif

                                        <a href="{{ route('semesters.edit', $semester->id) }}"
                                           class="btn btn-sm semester-btn semester-btn-edit"
                                           title="Edit Semester">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('semesters.destroy', $semester->id) }}" method="POST" class="d-inline-block semester-confirm-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-sm semester-btn semester-btn-delete semester-confirm-delete"
                                                    data-semester="{{ $semester->school_year }} {{ $semester->semester_name }}"
                                                    title="Delete Semester">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center semester-empty-state">
                                    <div class="semester-empty-wrap">
                                        <i class="fas fa-calendar-times semester-empty-icon"></i>
                                        <div class="semester-empty-title">No semesters found</div>
                                        <div class="semester-empty-text">Start by adding a new semester for your system.</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@stop

@section('css')
<style>
    .semester-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        flex-wrap: wrap;
        margin-bottom: 18px;
    }

    .semester-page-title {
        margin: 0;
        font-size: 1.8rem;
        font-weight: 700;
        color: #2f2f2f;
    }

    .semester-page-subtitle {
        margin: 6px 0 0;
        color: #6c757d;
        font-size: 0.95rem;
    }

    .semester-header-actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn-semester-add {
        background: linear-gradient(135deg, #ff8a00, #ff6a00);
        color: #fff !important;
        border: none;
        border-radius: 10px;
        padding: 10px 16px;
        font-weight: 600;
        box-shadow: 0 8px 18px rgba(255, 122, 0, 0.18);
        transition: 0.2s ease-in-out;
    }

    .btn-semester-add:hover,
    .btn-semester-add:focus {
        background: linear-gradient(135deg, #f57c00, #e65c00);
        color: #fff !important;
        transform: translateY(-1px);
    }

    .semester-alert {
        border-radius: 10px;
        border: none;
        font-weight: 500;
    }

    .semester-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
        overflow: hidden;
    }

    .semester-card-header {
        background: linear-gradient(135deg, #fff7f0, #ffffff);
        border-bottom: 1px solid #f1e4d8;
        padding: 16px 20px;
    }

    .semester-card-title-wrap {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
    }

    .semester-card-title {
        margin: 0;
        font-size: 1.05rem;
        font-weight: 700;
        color: #2f2f2f;
    }

    .semester-record-count {
        background: #fff0e1;
        color: #cc6b00;
        border: 1px solid #ffd3a8;
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 0.86rem;
        font-weight: 700;
    }

    .semester-card-body {
        padding: 0;
    }

    .semester-table thead th {
        background: #fff6ee;
        color: #7a4b12;
        border-color: #f3dfca !important;
        font-weight: 700;
        font-size: 0.92rem;
        vertical-align: middle;
        white-space: nowrap;
    }

    .semester-table td {
        vertical-align: middle;
        border-color: #f1f1f1 !important;
        font-size: 0.95rem;
    }

    .semester-table tbody tr:hover {
        background: #fffaf5;
    }

    .semester-row-number {
        font-weight: 700;
        color: #ff7a00;
    }

    .semester-main-text {
        font-weight: 700;
        color: #2f2f2f;
    }

    .semester-muted-text {
        color: #5f6368;
        font-weight: 500;
    }

    .semester-date {
        color: #495057;
        font-weight: 500;
        white-space: nowrap;
    }

    .semester-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
        padding: 7px 12px;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 700;
        min-width: 88px;
    }

    .semester-badge-current {
        background: #eaf8ef;
        color: #1f7a3d;
        border: 1px solid #bfe7cb;
    }

    .semester-badge-not-current {
        background: #f1f3f5;
        color: #6c757d;
        border: 1px solid #d9dee3;
    }

    .semester-badge-open {
        background: #e8f4ff;
        color: #0b63b6;
        border: 1px solid #bfdcff;
    }

    .semester-badge-closed {
        background: #fff0f0;
        color: #c0392b;
        border: 1px solid #f3c2bd;
    }

    .semester-badge-viewing {
        background: #fff4e5;
        color: #c96a00;
        border: 1px solid #ffd59c;
    }

    .semester-action-group {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: flex-start;
    }

    .semester-action-group form,
    .semester-action-group a,
    .semester-action-group button {
        margin: 0;
    }

    .semester-btn {
        border: none;
        border-radius: 8px;
        font-weight: 600;
        min-width: 44px;
        padding: 8px 12px;
        transition: 0.2s ease-in-out;
        white-space: nowrap;
    }

    .semester-btn:hover,
    .semester-btn:focus {
        transform: translateY(-1px);
    }

    .semester-btn-current {
        background: #28a745;
        color: #fff;
    }

    .semester-btn-current:hover,
    .semester-btn-current:focus {
        background: #218838;
        color: #fff;
    }

    .semester-btn-disabled {
        background: #adb5bd;
        color: #fff;
        cursor: not-allowed;
    }

    .semester-btn-open {
        background: #007bff;
        color: #fff;
    }

    .semester-btn-open:hover,
    .semester-btn-open:focus {
        background: #0069d9;
        color: #fff;
    }

    .semester-btn-close {
        background: #343a40;
        color: #fff;
    }

    .semester-btn-close:hover,
    .semester-btn-close:focus {
        background: #23272b;
        color: #fff;
    }

    .semester-btn-view {
        background: #fd7e14;
        color: #fff;
    }

    .semester-btn-view:hover,
    .semester-btn-view:focus {
        background: #e96b02;
        color: #fff;
    }

    .semester-btn-edit {
        background: #f39c12;
        color: #fff;
    }

    .semester-btn-edit:hover,
    .semester-btn-edit:focus {
        background: #d68910;
        color: #fff;
    }

    .semester-btn-delete {
        background: #dc3545;
        color: #fff;
    }

    .semester-btn-delete:hover,
    .semester-btn-delete:focus {
        background: #c82333;
        color: #fff;
    }

    .semester-empty-state {
        padding: 40px 20px !important;
        background: #fff;
    }

    .semester-empty-wrap {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #6c757d;
    }

    .semester-empty-icon {
        font-size: 2rem;
        color: #ff9b3d;
        margin-bottom: 10px;
    }

    .semester-empty-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: #343a40;
    }

    .semester-empty-text {
        margin-top: 4px;
        font-size: 0.92rem;
        color: #6c757d;
    }

    @media (max-width: 768px) {
        .semester-page-header {
            align-items: flex-start;
        }

        .semester-page-title {
            font-size: 1.45rem;
        }

        .semester-table thead th,
        .semester-table td {
            white-space: nowrap;
        }

        .semester-action-group {
            min-width: 260px;
        }
    }
</style>
@stop

@section('adminlte_js')
<script>
    $(function () {
        const themeColor = '#ff8a00';

        function showConfirmation(event, $button, title, text, confirmText) {
            event.preventDefault();
            const $form = $button.closest('form');

            if ($form.length === 0) {
                return;
            }

            function submitForm() {
                $form.submit();
            }

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: title,
                    text: text,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: confirmText,
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: themeColor,
                    reverseButtons: true,
                    customClass: {
                        popup: 'swal2-theme'
                    }
                }).then(function (result) {
                    if (result.value) {
                        submitForm();
                    }
                });
            } else {
                if (confirm(text)) {
                    submitForm();
                }
            }
        }

        $(document).on('click', '.semester-confirm-current', function (event) {
            const semesterName = $(this).data('semester') || 'this semester';
            showConfirmation(event, $(this), 'Set Current Semester', `Set ${semesterName} as the current semester?`, 'Yes, make current');
        });

        $(document).on('click', '.semester-confirm-open', function (event) {
            const semesterName = $(this).data('semester') || 'this semester';
            showConfirmation(event, $(this), 'Open Applications', `Open applications for ${semesterName}?`, 'Yes, open');
        });

        $(document).on('click', '.semester-confirm-close', function (event) {
            const semesterName = $(this).data('semester') || 'this semester';
            showConfirmation(event, $(this), 'Close Applications', `Close applications for ${semesterName}?`, 'Yes, close');
        });

        $(document).on('click', '.semester-confirm-view', function (event) {
            const semesterName = $(this).data('semester') || 'this semester';
            showConfirmation(event, $(this), 'View Semester', `Set ${semesterName} as the active view?`, 'Yes, view it');
        });

        $(document).on('click', '.semester-confirm-delete', function (event) {
            const semesterName = $(this).data('semester') || 'this semester';
            showConfirmation(event, $(this), 'Delete Semester', `This will permanently delete ${semesterName}. Are you sure?`, 'Yes, delete it');
        });
    });
</script>
@stop