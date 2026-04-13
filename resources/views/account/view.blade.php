@extends('adminlte::page')

@section('title', 'My Account')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">My Account</h1>
    </div>
@stop

@section('content')

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="row">

        {{-- LEFT: Profile Card --}}
        <div class="col-md-4">

            <div class="card card-primary card-outline">
                <div class="card-body box-profile text-center">

                    {{-- Avatar --}}
                    @php
                        // If you store avatar in DB: $user->avatar (path)
                        $avatar = $user->avatar ?? null;
                        $avatarUrl = $avatar ? asset('storage/'.$avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=0D8ABC&color=fff';
                    @endphp

                    <img class="profile-user-img img-fluid img-circle"
                         src="{{ $avatarUrl }}"
                         alt="User profile picture"
                         style="width:120px;height:120px;object-fit:cover;">

                    <h3 class="profile-username mt-3">{{ $user->name }}</h3>

                    {{-- Role --}}
                    <p class="text-muted mb-2">
                        <span class="badge badge-info">
                            {{ $user->role ?? 'User' }}
                        </span>
                    </p>

                    {{-- Status (optional field) --}}
                    <p class="mb-3">
                        <span class="badge badge-{{ ($user->status ?? 'active') === 'active' ? 'success' : 'secondary' }}">
                            {{ ucfirst($user->status ?? 'active') }}
                        </span>
                    </p>

                    {{-- Quick actions --}}
                    <a class="btn btn-primary btn-block" href="{{ route('myaccount.edit') }}">
                        <i class="fas fa-user-edit"></i> Edit Profile
                    </a>

                </div>
            </div>

            {{-- Small Info Boxes --}}
            <div class="small-box bg-info">
                <div class="inner">
                    <h5 class="mb-0">Joined</h5>
                    <p class="mb-0">{{ $user->created_at?->format('M d, Y') ?? '-' }}</p>
                </div>
                
            </div>

            <div class="small-box bg-success">
                <div class="inner">
                    <h5 class="mb-0">Last Updated</h5>
                    <p class="mb-0">{{ $user->updated_at?->diffForHumans() ?? '-' }}</p>
                </div>
            </div>

        </div>

        {{-- RIGHT: Details --}}
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-id-card"></i> Account Details
                    </h3>
                </div>

                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>User ID:</strong> {{ $user->id }}</p>
                            <p><strong>Name:</strong> {{ $user->name }}</p>
                            <p><strong>Email:</strong> {{ $user->email }}</p>
                        </div>

                        <div class="col-md-6">
                            <p><strong>Role:</strong> {{ $user->role ?? 'User' }}</p>
                            <p><strong>Phone:</strong> {{ $user->phone ?? '-' }}</p>
                            <p><strong>Address:</strong> {{ $user->address ?? '-' }}</p>
                            <p><strong>Status:</strong> {{ ucfirst($user->status ?? 'active') }}</p>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Created At:</strong> {{ $user->created_at?->format('F d, Y h:i A') ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Updated At:</strong> {{ $user->updated_at?->format('F d, Y h:i A') ?? '-' }}</p>
                        </div>
                    </div>

                    {{-- Optional: if you store last login --}}
                    {{-- <hr>
                    <p><strong>Last Login:</strong> {{ $user->last_login_at?->format('F d, Y h:i A') ?? '-' }}</p> --}}

                </div>

                <div class="card-footer d-flex justify-content-end">
                    <a class="btn btn-primary" href="{{ route('myaccount.edit') }}">
                        <i class="fas fa-edit"></i> Update Account
                    </a>
                </div>
            </div>

        </div>
    </div>

@stop