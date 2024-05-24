<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div id="content" class="flex">
        <div class="page-content page-container" id="page-content">
            <div class="padding">
                <div class="registration-container row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header"><strong>Register</strong></div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label>Name:</label>
                                        <input class="form-control" type="text" name="name" value="{{ old('name') }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Email:</label>
                                        <input class="form-control" type="email" name="email" value="{{ old('email') }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Password:</label>
                                        <input class="form-control" type="password" name="password" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Confirm Password:</label>
                                        <input class="form-control" type="password" name="password_confirmation" required>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-primary form-control">Register</button>
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
                                </form>
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