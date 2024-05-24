<!DOCTYPE html>
<html>
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    </head>
    <body>
        <div id="content" class="flex">
            <div class="page-content page-container" id="page-content">
                <div class="padding">
                    <div class="login-container row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header"><strong>Login</strong></div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="form-group">
                                            <label>Email:</label>
                                            <input class="form-control" type="email" name="email" value="{{ old('email') }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Password:</label>
                                            <input class="form-control" type="password" name="password" required>
                                        </div>

                                        @if ($errors->any())
                                            <div>
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary form-control">Login</button>
                                        </div>
                                    </form>

                                    <div>
                                        <form method="GET" action="{{ route('register') }}">
                                            <button class="btn btn-primary form-control" type="submit">Register</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4"></div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>