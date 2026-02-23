@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Dashboard</h1>

        <div class="btn-group">
            <a href="{{ route('menu_pagination') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-list"></i> Unifast Menu
            </a>
            <a href="{{ route('post_management_pagination') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-file-alt"></i> Posts
            </a>
        </div>
    </div>
@stop

@section('content')
    {{-- Alerts --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i> {{ session('warning') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- =======================
        STATS BOXES (CONNECTED)
    ======================== --}}
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $stats['total_posts'] ?? 0 }}</h3>
                    <p>Total Grantees</p>
                </div>
                <div class="icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <a href="{{ route('post_management_pagination') }}" class="small-box-footer">
                    Manage Grantees <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $stats['total_users'] ?? 0 }}</h3>
                    <p>Total Users</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ route('registration_pagination') }}" class="small-box-footer">
                    View Users <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        {{-- placeholders for future Unifast Grantees stats --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $stats['total_grantees'] ?? 0 }}</h3>
                    <p>Grantees Graduated</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <a href="{{ route('menu_pagination') }}" class="small-box-footer">
                    Unifast Module <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $stats['pending_grantees'] ?? 0 }}</h3>
                    <p>Pending Grantees</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
                <a href="{{ route('menu_pagination') }}" class="small-box-footer">
                    Review Pending <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

        {{-- Recent Posts --}}
        <div class="col-md-6">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Recent Grantees</h3>
                    <div class="card-tools">
                        <a href="{{ route('post_management_pagination') }}" class="btn btn-tool">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                    </div>
                </div>

                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($recentPosts ?? [] as $p)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="text-truncate" style="max-width: 75%;">
                                    <strong>{{ $p->title }}</strong>
                                    <div class="text-muted small">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($p->content), 60) }}
                                    </div>
                                </div>
                                <span class="text-muted small">
                                    {{ optional($p->created_at)->format('M d, Y') }}
                                </span>
                            </li>
                        @empty
                            <li class="list-group-item text-muted text-center py-4">
                                No recent grantees found.
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
                <div class="card-footer text-muted">
                    <strong>Web-Based Unifast Management System</strong>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- Optional: custom styles --}}
    <style>
        .small-box .icon i { font-size: 48px; }
    </style>
@stop

@section('js')
    <script>
        console.log("Dashboard loaded (AdminLTE).");
    </script>
@stop
