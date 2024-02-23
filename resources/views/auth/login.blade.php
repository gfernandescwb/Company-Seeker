@extends('layouts.app')

@section('title', 'Login')

@section('content')

    <main class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group text-center">
                                <h2 class="text-center">Login</h2>

                                <hr>

                                <h4>Welcome back! 😎</h4>
                            </div>

                            <div class="form-group">
                                <label for="emailAddress">E-mail:</label>
                                <input type="email" class="form-control" name="email" id="emailAddress"
                                    placeholder="Enter your e-mail..." required>
                            </div>

                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" class="form-control" name="password" id="password"
                                    placeholder="Enter your password" required>
                            </div>

                            @if ($errors->any())
                                <div class="alert alert-danger" style="margin: 1rem 0;">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <button type="submit" class="btn btn-primary btn-lg btn-block">Enter</button>

                            <div class="text-center" style="margin: 1rem 0;">
                                <span>Does not have an account? Go to <a class="nav-link"
                                        href="{{ route('signup.form') }}">register</a></span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
