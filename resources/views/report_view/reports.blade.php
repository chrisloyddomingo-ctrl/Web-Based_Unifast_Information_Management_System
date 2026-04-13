@extends('adminlte::page')

@section('title', 'Reports')

@section('content_header')
    <div class="reports-header-wrap">
        <div>
            <h1 class="reports-page-title mb-1">Reports</h1>
        </div>
    </div>
@stop

@section('content')
<style>
    :root {
        --orange-main: #e67e22;
        --orange-dark: #c96a16;
        --orange-light: #fff4e8;
        --orange-soft: #fef8f2;
        --text-main: #2f2f2f;
        --text-muted: #6b7280;
        --border-soft: #ead9c8;
        --white: #ffffff;
        --shadow-soft: 0 8px 22px rgba(0, 0, 0, 0.08);
        --shadow-hover: 0 14px 30px rgba(230, 126, 34, 0.18);
        --radius-lg: 18px;
        --radius-md: 14px;
    }

    .reports-header-wrap {
        background: linear-gradient(135deg, #fff8f1 0%, #fff1e3 100%);
        border: 1px solid #f3dcc3;
        border-left: 6px solid var(--orange-main);
        border-radius: 18px;
        padding: 18px 22px;
        margin-bottom: 22px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
    }

    .reports-page-title {
        font-size: 1.9rem;
        font-weight: 700;
        color: var(--text-main);
        letter-spacing: 0.2px;
    }

    .reports-page-subtitle {
        color: var(--text-muted);
        font-size: 0.98rem;
    }

    .report-card-link,
    .report-card-link:hover,
    .report-card-link:focus {
        text-decoration: none;
        color: inherit;
    }

    .report-card {
        position: relative;
        background: var(--white);
        border: 1px solid #f0dfcf;
        border-radius: var(--radius-lg);
        padding: 22px 20px;
        min-height: 210px;
        overflow: hidden;
        box-shadow: var(--shadow-soft);
        transition: all 0.25s ease;
        margin-bottom: 20px;
    }

    .report-card:hover,
    .report-card:focus-within {
        transform: translateY(-4px);
        box-shadow: var(--shadow-hover);
        border-color: #efc79f;
    }

    .report-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 6px;
        background: linear-gradient(90deg, var(--orange-main), #f4a340);
    }

    .report-card-icon {
        width: 62px;
        height: 62px;
        border-radius: 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 16px;
        background: var(--orange-light);
        color: var(--orange-dark);
        border: 1px solid #f0cfad;
    }

    .report-card-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 8px;
        line-height: 1.4;
    }

    .report-card-text {
        font-size: 0.95rem;
        color: var(--text-muted);
        margin-bottom: 18px;
        min-height: 42px;
        line-height: 1.6;
    }

    .report-card-action {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        border-radius: 10px;
        background: var(--orange-main);
        color: #fff;
        font-weight: 600;
        font-size: 0.92rem;
        transition: all 0.2s ease;
        border: none;
    }

    .report-card:hover .report-card-action,
    .report-card:focus-within .report-card-action {
        background: var(--orange-dark);
        color: #fff;
    }

    .report-section-card {
        border: 1px solid #efdfce;
        border-radius: 20px;
        box-shadow: var(--shadow-soft);
        overflow: hidden;
        margin-top: 8px;
        background: #fff;
    }

    .report-section-header {
        background: linear-gradient(135deg, #fff8f2 0%, #fff1e5 100%);
        border-bottom: 1px solid #efdfce;
        padding: 16px 22px;
    }

    .report-section-title {
        margin: 0;
        font-size: 1.08rem;
        font-weight: 700;
        color: var(--text-main);
    }

    .report-section-body {
        padding: 22px;
        background: #fffdfa;
    }

    .additional-report-box {
        background: #fff;
        border: 1px solid #efdfce;
        border-radius: 16px;
        padding: 18px;
        height: 100%;
        display: flex;
        gap: 14px;
        align-items: flex-start;
        transition: all 0.25s ease;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05);
        margin-bottom: 18px;
    }

    .additional-report-box:hover,
    .additional-report-box:focus-within {
        transform: translateY(-3px);
        box-shadow: var(--shadow-hover);
        border-color: #efc79f;
    }

    .additional-report-icon {
        flex: 0 0 56px;
        width: 56px;
        height: 56px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--orange-light);
        color: var(--orange-dark);
        font-size: 1.35rem;
        border: 1px solid #f0cfad;
    }

    .additional-report-content {
        flex: 1;
    }

    .additional-report-label {
        display: block;
        font-size: 0.9rem;
        color: var(--text-muted);
        margin-bottom: 4px;
    }

    .additional-report-title {
        display: block;
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 12px;
        line-height: 1.5;
    }

    .report-btn-outline {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: 1px solid var(--orange-main);
        color: var(--orange-dark);
        background: #fffaf5;
        border-radius: 10px;
        padding: 8px 14px;
        font-size: 0.9rem;
        font-weight: 600;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .report-btn-outline:hover,
    .report-btn-outline:focus {
        background: var(--orange-main);
        color: #fff;
        text-decoration: none;
    }

    .report-card-link:focus .report-card,
    .report-btn-outline:focus {
        outline: 3px solid rgba(230, 126, 34, 0.28);
        outline-offset: 2px;
    }

    @media (max-width: 767.98px) {
        .report-card {
            min-height: auto;
        }

        .reports-page-title {
            font-size: 1.55rem;
        }

        .reports-header-wrap {
            padding: 16px 18px;
        }

        .report-section-body {
            padding: 18px;
        }
    }
</style>

<div class="container-fluid px-0">

    <div class="row">
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('reports.grantees') }}" class="report-card-link">
                <div class="report-card">
                    <div class="report-card-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h4 class="report-card-title">List of Grantees</h4>
                    <p class="report-card-text">View all grantees</p>
                    <span class="report-card-action">
                        Open Report <i class="fas fa-arrow-right"></i>
                    </span>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-lg-3">
            <a href="{{ route('reports.outstanding') }}" class="report-card-link">
                <div class="report-card">
                    <div class="report-card-icon">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <h4 class="report-card-title">Students with Outstanding</h4>
                    <p class="report-card-text">Outstanding students list</p>
                    <span class="report-card-action">
                        Open Report <i class="fas fa-arrow-right"></i>
                    </span>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-lg-3">
            <a href="{{ route('reports.disbursement') }}" class="report-card-link">
                <div class="report-card">
                    <div class="report-card-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <h4 class="report-card-title">Bill Statements</h4>
                    <p class="report-card-text">Grantee financial records</p>
                    <span class="report-card-action">
                        Open Report <i class="fas fa-arrow-right"></i>
                    </span>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-lg-3">
            <a href="{{ route('reports.attendance') }}" class="report-card-link">
                <div class="report-card">
                    <div class="report-card-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h4 class="report-card-title">Attendance Summary</h4>
                    <p class="report-card-text">Grantee attendance records</p>
                    <span class="report-card-action">
                        Open Report <i class="fas fa-arrow-right"></i>
                    </span>
                </div>
            </a>
        </div>
    </div>

    <div class="report-section-card">
        <div class="report-section-header">
            <h3 class="report-section-title">Additional Reports</h3>
        </div>

        <div class="report-section-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="additional-report-box">
                        <div class="additional-report-icon">
                            <i class="fas fa-wheelchair"></i>
                        </div>
                        <div class="additional-report-content">
                            <span class="additional-report-label">Reports for PWD</span>
                            <span class="additional-report-title">PWD Students</span>
                            <a href="{{ route('reports.pwd') }}" class="report-btn-outline">
                                Open Report <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="additional-report-box">
                        <div class="additional-report-icon">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                        <div class="additional-report-content">
                            <span class="additional-report-label">Parents Income</span>
                            <span class="additional-report-title">Monthly income report</span>
                            <a href="{{ route('reports.parents_income') }}" class="report-btn-outline">
                                Open Report <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="additional-report-box">
                        <div class="additional-report-icon">
                            <i class="fas fa-layer-group"></i>
                        </div>
                        <div class="additional-report-content">
                            <span class="additional-report-label">Generation</span>
                            <span class="additional-report-title">First generation report</span>
                            <a href="{{ route('reports.generation') }}" class="report-btn-outline">
                                Open Report <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@stop