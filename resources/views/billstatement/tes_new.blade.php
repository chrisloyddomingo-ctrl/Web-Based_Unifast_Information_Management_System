@extends('adminlte::page')

@section('title', 'TES New')

@section('content_header')
<h1 class="text-orange"><i class="fas fa-file-invoice"></i> TES New List</h1>
@stop

@section('content')
@include('billstatement.partials.styles')

<div class="card report-card">
    <div class="card-header report-header">
        TES NEW BILL STATEMENT
    </div>

    <div class="card-body table-responsive">
        <table class="table table-bordered table-hover report-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Student Name</th>
                    <th>School</th>
                    <th>Course</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data ?? [] as $key => $row)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $row->name ?? '' }}</td>
                    <td>{{ $row->school ?? '' }}</td>
                    <td>{{ $row->course ?? '' }}</td>
                    <td>₱ {{ number_format($row->amount ?? 0,2) }}</td>
                    <td><span class="badge badge-primary">New</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">No data available</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection