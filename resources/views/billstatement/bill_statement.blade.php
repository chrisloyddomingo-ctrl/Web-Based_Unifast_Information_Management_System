@extends('adminlte::page')

@section('title', 'Bill Statement')

@section('content_header')
    <h1>Bill Statement</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Bill Statement Report</h3>
        <div class="card-tools">    
            <a href="{{ route('reports.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
    <div class="card-body">
        <h6>Tes Continues List</h6>
    </div>
        <div class="card-body">
        <h6>Tes New List</h6>
    </div>
    <br>
        <div class="card-body">
        <h6>Tdp Continues List</h6>
    </div>
        <div class="card-body">
        <h6>Tdp New List</h6>
    </div>
</div>
@endsection