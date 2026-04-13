@extends('layouts.student')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="mb-3">
            <h1 class="h3">Update My Account</h1>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('student.account.update') }}">
                    @csrf

                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            <label>Full Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $student->name) }}">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $student->email) }}">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <label>Course</label>
                            <input type="text" name="course" class="form-control" value="{{ old('course', $student->course) }}">
                            @error('course')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <label>Year Level</label>
                            <input type="text" name="year_level" class="form-control" value="{{ old('year_level', $student->year_level) }}">
                            @error('year_level')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-12">
                            <hr>
                            <h5>Change Password</h5>
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <label>New Password</label>
                            <input type="password" name="password" class="form-control">
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <label>Confirm New Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block btn-md-auto">
                                Update Account
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection