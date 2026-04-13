@extends('adminlte::page')

@section('title', 'List of Grantees')

@section('content_header')
    <div class="report-page-header">
        <div>
            <h1 class="report-page-title mb-1">List of Grantees</h1>
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

    .report-status-badge {
        display: inline-block;
        background: #eaf7ee;
        color: #1e7e34;
        border: 1px solid #bfe3c9;
        padding: 6px 10px;
        border-radius: 999px;
        font-weight: 700;
        font-size: 0.85rem;
    }

    .report-remark {
        color: #c0392b;
        font-weight: 600;
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
        <h3 class="report-card-title">Grantee Records</h3>
    </div>

    <div class="report-card-body table-responsive">
        <table class="table table-bordered table-hover report-table">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Course</th>
                    <th>Year</th>
                    <th>Status</th>
                    <th>Remarks</th>
                </tr>
            </thead>

            <tbody>
                @forelse($grantees as $index => $g)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>

                        <td class="text-center">
                            <span class="report-badge">{{ $g->student_id }}</span>
                        </td>

                        <td>
                            <strong>{{ strtoupper($g->last_name) }}, {{ $g->first_name }}</strong>
                            <br>
                            <small class="text-muted">{{ $g->middle_name }} {{ $g->extension_name }}</small>
                        </td>

                        <td>{{ $g->course }}</td>

                        <td class="text-center">{{ $g->year }}</td>

                        <td class="text-center">
                            <span class="report-status-badge">{{ $g->status_of_student ?? 'N/A' }}</span>
                        </td>

                        <td>
                            @if($g->remarks)
                                <span class="report-remark">{{ $g->remarks }}</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="report-empty">
                            <i class="fas fa-info-circle mr-1"></i> No grantees found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="report-footer-note">
        Total Records: <strong>{{ $grantees->count() }}</strong>
    </div>
</div>
@stop