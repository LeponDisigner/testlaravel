@extends('Accueil')

@section('titre', 'Change your email adress')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-5 mx-auto">
                <h1 class="text-center text-muted mb-3 mt-5">Change your email adress</h1>

                @include('alert.alert_message')

                <form action="{{ route('App_activation_account_change_email', ['token'=>$token]) }}" method="post">
                    <div class="mb-3">
                        <label for="new-email" class="form-label">Enter the new email adress</label>
                        <input type="email" class="form-control @if (Session::has('danger')) is-invalid @endif" name="new-email" id="new-email" placeholder="your new adress"value="@if (Session::has('new_email')){{ Session::get('new_email') }} @endif" required>
                    </div>
                    <div class="d-grid gap-2 mt-3">
                        <button class="btn btn-primary" type="submit">Change</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
