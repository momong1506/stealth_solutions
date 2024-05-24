<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .alert {
            position: fixed;
            z-index: 9999;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
  <div class="container mt-4">
    <div class="row">
          <div class="col-md-8">
              <a href="{{ route('dashboard') }}" class="btn btn-primary">Dashboard</a>
              <a href="{{ route('users') }}" class="btn btn-primary">Users</a>
              <a href="{{ route('user_roles') }}" class="btn btn-primary">Roles</a>
              <a href="{{ route('permissions') }}" class="btn btn-primary">Permissions</a>
              <a href="{{ route('products') }}" class="btn btn-primary">Products</a>
              <a href="{{ route('categories') }}" class="btn btn-primary">Categories</a>
          </div>
          <div class="col-md-4">
              <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button class="btn btn-danger float-right" type="submit">Logout</button>
              </form>
              <button type="button" class="btn btn-primary float-right mr-3" data-toggle="modal" data-target="#changePasswordModal">
                Change Password
              </button>
          </div>
      </div>
      <br>
      <h4>Welcome {{ $user->name }}</h4>
      @if (session('error'))
          <div class="alert alert-danger" id="error-alert">
              {{ session('error') }}
          </div>
      @endif
  </div>
  @include('user_management.change_password_modal')
  <script>
        // JavaScript to hide the alert after 5 seconds
        document.addEventListener('DOMContentLoaded', function () {
            var alert = document.getElementById('error-alert');
            if (alert) {
                setTimeout(function () {
                    alert.style.display = 'none';
                }, 3000);
            }
        });
    </script>
    <!-- Include jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Include Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>