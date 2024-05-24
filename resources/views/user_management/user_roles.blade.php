<!DOCTYPE html>
<html>
<head>
    <title>Roles</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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

    <div>
        <!-- Button to trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createFormModal">
            Add Role
        </button>
    </div>
    <br />

    <div class="card">
        <div class="card-header text-center font-weight-bold">
          Roles
        </div>
        <div class="card-body">
          <div class="row">
              <div class="col-md-12">
                  <table class="table">
                      <tr>
                          <th width="35%">Role Name</th>
                          <th width="30%">Permissions</th>
                          <th width="15%">Action</th>
                      </tr>
                      @foreach ($user_roles as $user_role)
                      <tr class="data-container">
                          <td class="role_name"> {{ $user_role['user_role']->role_name }}</td>
                          <td class="permissions">
                                @foreach($user_role['permissions'] as $rolePermission)
                                    <span> {{ $rolePermission->module_name }} </span>
                                    <input class="permission_ids" type="hidden" value="{{ $rolePermission->id }}">
                                    <br>
                                @endforeach
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="button" class="update-role btn btn-primary" data-toggle="modal" data-target="#updateFormModal">
                                           Update
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <form method="POST" action="{{ route('delete_user_roles') }}">
                                            <input type="hidden" class="record_id" value="{{ $user_role['user_role']->id }}" name="id">
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
    <!-- Create Modal -->
    <div class="modal" id="createFormModal">
        <div class="modal-dialog">
            <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add Role</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
                <!-- Modal body -->
                <form id="create-form" action="{{ route('create_user_roles') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="role_name">Role Name</label>
                            <input class="form-control" type="text" name="role_name" value="" required>
                        </div>
                        <div class="form-group">
                            <label for="permissions">Permissions</label>
                            <select multiple class="form form-control selectpicker" id="permissions" name="permissions[]" data-live-search="true">
                                @foreach ($permissions as $permission)
                                    <option value="{{ $permission->id }}"> {{ $permission->module_name }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger" id="create-submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Update Modal -->
    <div class="modal" id="updateFormModal">
        <div class="modal-dialog">
            <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Update Role</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
                <!-- Modal body -->
                <form id="update-form" action="{{ route('update_user_roles') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <input id="record_id" type="hidden" name="id">
                        <div class="form-group">
                            <label for="role_name">Role Name</label>
                            <input class="form-control" type="text" id="role_name" name="role_name" value="" required>
                        </div>
                        <div class="form-group">
                            <label for="permission">Permission</label>
                            <select multiple class="form form-control selectpicker" id="permissions" name="permissions[]" data-live-search="true">
                                @foreach ($permissions as $permission)
                                    <option value="{{ $permission->id }}"> {{ $permission->module_name }} </option>
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
    $('.update-role').on('click', function () {

        var recordId = $(this).parent().parent().parent().parent().find('.record_id').val();
        var roleName = $(this).parent().parent().parent().parent().find('.role_name').html();
        var permissionElements = $(this).parent().parent().parent().parent().find('.permission_ids');
        var permissionIds = [];

        permissionElements.each(function(index, elem) {
                permissionIds.push($(elem).val())
        });

        $('#update-form').find('#record_id').val(recordId);
        $('#update-form').find('#role_name').val(roleName);
        $('#update-form').find('#permissions').val(permissionIds);

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