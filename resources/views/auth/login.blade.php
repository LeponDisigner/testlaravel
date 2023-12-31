@extends('Accueil')

@section('titre', 'login')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-4 mx-auto">
            <h1 class="text-center text-muted mb-3 mt-5">pleace sign in</h1>
            <p class="text-center text-muted mb-5">your articles witing for you</p>
            <form action="{{ route('login') }}" method="post">
                @csrf

                @include('alert.alert_message')

                @error('email')
                    <div class="alert alert-danger text-center" role="alert">
                        {{ $message }}
                    </div>
                @enderror

                @error('password')
                    <div class="alert alert-danger text-center" role="alert">
                        {{ $message }}
                    </div>
                @enderror
                    <label for="email">email</label>
                    <input type="email" name="email" id="email" class="form-control mb-3" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    <label for="password">password</label>
                    <input type="password" name="password" id="password" class="form-control mb-3" value="{{ old('password') }}" required autocomplete="corrent-password">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ old('remember' ? 'checked' : '') }}" id="remember" name="remember">
                                <label class="form-check-label" for="remember">
                                  Remember me
                                </label>
                              </div>
                        </div>

                        <div class="col-md-6 text-end">
                            <a href="#">forgot password</a>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" type="submit">Sign in</button>
                    </div>

                    <p class="text-center text-muted mb-5">if you not registed? <a href="{{ route('register') }}">Cread compt</a></p>
            </form>
        </div>
    </div>
</div>

@endsection
