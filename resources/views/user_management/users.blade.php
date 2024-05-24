<!DOCTYPE html>
<html>
<head>
    <title>Users</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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

    <div class="card">
        <div class="card-header text-center font-weight-bold">
          Users
        </div>
        <div class="card-body">
          <div class="row">
              <div class="col-md-12">
                  <table class="table">
                      <tr>
                          <th width="30%">Name</th>
                          <th width="25%">Email</th>
                          <th width="25%">Role</th>
                          <th width="20%">Action</th>
                      </tr>
                      @foreach ($users as $user)

                        <tr>
                            <td class="name"> {{ $user->name }}</td>
                            <td class="email">  {{ $user->email }} </td>
                            <td class="role">  {{ $user->role_name }} </td>
                            <td>
                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="button" class="update-user btn btn-primary" data-toggle="modal" data-target="#updateFormModal">
                                           Update
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <form method="POST" action="{{ route('delete_user_roles') }}">
                                            <input type="hidden" class="record_id" value="{{ $user->id }}" name="id">
                                            <input type="hidden" class="user_roles_id" value="{{ $user->user_roles_id }}" name="user_roles_id">
                                            @csrf
                                            <button class="btn btn-danger float-right" type="submit">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                      @endforeach
                  </table>
              </div>
          </div>
      </div>
    </div>
  </div>

  @include('user_management.change_password_modal')
  <!-- Update Modal -->
  <div class="modal" id="updateFormModal">
        <div class="modal-dialog">
            <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Update User</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
                <!-- Modal body -->
                <form id="update-form" action="{{ route('update_user') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <input id="record_id" type="hidden" name="id">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input class="form-control" type="text" id="name" name="name" value="">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input class="form-control" type="email" id="email" name="email" value="">
                        </div>
                        <div class="form-group">
                            <label for="user_roles_id">Role</label>
                            <select class="form form-control" id="user_roles_id" name="user_roles_id">
                                @foreach ($user_roles as $user_role)
                                    <option value="{{ $user_role->id }}"> {{ $user_role->role_name }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger" id="update-submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Include jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Include Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

<script>
  $(document).ready(function() {
    $('.update-user').on('click', function () {

        var recordId = $(this).parent().parent().parent().parent().find('.record_id').val();
        var userRolesId = $(this).parent().parent().parent().parent().find('.user_roles_id').val();
        var name = $(this).parent().parent().parent().parent().find('.name').html();
        var email = $(this).parent().parent().parent().parent().find('.email').html();

        $('#update-form').find('#record_id').val(recordId);
        $('#update-form').find('#name').val(name);
        $('#update-form').find('#email').val(email);
        $('#update-form').find('#user_roles_id').val(userRolesId);

    });

    $('#create-submit-btn').on('click', function(e) {
      e.preventDefault();
      var formData = $('#create-form').serialize();

      $.ajax({
        type: 'POST',
        url: $('#create-form').attr('action'),
        data: formData,
        success: function(response) {
          // Handle success response
          console.log(response);
          // Optionally, close the modal
          $('#createFormModal').modal('hide');

          location.reload();
        },
        error: function(xhr, status, error) {
          // Handle error response
          console.error(xhr.responseText);
        }
      });

    });

    $('#update-submit-btn').on('click', function(e) {
        e.preventDefault();
        var formData = $('#update-form').serialize();

        $.ajax({
            type: 'POST',
            url: $('#update-form').attr('action'),
            data: formData,
            success: function(response) {
                // Handle success response
                console.log(response);
                // Optionally, close the modal
                $('#updateFormModal').modal('hide');

                location.reload()
            },
            error: function(xhr, status, error) {
            // Handle error response
            console.error(xhr.responseText);
            }
        });
    });

  });
</script>
</html>