@extends('adminlte::page')

@section('title', 'Attendance')

@section('content_header')
    <div class="attendance-header-wrap">
        <div>
            <h1 class="attendance-page-title mb-1">Attendance Events</h1>
        </div>

        <button class="btn attendance-add-btn" data-toggle="modal" data-target="#addEventModal">
            <i class="fas fa-plus-circle mr-1"></i> Add Event
        </button>
    </div>
@stop

@section('css')
<style>
    :root {
        --attendance-orange: #e67e22;
        --attendance-orange-dark: #c96a12;
        --attendance-orange-light: #fff4ea;
        --attendance-orange-soft: #fdf0e3;
        --attendance-border: #ead8c7;
        --attendance-text: #2f2f2f;
        --attendance-muted: #6b7280;
        --attendance-bg: #fffaf5;
        --attendance-white: #ffffff;
        --attendance-success-bg: #edf9f0;
        --attendance-success-text: #166534;
        --attendance-danger-bg: #fef2f2;
        --attendance-danger-text: #b91c1c;
        --attendance-warning-bg: #fff8e6;
        --attendance-warning-text: #9a6700;
        --attendance-info-bg: #eef6ff;
        --attendance-info-text: #1d4ed8;
        --attendance-shadow: 0 10px 30px rgba(230, 126, 34, 0.10);
        --attendance-radius-lg: 18px;
        --attendance-radius-md: 12px;
        --attendance-radius-sm: 10px;
    }

    .content-wrapper,
    .content,
    .wrapper {
        background-color: var(--attendance-bg) !important;
    }

    .attendance-header-wrap {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
        margin-bottom: 18px;
        padding: 18px 20px;
        background: linear-gradient(135deg, #fff8f1, #fff1e4);
        border: 1px solid #f3dcc7;
        border-radius: 18px;
        box-shadow: var(--attendance-shadow);
    }

    .attendance-page-title {
        font-size: 1.8rem;
        font-weight: 800;
        color: #8f4a09;
        letter-spacing: 0.2px;
    }

    .attendance-page-subtitle {
        color: var(--attendance-muted);
        font-size: 0.98rem;
    }

    .attendance-add-btn {
        background: var(--attendance-orange);
        color: #fff;
        border: none;
        border-radius: 12px;
        padding: 11px 18px;
        font-weight: 700;
        box-shadow: 0 8px 18px rgba(230, 126, 34, 0.18);
        transition: all 0.2s ease;
    }

    .attendance-add-btn:hover,
    .attendance-add-btn:focus {
        background: var(--attendance-orange-dark);
        color: #fff;
        transform: translateY(-1px);
    }

    .attendance-alert {
        border: none;
        border-radius: 12px;
        padding: 14px 16px;
        font-weight: 600;
        box-shadow: 0 6px 16px rgba(0,0,0,0.04);
    }

    .attendance-alert.alert-success {
        background: var(--attendance-success-bg);
        color: var(--attendance-success-text);
    }

    .attendance-alert.alert-danger {
        background: var(--attendance-danger-bg);
        color: var(--attendance-danger-text);
    }

    .attendance-alert.alert-warning {
        background: var(--attendance-warning-bg);
        color: var(--attendance-warning-text);
    }

    .attendance-alert.alert-info {
        background: var(--attendance-info-bg);
        color: var(--attendance-info-text);
    }

    .attendance-card {
        border: 1px solid var(--attendance-border);
        border-radius: var(--attendance-radius-lg);
        overflow: hidden;
        box-shadow: var(--attendance-shadow);
        background: var(--attendance-white);
    }

    .attendance-card .card-header {
        background: linear-gradient(135deg, #fff6ed, #fff1e3);
        border-bottom: 1px solid var(--attendance-border);
        padding: 18px 20px;
    }

    .attendance-card-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: #8f4a09;
        margin: 0;
    }

    .attendance-card-subtitle {
        margin: 4px 0 0;
        color: var(--attendance-muted);
        font-size: 0.92rem;
    }

    .attendance-card .card-body {
        padding: 20px;
    }

    .attendance-table-wrapper {
        border: 1px solid #f1dfce;
        border-radius: 16px;
        overflow: hidden;
        background: #fff;
    }

    .attendance-table {
        margin-bottom: 0;
        color: var(--attendance-text);
    }

    .attendance-table thead th {
        background: #fff3e8;
        color: #8a4b12;
        border-bottom: 1px solid #eedbc7 !important;
        border-top: none !important;
        font-weight: 800;
        font-size: 0.94rem;
        vertical-align: middle;
        white-space: nowrap;
    }

    .attendance-table td {
        vertical-align: middle !important;
        border-color: #f3e4d7 !important;
        font-size: 0.95rem;
    }

    .attendance-table tbody tr:hover {
        background: #fffaf4;
    }

    .attendance-index-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 34px;
        height: 34px;
        padding: 0 10px;
        border-radius: 999px;
        background: #fff1e4;
        color: #a65308;
        font-weight: 800;
        border: 1px solid #f0d5bc;
    }

    .attendance-event-name {
        font-weight: 700;
        color: #2f2f2f;
    }

    .attendance-event-date {
        display: inline-block;
        background: #fff7ef;
        color: #9a5a18;
        border: 1px solid #f3dbc6;
        border-radius: 999px;
        padding: 6px 12px;
        font-weight: 700;
        font-size: 0.89rem;
    }

    .attendance-event-date.empty-date {
        background: #f7f7f7;
        color: #6b7280;
        border-color: #e5e7eb;
    }

    .attendance-action-group {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .attendance-btn {
        border: none;
        border-radius: 10px;
        padding: 8px 13px;
        font-size: 0.88rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
        text-decoration: none !important;
    }

    .attendance-btn:hover,
    .attendance-btn:focus {
        transform: translateY(-1px);
    }

    .attendance-btn-view {
        background: #eaf4ff;
        color: #0f4c81;
    }

    .attendance-btn-view:hover,
    .attendance-btn-view:focus {
        background: #dcecff;
        color: #0b3d68;
    }

    .attendance-btn-edit {
        background: #fff3df;
        color: #9a5a00;
    }

    .attendance-btn-edit:hover,
    .attendance-btn-edit:focus {
        background: #ffe8bf;
        color: #7c4700;
    }

    .attendance-btn-delete {
        background: #feeceb;
        color: #b42318;
    }

    .attendance-btn-delete:hover,
    .attendance-btn-delete:focus {
        background: #fdd9d7;
        color: #912018;
    }

    .attendance-empty-state {
        text-align: center;
        padding: 42px 20px;
        background: linear-gradient(180deg, #fffdfb, #fff6ef);
    }

    .attendance-empty-icon {
        width: 68px;
        height: 68px;
        margin: 0 auto 14px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff0e1;
        color: var(--attendance-orange);
        font-size: 1.6rem;
    }

    .attendance-empty-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: #8f4a09;
        margin-bottom: 6px;
    }

    .attendance-empty-text {
        color: var(--attendance-muted);
        margin-bottom: 0;
    }

    .modal-content {
        border: none;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 18px 40px rgba(0, 0, 0, 0.14);
    }

    .modal-header {
        background: linear-gradient(135deg, #fff7ef, #ffeedf);
        border-bottom: 1px solid #f1dcc8;
        padding: 16px 18px;
    }

    .modal-title {
        font-weight: 800;
        color: #8f4a09;
    }

    .modal-body {
        padding: 20px 18px 14px;
        background: #fffdfb;
    }

    .modal-footer {
        border-top: 1px solid #f3e1d1;
        padding: 14px 18px;
        background: #fffaf5;
    }

    .form-group label {
        font-weight: 700;
        color: #5b4636;
        margin-bottom: 8px;
    }

    .form-control {
        border-radius: 10px;
        border: 1px solid #dfc7b0;
        min-height: 44px;
        box-shadow: none !important;
    }

    .form-control:focus {
        border-color: var(--attendance-orange);
        box-shadow: 0 0 0 0.2rem rgba(230, 126, 34, 0.15) !important;
    }

    .attendance-modal-btn-cancel {
        background: #f3f4f6;
        color: #374151;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        padding: 9px 16px;
    }

    .attendance-modal-btn-save,
    .attendance-modal-btn-update {
        background: var(--attendance-orange);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        padding: 9px 16px;
    }

    .attendance-modal-btn-save:hover,
    .attendance-modal-btn-update:hover,
    .attendance-modal-btn-save:focus,
    .attendance-modal-btn-update:focus {
        background: var(--attendance-orange-dark);
        color: #fff;
    }

    .attendance-modal-btn-delete {
        background: #dc2626;
        color: #fff;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        padding: 9px 16px;
    }

    .attendance-modal-btn-delete:hover,
    .attendance-modal-btn-delete:focus {
        background: #b91c1c;
        color: #fff;
    }

    .attendance-delete-text {
        color: #4b5563;
        font-size: 0.96rem;
        line-height: 1.6;
    }

    .attendance-delete-name {
        color: #b91c1c;
        font-weight: 800;
    }

    .attendance-helper-text {
        font-size: 0.86rem;
        color: var(--attendance-muted);
        margin-top: 6px;
    }

    @media (max-width: 768px) {
        .attendance-header-wrap {
            padding: 16px;
        }

        .attendance-page-title {
            font-size: 1.45rem;
        }

        .attendance-card .card-body,
        .attendance-card .card-header {
            padding: 15px;
        }

        .attendance-action-group {
            flex-direction: column;
            align-items: stretch;
        }

        .attendance-btn {
            justify-content: center;
            width: 100%;
        }
    }
</style>
@stop

@section('content')

    @if(session('success'))
        <div class="alert attendance-alert alert-success">
            <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert attendance-alert alert-danger">
            <i class="fas fa-times-circle mr-1"></i> {{ session('error') }}
        </div>
    @endif

    @if(session('info'))
        <div class="alert attendance-alert alert-warning">
            <i class="fas fa-exclamation-circle mr-1"></i> {{ session('info') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert attendance-alert alert-danger">
            <div class="font-weight-bold mb-2">
                <i class="fas fa-exclamation-triangle mr-1"></i> Please fix the following:
            </div>
            <ul class="mb-0 pl-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card attendance-card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h3 class="attendance-card-title">Event List</h3>
            </div>
        </div>

        <div class="card-body">
            <div class="attendance-table-wrapper table-responsive">
                <table class="table attendance-table">
                    <thead>
                        <tr>
                            <th style="width: 80px;">#</th>
                            <th>Event Name</th>
                            <th style="width: 190px;">Event Date</th>
                            <th style="width: 360px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($events as $index => $event)
                            <tr>
                                <td>
                                    <span class="attendance-index-badge">{{ $index + 1 }}</span>
                                </td>

                                <td>
                                    <div class="attendance-event-name">{{ $event->event_name }}</div>
                                </td>

                                <td>
                                    @if($event->event_date)
                                        <span class="attendance-event-date">
                                            <i class="far fa-calendar-alt mr-1"></i>
                                            {{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }}
                                        </span>
                                    @else
                                        <span class="attendance-event-date empty-date">
                                            <i class="far fa-calendar-times mr-1"></i>
                                            No date set
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <div class="attendance-action-group">
                                        <a href="{{ route('attendance.showEvent', $event->id) }}"
                                           class="attendance-btn attendance-btn-view"
                                           aria-label="View grantees attended for {{ $event->event_name }}">
                                            <i class="fas fa-eye"></i>
                                            <span>View Grantees Attended</span>
                                        </a>

                                        <button class="attendance-btn attendance-btn-edit"
                                                data-toggle="modal"
                                                data-target="#editEventModal{{ $event->id }}"
                                                aria-label="Edit event {{ $event->event_name }}">
                                            <i class="fas fa-edit"></i>
                                            <span>Edit</span>
                                        </button>

                                        <button class="attendance-btn attendance-btn-delete"
                                                data-toggle="modal"
                                                data-target="#deleteEventModal{{ $event->id }}"
                                                aria-label="Delete event {{ $event->event_name }}">
                                            <i class="fas fa-trash-alt"></i>
                                            <span>Delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Edit Event Modal -->
                            <div class="modal fade" id="editEventModal{{ $event->id }}" tabindex="-1" role="dialog" aria-labelledby="editEventModalLabel{{ $event->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form action="{{ route('attendance.updateEvent', $event->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editEventModalLabel{{ $event->id }}">
                                                    <i class="fas fa-edit mr-1"></i> Edit Event
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span>&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="event_name_{{ $event->id }}">Event Name</label>
                                                    <input
                                                        type="text"
                                                        name="event_name"
                                                        id="event_name_{{ $event->id }}"
                                                        class="form-control"
                                                        value="{{ $event->event_name }}"
                                                        required
                                                    >
                                                    <div class="attendance-helper-text">
                                                        Use a clear and recognizable name for the event.
                                                    </div>
                                                </div>

                                                <div class="form-group mb-0">
                                                    <label for="event_date_{{ $event->id }}">Event Date</label>
                                                    <input
                                                        type="date"
                                                        name="event_date"
                                                        id="event_date_{{ $event->id }}"
                                                        class="form-control"
                                                        value="{{ $event->event_date }}"
                                                    >
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="attendance-modal-btn-cancel" data-dismiss="modal">
                                                    Cancel
                                                </button>
                                                <button type="submit" class="attendance-modal-btn-update">
                                                    Update Event
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Delete Event Modal -->
                            <div class="modal fade" id="deleteEventModal{{ $event->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteEventModalLabel{{ $event->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form action="{{ route('attendance.deleteEvent', $event->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-danger" id="deleteEventModalLabel{{ $event->id }}">
                                                    <i class="fas fa-trash-alt mr-1"></i> Delete Event
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span>&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                <p class="attendance-delete-text mb-0">
                                                    Are you sure you want to delete
                                                    <span class="attendance-delete-name">{{ $event->event_name }}</span>?
                                                    This action cannot be undone.
                                                </p>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="attendance-modal-btn-cancel" data-dismiss="modal">
                                                    Cancel
                                                </button>
                                                <button type="submit" class="attendance-modal-btn-delete">
                                                    Yes, Delete
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="4" class="p-0">
                                    <div class="attendance-empty-state">
                                        <div class="attendance-empty-icon">
                                            <i class="far fa-calendar-check"></i>
                                        </div>
                                        <div class="attendance-empty-title">No events found</div>
                                        <p class="attendance-empty-text">
                                            There are no attendance events yet. Click <strong>Add Event</strong> to create one.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Event Modal -->
    <div class="modal fade" id="addEventModal" tabindex="-1" role="dialog" aria-labelledby="addEventModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('attendance.storeEvent') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addEventModalLabel">
                            <i class="fas fa-plus-circle mr-1"></i> Add Event
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="event_name">Event Name</label>
                            <input type="text" name="event_name" id="event_name" class="form-control" required>
                            <div class="attendance-helper-text">
                                Example: Orientation Program, General Assembly, Payout Schedule
                            </div>
                        </div>

                        <div class="form-group mb-0">
                            <label for="event_date">Event Date</label>
                            <input type="date" name="event_date" id="event_date" class="form-control">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="attendance-modal-btn-cancel" data-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="attendance-modal-btn-save">
                            Save Event
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@stop