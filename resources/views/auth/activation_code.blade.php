@extends('Accueil')

@section('titre', 'Account Activation')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-4 mx-auto">
                <h1 class="text-center text-muted mb-3 mt-5">Activation Account</h1>

              @include('alert.alert_message')

                <form action="{{ route('App_activation_code', ['token' => $token]) }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="activation-code" class="form-label">Activation code</label>
                        <input type="text" class="form-control  @if (Session::has('danger')) is-invalid @endif" name="activation-code" id="activation-code" value="@if (Session::has('activation_code')){{ Session::get('activation_code') }} @endif" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('App_activation_account_change_email', ['token'=> $token]) }}">change your email adress</a>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('App_reset_activation_code', ['token' => $token]) }}">Resend the activation code</a>
                        </div>
                    </div>
                    <div class="d-grid gap-2 mt-3">
                        <button class="btn btn-primary" type="submit">Activate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
