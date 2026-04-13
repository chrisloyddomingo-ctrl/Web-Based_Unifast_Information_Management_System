@extends('adminlte::page')

@section('title', 'Deactivate Account')

@section('content_header')
    <h1>Deactivate Account</h1>
@stop

@section('content')
    <div class="alert alert-warning">
        <strong>Warning:</strong> This will deactivate your account.
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('myaccount.destroy') }}">
                @csrf
                @method('DELETE')

                <button class="btn btn-danger" type="submit">
                    Yes, Deactivate My Account
                </button>

                <a class="btn btn-secondary" href="{{ route('myaccount.view') }}">
                    Cancel
                </a>
            </form>
        </div>
    </div>
@stop