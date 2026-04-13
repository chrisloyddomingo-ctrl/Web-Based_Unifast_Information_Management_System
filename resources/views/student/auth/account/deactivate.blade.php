@extends('layouts.student')

@section('content')
<div class="row">
    <div class="col-12 col-lg-8">
        <div class="card card-danger">
            <div class="card-header">
                <h3 class="card-title">Deactivate My Account</h3>
            </div>

            <div class="card-body">
                <div class="alert alert-warning">
                    Deactivating your account will disable your student access.
                </div>

                <form method="POST" action="{{ route('student.account.deactivate') }}">
                    @csrf

                    <div class="form-group">
                        <label>Enter Password to Confirm</label>
                        <input type="password" name="password" class="form-control" required>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-danger btn-block btn-md-auto">
                        Deactivate Account
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection