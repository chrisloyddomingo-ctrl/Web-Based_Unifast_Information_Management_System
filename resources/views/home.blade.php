@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="dashboard-hero">
        <div class="hero-left">
            <div class="hero-badge">
                <i class="fas fa-home mr-2"></i> UniFAST Information Management System
            </div>
            <h1 class="dashboard-title mb-2">Dashboard</h1>
        </div>

        <div class="hero-right">
            <div class="hero-date-card">
                <span class="hero-date-label">Today</span>
                <span class="hero-date-value">{{ now()->format('F d, Y') }}</span>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="dashboard-wrapper">

        {{-- Alerts --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm custom-alert" role="alert" aria-live="polite">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle mr-2" aria-hidden="true"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close success message">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (session('warning'))
            <div class="alert alert-warning alert-dismissible fade show shadow-sm custom-alert" role="alert" aria-live="polite">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>
                    <span>{{ session('warning') }}</span>
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close warning message">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        {{-- Summary Cards --}}
        <section class="section-block">

            <div class="row mt-3">

                {{-- Total Grantees --}}
                <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-4">
                    <a href="{{ route('grantees.index') }}" class="dashboard-stat-card stat-card-orange text-decoration-none" aria-label="Open Manage Grantees">
                        <div class="stat-top">
                            <div class="stat-text">
                                <p class="stat-label">Total Grantees</p>
                                <h3 class="stat-value">{{ $stats['total_grantees'] ?? 0 }}</h3>
                                <span class="stat-note">
                                    <i class="fas fa-folder-open mr-1" aria-hidden="true"></i> Manage Grantees
                                </span>
                            </div>
                            <div class="stat-icon" aria-hidden="true">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                        </div>
                    </a>
                </div>

                {{-- Announcements --}}
                <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-4">
                    <a href="{{ route('post_management_pagination') }}" class="dashboard-stat-card stat-card-amber text-decoration-none" aria-label="Open Announcements">
                        <div class="stat-top">
                            <div class="stat-text">
                                <p class="stat-label">Announcements</p>
                                <h3 class="stat-value">{{ $stats['total_posts'] ?? 0 }}</h3>
                                <span class="stat-note">
                                    <i class="fas fa-bullhorn mr-1" aria-hidden="true"></i> View Announcements
                                </span>
                            </div>
                            <div class="stat-icon" aria-hidden="true">
                                <i class="fas fa-bullhorn"></i>
                            </div>
                        </div>
                    </a>
                </div>

                {{-- Total Users --}}
                <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-4">
                    <a href="{{ route('users.index') }}" class="dashboard-stat-card stat-card-dark text-decoration-none" aria-label="Open Manage Users">
                        <div class="stat-top">
                            <div class="stat-text">
                                <p class="stat-label">Total Users</p>
                                <h3 class="stat-value">{{ $stats['total_users'] ?? 0 }}</h3>
                                <span class="stat-note">
                                    <i class="fas fa-users-cog mr-1" aria-hidden="true"></i> Manage Users
                                </span>
                            </div>
                            <div class="stat-icon" aria-hidden="true">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </a>
                </div>

                {{-- Pending Applications --}}
                <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-4">
                    <a href="{{ route('applications.index') }}" class="dashboard-stat-card stat-card-soft-red text-decoration-none" aria-label="Open Review Applications">
                        <div class="stat-top">
                            <div class="stat-text">
                                <p class="stat-label">Pending Approval</p>
                                <h3 class="stat-value">{{ $stats['pending_applications'] ?? 0 }}</h3>
                                <span class="stat-note">
                                    <i class="fas fa-clipboard-check mr-1" aria-hidden="true"></i> Review Applications
                                </span>
                            </div>
                            <div class="stat-icon" aria-hidden="true">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                    </a>
                </div>

                {{-- Attendance --}}
                <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-4">
                    <a href="{{ route('attendance.index') }}" class="dashboard-stat-card stat-card-gold text-decoration-none" aria-label="Open Attendance">
                        <div class="stat-top">
                            <div class="stat-text">
                                <p class="stat-label">Attendance Events</p>
                                <h3 class="stat-value">{{ $stats['total_attendance'] ?? 0 }}</h3>
                                <span class="stat-note">
                                    <i class="fas fa-calendar-check mr-1" aria-hidden="true"></i> Open Attendance
                                </span>
                            </div>
                            <div class="stat-icon" aria-hidden="true">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                        </div>
                    </a>
                </div>

                {{-- Bill Statements --}}
                <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-4">
                    <a href="{{ route('reports.disbursement') }}" class="dashboard-stat-card stat-card-muted text-decoration-none" aria-label="Open Bill Statements">
                        <div class="stat-top">
                            <div class="stat-text">
                                <p class="stat-label">Bill Statements</p>
                                <h3 class="stat-value">{{ $stats['disbursement_report'] ?? 0 }}</h3>
                                <span class="stat-note">
                                    <i class="fas fa-file-invoice-dollar mr-1" aria-hidden="true"></i> View Bill Statements
                                </span>
                            </div>
                            <div class="stat-icon" aria-hidden="true">
                                <i class="fas fa-file-invoice-dollar"></i>
                            </div>
                        </div>
                    </a>
                </div>

            </div>
        </section>
    </div>
@stop

@section('css')
<style>
    :root {
        --orange-main: #d97706;
        --orange-dark: #b45309;
        --orange-soft: #fff4e6;
        --orange-border: #f3d3a2;
        --gold-soft: #fff7db;
        --dark-text: #1f2937;
        --muted-text: #6b7280;
        --page-bg: #f7f8fa;
        --card-bg: #ffffff;
        --border-soft: #e5e7eb;
        --shadow-soft: 0 8px 24px rgba(15, 23, 42, 0.06);
        --shadow-hover: 0 12px 28px rgba(15, 23, 42, 0.12);
        --focus-ring: 0 0 0 0.22rem rgba(217, 119, 6, 0.28);
    }

    html {
        scroll-behavior: smooth;
    }

    body {
        font-size: 15px;
        background: var(--page-bg);
        color: var(--dark-text);
    }

    .content-wrapper {
        background: var(--page-bg) !important;
    }

    .dashboard-wrapper {
        padding-bottom: 16px;
    }

    .dashboard-hero {
        background: linear-gradient(135deg, #fff8f0 0%, #ffffff 100%);
        border: 1px solid var(--orange-border);
        border-radius: 22px;
        padding: 22px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 18px;
        box-shadow: var(--shadow-soft);
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        background: #fff1df;
        color: var(--orange-dark);
        border: 1px solid #f6d3a3;
        padding: 8px 14px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .dashboard-title {
        font-size: 32px;
        font-weight: 800;
        color: var(--dark-text);
        letter-spacing: -0.3px;
    }

    .dashboard-subtitle {
        color: var(--muted-text);
        font-size: 15px;
        max-width: 760px;
        line-height: 1.6;
    }

    .hero-date-card {
        min-width: 190px;
        background: #ffffff;
        border: 1px solid var(--border-soft);
        border-left: 5px solid var(--orange-main);
        border-radius: 18px;
        padding: 14px 16px;
        box-shadow: var(--shadow-soft);
        text-align: left;
    }

    .hero-date-label {
        display: block;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--muted-text);
        letter-spacing: 0.08em;
        margin-bottom: 4px;
    }

    .hero-date-value {
        display: block;
        font-size: 18px;
        font-weight: 700;
        color: var(--dark-text);
    }

    .custom-alert {
        border: 0;
        border-radius: 14px;
        margin-top: 18px;
    }

    .section-block {
        margin-top: 22px;
        margin-bottom: 8px;
    }

    .section-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .section-title {
        font-size: 22px;
        font-weight: 800;
        color: var(--dark-text);
    }

    .section-subtitle,
    .card-subtitle {
        color: var(--muted-text);
        font-size: 14px;
    }

    .dashboard-stat-card {
        background: var(--card-bg);
        border-radius: 20px;
        padding: 20px;
        box-shadow: var(--shadow-soft);
        height: 100%;
        border: 1px solid var(--border-soft);
        display: block;
        transition: all 0.22s ease;
        color: inherit;
        min-height: 165px;
    }

    .dashboard-stat-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-hover);
        text-decoration: none;
    }

    .dashboard-stat-card:focus,
    .quick-action-btn:focus,
    .btn-orange:focus,
    .btn-orange-outline:focus {
        outline: none;
        box-shadow: var(--focus-ring);
    }

    .stat-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 14px;
        height: 100%;
    }

    .stat-text {
        flex: 1;
    }

    .stat-label {
        margin-bottom: 8px;
        font-size: 14px;
        font-weight: 700;
        color: var(--muted-text);
    }

    .stat-value {
        margin: 0;
        font-size: 32px;
        font-weight: 800;
        color: var(--dark-text);
        line-height: 1.1;
    }

    .stat-note {
        display: inline-flex;
        align-items: center;
        margin-top: 14px;
        font-size: 13px;
        font-weight: 700;
        color: var(--dark-text);
        background: rgba(17, 24, 39, 0.04);
        border-radius: 999px;
        padding: 8px 12px;
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0;
        border: 1px solid transparent;
    }

    .stat-card-orange .stat-icon {
        background: #fff1df;
        color: #c96b00;
        border-color: #f3d3a2;
    }

    .stat-card-amber .stat-icon {
        background: #fff5dd;
        color: #b78103;
        border-color: #f2dd98;
    }

    .stat-card-dark .stat-icon {
        background: #f3f4f6;
        color: #374151;
        border-color: #d9dde3;
    }

    .stat-card-soft-red .stat-icon {
        background: #fff1f2;
        color: #be123c;
        border-color: #fecdd3;
    }

    .stat-card-gold .stat-icon {
        background: #fff7db;
        color: #a16207;
        border-color: #f5df92;
    }

    .stat-card-muted .stat-icon {
        background: #f5f5f5;
        color: #52525b;
        border-color: #e4e4e7;
    }

    .dashboard-card {
        border-radius: 20px;
        border: 1px solid var(--border-soft);
        box-shadow: var(--shadow-soft);
        overflow: hidden;
        background: #fff;
    }

    .dashboard-card-header {
        background: #fff;
        border-bottom: 1px solid #eef2f7;
        padding: 18px 20px;
    }

    .dashboard-card .card-title {
        font-size: 19px;
        font-weight: 800;
        color: var(--dark-text);
    }

    .quick-actions-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    .quick-action-btn {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        min-height: 108px;
        border-radius: 18px;
        text-decoration: none !important;
        padding: 16px;
        border: 1px solid var(--border-soft);
        transition: all 0.2s ease;
    }

    .quick-action-btn:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-soft);
    }

    .quick-action-icon {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 19px;
        flex-shrink: 0;
    }

    .quick-action-title {
        display: block;
        font-size: 15px;
        font-weight: 800;
        margin-bottom: 3px;
    }

    .quick-action-desc {
        display: block;
        font-size: 12.5px;
        line-height: 1.5;
    }

    .qa-orange {
        background: #fff8f0;
        color: #8a4b00;
    }

    .qa-orange .quick-action-icon {
        background: #ffe8cc;
        color: #c96b00;
    }

    .qa-orange-soft {
        background: #fffaf4;
        color: #8a4b00;
    }

    .qa-orange-soft .quick-action-icon {
        background: #ffedd5;
        color: #c96b00;
    }

    .qa-light {
        background: #fff;
        color: #374151;
    }

    .qa-light .quick-action-icon {
        background: #f3f4f6;
        color: #4b5563;
    }

    .qa-dark {
        background: #f8fafc;
        color: #1f2937;
    }

    .qa-dark .quick-action-icon {
        background: #e5e7eb;
        color: #374151;
    }

    .qa-gold {
        background: #fffdf4;
        color: #8a6200;
    }

    .qa-gold .quick-action-icon {
        background: #fff1bf;
        color: #a16207;
    }

    .qa-neutral {
        background: #fafafa;
        color: #3f3f46;
    }

    .qa-neutral .quick-action-icon {
        background: #ededed;
        color: #52525b;
    }

    .announcement-scroll {
        max-height: 470px;
        overflow-y: auto;
    }

    .announcement-item {
        padding: 18px 20px;
        border-bottom: 1px solid #f1f3f5;
    }

    .announcement-item:last-child {
        border-bottom: 0;
    }

    .announcement-title {
        font-size: 15px;
        font-weight: 800;
        color: var(--dark-text);
        line-height: 1.5;
    }

    .announcement-text {
        font-size: 13px;
        line-height: 1.7;
    }

    .announcement-date {
        font-size: 12px;
        white-space: nowrap;
    }

    .empty-state {
        padding: 42px 20px;
        text-align: center;
    }

    .empty-state-icon {
        width: 68px;
        height: 68px;
        margin: 0 auto 14px;
        border-radius: 18px;
        background: #fff1df;
        color: var(--orange-main);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
    }

    .empty-state-title {
        font-size: 18px;
        font-weight: 800;
        color: var(--dark-text);
        margin-bottom: 6px;
    }

    .empty-state-text {
        color: var(--muted-text);
        font-size: 14px;
    }

    .dashboard-help-card {
        background: linear-gradient(135deg, #fff8f0 0%, #ffffff 100%);
        border: 1px solid var(--orange-border);
        border-radius: 20px;
        padding: 22px 24px;
        box-shadow: var(--shadow-soft);
    }

    .help-title {
        font-size: 20px;
        font-weight: 800;
        color: var(--dark-text);
    }

    .help-text {
        font-size: 14px;
        color: var(--muted-text);
        line-height: 1.7;
    }

    .btn-orange {
        background: var(--orange-main);
        border-color: var(--orange-main);
        color: #fff;
        font-weight: 700;
        border-radius: 12px;
        padding: 10px 18px;
    }

    .btn-orange:hover {
        background: var(--orange-dark);
        border-color: var(--orange-dark);
        color: #fff;
    }

    .btn-orange-outline {
        background: #fff;
        border: 1px solid var(--orange-main);
        color: var(--orange-main);
        font-weight: 700;
        border-radius: 10px;
        padding: 8px 14px;
    }

    .btn-orange-outline:hover {
        background: var(--orange-main);
        color: #fff;
    }

    .logout-modal-content {
        border-radius: 20px;
        overflow: hidden;
        border: 0;
        box-shadow: 0 16px 40px rgba(15, 23, 42, 0.18);
    }

    .logout-modal-header {
        background: linear-gradient(135deg, var(--orange-main), var(--orange-dark));
        color: #fff;
        border-bottom: 0;
        padding: 1rem 1.25rem;
    }

    .logout-modal-icon {
        font-size: 3rem;
        color: var(--orange-main);
    }

    .logout-modal-btn {
        min-width: 130px;
        font-weight: 700;
        border-radius: 999px;
    }

    #logoutModal .btn-light {
        border: 1px solid #dee2e6;
    }

    .announcement-scroll::-webkit-scrollbar {
        width: 10px;
    }

    .announcement-scroll::-webkit-scrollbar-track {
        background: #f3f4f6;
        border-radius: 10px;
    }

    .announcement-scroll::-webkit-scrollbar-thumb {
        background: #c7cdd6;
        border-radius: 10px;
    }

    .announcement-scroll::-webkit-scrollbar-thumb:hover {
        background: #a4acb8;
    }

    @media (max-width: 991.98px) {
        .dashboard-title {
            font-size: 28px;
        }

        .quick-actions-grid {
            grid-template-columns: 1fr;
        }

        .announcement-date {
            margin-top: 10px;
        }
    }

    @media (max-width: 767.98px) {
        .dashboard-hero {
            padding: 18px;
        }

        .dashboard-title {
            font-size: 24px;
        }

        .section-title {
            font-size: 19px;
        }

        .stat-value {
            font-size: 28px;
        }

        .dashboard-stat-card {
            min-height: auto;
        }

        .quick-action-btn {
            min-height: 95px;
        }

        .hero-date-card {
            width: 100%;
        }

        .announcement-scroll {
            max-height: 360px;
        }
    }
</style>
@stop

@section('js')
<script>
    $(document).ready(function () {
        $(document).on('click', '#logout-btn a, #logout-btn, #open-logout-modal-btn', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $('#logoutModal').modal('show');
        });

        $('#confirm-logout-btn').on('click', function () {
            $('#logout-form').submit();
        });

        console.log('Accessible orange dashboard loaded successfully.');
    });
</script>
@stop