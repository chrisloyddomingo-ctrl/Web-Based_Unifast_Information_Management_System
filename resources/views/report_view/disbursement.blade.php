@extends('adminlte::page')

@section('title', 'Bill Statements Report')

@section('content_header')
    <div class="report-page-header">
        <div>
            <h1 class="report-page-title mb-1">Bill Statements</h1>
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
        padding: 35px 20px;
        background: #fffdfa;
    }

    .coming-soon-box {
        max-width: 700px;
        margin: 0 auto;
        text-align: center;
        background: #fff8f2;
        border: 1px solid #f0dbc7;
        border-radius: 18px;
        padding: 35px 25px;
    }

    .coming-soon-icon {
        width: 78px;
        height: 78px;
        margin: 0 auto 18px;
        border-radius: 20px;
        background: #fff1e3;
        color: #d97706;
        border: 1px solid #f0cfad;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
    }

    .coming-soon-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: #2f2f2f;
        margin-bottom: 10px;
    }

    .coming-soon-text {
        color: #6b7280;
        font-size: 1rem;
        margin-bottom: 0;
        line-height: 1.7;
    }
</style>

<div class="card report-card">
    <div class="report-card-header">
        <h3 class="report-card-title">Bill Statement Report</h3>
    </div>

    <div class="report-card-body">
        <div class="coming-soon-box">
            <div class="coming-soon-icon">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <h4 class="coming-soon-title">This feature is not available yet.</h4>
            <p class="coming-soon-text">Bill statement report will be added soon.</p>
        </div>
    </div>
</div>
@stop