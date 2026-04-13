@extends('adminlte::page')

@section('title', 'Edit User')

@section('content_header')
    <h1>Edit User</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Name</label>
                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            value="{{ old('name', $user->name) }}"
                        >
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email</label>
                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            value="{{ old('email', $user->email) }}"
                        >
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Phone</label>
                        <input
                            type="text"
                            name="phone"
                            class="form-control"
                            value="{{ old('phone', $user->phone) }}"
                        >
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Role</label>
                        <select name="role" class="form-control">
                            @php $currentRole = old('role', $user->role); @endphp
                            <option value="admin" {{ $currentRole === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="staff" {{ $currentRole === 'staff' ? 'selected' : '' }}>Staff</option>
                            <option value="user"  {{ $currentRole === 'user'  ? 'selected' : '' }}>User</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            @php $currentStatus = old('status', $user->status); @endphp
                            <option value="active" {{ $currentStatus === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $currentStatus === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Address</label>
                        <textarea
                            name="address"
                            class="form-control"
                            rows="3"
                        >{{ old('address', $user->address) }}</textarea>
                    </div>
                </div>

            </div>

            <button type="submit" class="btn btn-success">
                Update User
            </button>

            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                Cancel
            </a>

        </form>

    </div>
</div>

@stop