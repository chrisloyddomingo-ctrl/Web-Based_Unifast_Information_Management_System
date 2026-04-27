@extends('adminlte::page')

@section('title', 'Bill Statement')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="page-title">Bill Statement</h1>

    <a href="{{ route('reports.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>
@stop

@section('content')
<style>
    .page-title {
        color: #8a3f00;
        font-weight: 700;
    }

    .bill-card {
        border: none;
        border-radius: 14px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .bill-header {
        background: linear-gradient(90deg, #8a3f00, #ff8c1a);
        color: #fff;
        padding: 18px 22px;
    }

    .bill-header h3 {
        margin: 0;
        font-weight: 700;
        font-size: 20px;
    }

    .statement-box {
        border: 1px solid #f0d5bd;
        border-radius: 12px;
        padding: 20px;
        background: #fffaf5;
        transition: 0.2s ease;
        height: 100%;
    }

    .statement-box:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 16px rgba(138,63,0,0.15);
    }

    .statement-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: #ff8c1a;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        margin-bottom: 14px;
    }

    .statement-title {
        color: #8a3f00;
        font-weight: 700;
        font-size: 17px;
        margin-bottom: 6px;
    }

    .statement-desc {
        color: #666;
        font-size: 14px;
        margin-bottom: 16px;
    }

    .btn-orange {
        background: #ff8c1a;
        color: #fff;
        border: none;
        font-weight: 600;
    }

    .btn-orange:hover {
        background: #d96c00;
        color: #fff;
    }
</style>

<div class="card bill-card">
    <div class="bill-header">
        <h3><i class="fas fa-file-invoice-dollar mr-2"></i> Bill Statement Report</h3>
        <small>Generate bill statements based on the official Excel templates.</small>
    </div>

    <div class="card-body">
        <div class="row">

            <div class="col-md-6 col-lg-3 mb-4">
                <div class="statement-box">
                    <div class="statement-icon">
                        <i class="fas fa-file-excel"></i>
                    </div>
                    <div class="statement-title">TES Continuing List</div>
                    <div class="statement-desc">Generate report using TES-CONTI template.</div>
                    <a href="{{ route('tes.continuing') }}" class="btn btn-orange btn-sm btn-block">
                        <i class="fas fa-eye"></i> Open Report
                    </a>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-4">
                <div class="statement-box">
                    <div class="statement-icon">
                        <i class="fas fa-file-excel"></i>
                    </div>
                    <div class="statement-title">TES New List</div>
                    <div class="statement-desc">Generate report using TES-NEW template.</div>
                    <a href="{{ route('tes.new') }}" class="btn btn-orange btn-sm btn-block">
                        <i class="fas fa-eye"></i> Open Report
                    </a>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-4">
                <div class="statement-box">
                    <div class="statement-icon">
                        <i class="fas fa-file-excel"></i>
                    </div>
                    <div class="statement-title">TDP Continuing List</div>
                    <div class="statement-desc">Generate report using TDP-ONGOING template.</div>
                    <a href="{{ route('tdp.continuing') }}" class="btn btn-orange btn-sm btn-block">
                        <i class="fas fa-eye"></i> Open Report
                    </a>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-4">
                <div class="statement-box">
                    <div class="statement-icon">
                        <i class="fas fa-file-excel"></i>
                    </div>
                    <div class="statement-title">TDP New List</div>
                    <div class="statement-desc">Generate report using TDP-NEW template.</div>
                    <a href="{{ route('tdp.new') }}" class="btn btn-orange btn-sm btn-block">
                        <i class="fas fa-eye"></i> Open Report
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection