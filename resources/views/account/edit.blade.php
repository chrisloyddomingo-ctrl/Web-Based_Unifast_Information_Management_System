@extends('adminlte::page')

@section('title', 'Update Account')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Update Account</h1>
    </div>
@stop

@section('content')

    @if($errors->any())
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle mr-1"></i>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @php
        $avatar = $user->avatar ?? null;
        $avatarUrl = $avatar
            ? asset('storage/' . $avatar)
            : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=0D8ABC&color=fff';
    @endphp

    <div class="row">

        {{-- LEFT SIDE --}}
        <div class="col-md-4">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile text-center">

                    <img
                        class="profile-user-img img-fluid img-circle profile-user-main-img"
                        src="{{ $avatarUrl }}"
                        alt="Profile picture"
                    >

                    <h3 class="profile-username mt-3 mb-1">{{ old('name', $user->name) }}</h3>

                    <p class="text-muted mb-2">
                        <span class="badge badge-info px-3 py-2">
                            {{ $user->role ?? 'User' }}
                        </span>
                    </p>

                    <p class="mb-3">
                        <span class="badge badge-{{ ($user->status ?? 'active') === 'active' ? 'success' : 'secondary' }} px-3 py-2">
                            {{ ucfirst($user->status ?? 'active') }}
                        </span>
                    </p>

                    <a href="{{ route('myaccount.view') }}" class="btn btn-secondary btn-block">
                        <i class="fas fa-arrow-left mr-1"></i> Back to My Account
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle mr-1"></i> Account Info
                    </h3>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>User ID:</strong> {{ $user->id }}</p>
                    <p class="mb-2"><strong>Role:</strong> {{ $user->role ?? 'User' }}</p>
                    <p class="mb-2"><strong>Status:</strong> {{ ucfirst($user->status ?? 'active') }}</p>
                    <p class="mb-2"><strong>Joined:</strong> {{ $user->created_at?->format('M d, Y') ?? '-' }}</p>
                    <p class="mb-0"><strong>Last Updated:</strong> {{ $user->updated_at?->diffForHumans() ?? '-' }}</p>
                </div>
            </div>
        </div>

        {{-- RIGHT SIDE --}}
        <div class="col-md-8">
            <form method="POST" action="{{ route('myaccount.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">
                            <i class="fas fa-user-edit mr-1"></i> Edit Profile Details
                        </h3>

                        <button
                            type="button"
                            class="btn btn-warning btn-sm"
                            data-toggle="modal"
                            data-target="#changePasswordModal"
                        >
                            <i class="fas fa-key mr-1"></i> Change Password
                        </button>
                    </div>

                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Full Name</label>
                                    <input
                                        type="text"
                                        name="name"
                                        id="name"
                                        class="form-control"
                                        value="{{ old('name', $user->name) }}"
                                        required
                                    >
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input
                                        type="email"
                                        name="email"
                                        id="email"
                                        class="form-control"
                                        value="{{ old('email', $user->email) }}"
                                        required
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input
                                        type="text"
                                        name="phone"
                                        id="phone"
                                        class="form-control"
                                        value="{{ old('phone', $user->phone) }}"
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea
                                name="address"
                                id="address"
                                rows="3"
                                class="form-control"
                            >{{ old('address', $user->address) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="avatar">Profile Picture</label>
                            <div class="mb-2">
                                <img
                                    src="{{ $avatarUrl }}"
                                    alt="Current Avatar"
                                    class="profile-avatar-preview img-thumbnail"
                                    width="100"
                                    height="100"
                                >
                            </div>
                            <input
                                type="file"
                                name="avatar"
                                id="avatar"
                                class="form-control"
                                accept="image/*"
                            >
                            <small class="text-muted">Accepted: jpg, jpeg, png, webp</small>
                        </div>

                    </div>

                    <div class="card-footer d-flex justify-content-end">
                        <a href="{{ route('myaccount.view') }}" class="btn btn-secondary mr-2">
                            <i class="fas fa-times mr-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Save Profile Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- CHANGE PASSWORD MODAL --}}
    <div class="modal fade" id="changePasswordModal" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('myaccount.password.update') }}">
                @csrf
                @method('PUT')

                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title">
                            <i class="fas fa-key mr-1"></i> Change Password
                        </h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group">
                            <label>Current Password</label>
                            <div class="input-group">
                                <input type="password" name="current_password" id="current_password" class="form-control" required>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary toggle-password" data-target="#current_password">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>New Password</label>
                            <div class="input-group">
                                <input type="password" name="password" id="new_password" class="form-control" required>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary toggle-password" data-target="#new_password">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mt-2">
                                <div class="progress password-strength-progress">
                                    <div id="passwordStrengthBar" class="progress-bar" style="width:0%"></div>
                                </div>
                                <small id="passwordStrengthText" class="text-muted">
                                    Password strength: —
                                </small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Confirm New Password</label>
                            <div class="input-group">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary toggle-password" data-target="#password_confirmation">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <small id="passwordMatchText"></small>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-key mr-1"></i> Update Password
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/account/edit.css') }}">
@stop

@section('js')
<script>
    window.openPasswordModalOnLoad =
        {{ $errors->has('current_password') || $errors->has('password') || $errors->has('password_confirmation') ? 'true' : 'false' }};

    window.successMessage =
        {!! session('success') ? json_encode(session('success')) : 'null' !!};
</script>

<script src="{{ asset('js/account/edit.js') }}"></script>
@stop