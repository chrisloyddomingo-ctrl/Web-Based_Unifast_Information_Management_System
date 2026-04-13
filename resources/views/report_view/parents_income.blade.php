@extends('adminlte::page')

@section('title', 'Parents Income Report')

@section('content_header')
    <div class="report-page-header">
        <div>
            <h1 class="report-page-title mb-1">Parents Income Report</h1>
        </div>
        <a href="{{ route('reports.index') }}" class="btn report-back-btn">
            <i class="fas fa-arrow-left mr-1"></i> Back to Reports
        </a>
    </div>
@stop

@section('content')
<style>
    .report-page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
        background: linear-gradient(135deg, #fff8f1 0%, #fff1e3 100%);
        border: 1px solid #f2dcc4;
        border-left: 6px solid #e67e22;
        border-radius: 18px;
        padding: 18px 22px;
        margin-bottom: 20px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.05);
    }

    .report-page-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #2f2f2f;
    }

    .report-page-subtitle {
        color: #6b7280;
        font-size: 0.95rem;
    }

    .report-back-btn {
        background: #fff3e8;
        color: #c96a16;
        border: 1px solid #efc9a8;
        border-radius: 10px;
        font-weight: 600;
        padding: 9px 16px;
    }

    .report-back-btn:hover {
        background: #e67e22;
        color: #fff;
    }

    .report-card {
        border: 1px solid #efdccc;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 10px 24px rgba(0,0,0,0.06);
    }

    .report-card-header {
        background: linear-gradient(135deg, #fff8f2 0%, #ffefe1 100%);
        border-bottom: 1px solid #efdccc;
        padding: 16px 20px;
    }

    .report-card-title {
        margin: 0;
        font-size: 1.08rem;
        font-weight: 700;
        color: #2f2f2f;
    }

    .report-card-body {
        padding: 20px;
        background: #fffdfa;
    }

    .report-table {
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0;
    }

    .report-table thead th {
        background: #fff3e8;
        color: #8a4b08;
        font-weight: 700;
        text-align: center;
        border-bottom: 1px solid #ebd3bc !important;
        border-top: none !important;
        vertical-align: middle;
        white-space: nowrap;
    }

    .report-table th,
    .report-table td {
        border-color: #f1e1d2 !important;
        vertical-align: middle !important;
    }

    .report-table tbody tr:hover {
        background: #fffaf5;
    }

    .report-badge {
        background: #fff3e8;
        color: #b85f12;
        border: 1px solid #f0cfad;
        padding: 6px 10px;
        border-radius: 999px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .income-badge {
        display: inline-block;
        background: #fff1e3;
        color: #a8550a;
        border: 1px solid #f0cfad;
        padding: 6px 10px;
        border-radius: 999px;
        font-weight: 700;
        font-size: 0.85rem;
    }

    .report-empty {
        text-align: center;
        padding: 30px 10px !important;
        color: #6b7280;
        font-weight: 500;
    }

    .report-footer-note {
        padding: 14px 20px;
        background: #fff8f2;
        border-top: 1px solid #efdccc;
        color: #6b7280;
        font-size: 0.92rem;
    }
</style>

<div class="card report-card">
    <div class="report-card-header">
        <h3 class="report-card-title">Students by Parents Monthly Income</h3>
    </div>

    <div class="report-card-body table-responsive">
        <table class="table table-bordered table-hover report-table">
            <thead>
                <tr>
                    <th style="width: 60px;">#</th>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Program</th>
                    <th>Year Level</th>
                    <th>Parents Monthly Income</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $index => $s)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="text-center">
                            <span class="report-badge">{{ $s->student_id }}</span>
                        </td>
                        <td>
                            <strong>{{ $s->last_name }}, {{ $s->given_name }}</strong>
                            <br>
                            <small class="text-muted">{{ $s->middle_name }} {{ $s->ext_name }}</small>
                        </td>
                        <td>{{ $s->program_name }}</td>
                        <td class="text-center">{{ $s->year_level }}</td>
                        <td class="text-center">
                            <span class="income-badge">{{ $s->parents_monthly_income }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="report-empty">No records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="report-footer-note">
        Total Records: <strong>{{ $students->count() }}</strong>
    </div>
</div>
@stop