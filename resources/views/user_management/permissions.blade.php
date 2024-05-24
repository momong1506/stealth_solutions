<!DOCTYPE html>
<html>
<head>
    <title>Permissions</title>
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
            Add Permission
        </button>
    </div>
    <br />

    <div class="card">
        <div class="card-header text-center font-weight-bold">
          Permissions
        </div>
        <div class="card-body">
          <div class="row">
              <div class="col-md-12">
                  <table class="table">
                      <tr>
                          <th width="20%">Module Name</th>
                          <th width="15%">Can View</th>
                          <th width="15%">Can Create</th>
                          <th width="15%">Can Update</th>
                          <th width="15%">Can Delete</th>
                          <th width="20%">Action</th>
                      </tr>
                      @foreach ($permissions as $permission)
                        <tr class="data-container">
                            <td class="module_name"> {{ $permission->module_name }}</td>
                            <td class="can_view">  {{ $permission->can_view ? 'Yes' : 'No' }} </td>
                            <td class="can_create">  {{ $permission->can_create ? 'Yes' : 'No' }} </td>
                            <td class="can_update">  {{ $permission->can_update ? 'Yes' : 'No' }} </td>
                            <td class="can_delete">  {{ $permission->can_delete ? 'Yes' : 'No' }} </td>
                            <td>
                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="button" class="update-permission btn btn-primary" data-toggle="modal" data-target="#updateFormModal">
                                           Update
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <form method="POST" action="{{ route('delete_permissions') }}">
                                            <input type="hidden" class="record_id" value="{{ $permission->id }}" name="id">
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
                <h4 class="modal-title">Add Permission</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
                <!-- Modal body -->
                <form id="create-form" action="{{ route('create_permissions') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="module_name">Module</label>
                            <select class="form form-control" id="module_name" name="module_name">
                                <option value="users">Users</option>
                                <option value="products">Products</option>
                                <option value="product_categories">Product Categories</option>
                                <option value="permissions">Permissions</option>
                                <option value="user_roles">Roles</option>
                            </select>
                            <!-- <input type="text" class="form-control" id="module_name" name="module_name"> -->
                        </div>

                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="can_view" name="can_view">
                            <label class="custom-control-label" for="can_view">Can View</label>
                        </div>

                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="can_create" name="can_create">
                            <label class="custom-control-label" for="can_create">Can Create</label>
                        </div>

                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="can_update" name="can_update">
                            <label class="custom-control-label" for="can_update">Can Update</label>
                        </div>

                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="can_delete" name="can_delete">
                            <label class="custom-control-label" for="can_delete">Can Delete</label>
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
                <h4 class="modal-title">Update Permission</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
                <!-- Modal body -->
                <form id="update-form" action="{{ route('update_permissions') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <input id="record_id" type="hidden" name="id">
                        <div class="form-group">
                            <label for="update_module_name">Module</label>
                            <select class="form form-control" id="update_module_name" name="module_name">
                                <option value="users">Users</option>
                                <option value="products">Products</option>
                                <option value="product_categories">Product Categories</option>
                                <option value="permissions">Permissions</option>
                                <option value="user_roles">Roles</option>
                            </select>
                            <!-- <input type="text" class="form-control" id="update_module_name" name="module_name"> -->
                        </div>

                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="update_can_view" name="can_view">
                            <label class="custom-control-label" for="update_can_view">Can View</label>
                        </div>

                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="update_can_create" name="can_create">
                            <label class="custom-control-label" for="update_can_create">Can Create</label>
                        </div>

                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="update_can_update" name="can_update">
                            <label class="custom-control-label" for="update_can_update">Can Update</label>
                        </div>

                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="update_can_delete" name="can_delete">
                            <label class="custom-control-label" for="update_can_delete">Can Delete</label>
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
    $('.update-permission').on('click', function () {

        var recordId = $(this).parent().parent().parent().parent().find('.record_id').val();
        var moduleName = $(this).parent().parent().parent().parent().find('.module_name').html().trim().toLocaleLowerCase();
        var canView = $(this).parent().parent().parent().parent().find('.can_view').html().trim().toLocaleLowerCase();
        var canCreate = $(this).parent().parent().parent().parent().find('.can_create').html().trim().toLocaleLowerCase();
        var canUpdate = $(this).parent().parent().parent().parent().find('.can_update').html().trim().toLocaleLowerCase();
        var canDelete = $(this).parent().parent().parent().parent().find('.can_delete').html().trim().toLocaleLowerCase();

        $('#update-form').find('#record_id').val(recordId);
        $('#update-form').find('#update_module_name').val(moduleName);

        if (canView == 'yes') {
            $('#update-form').find('#update_can_view').removeAttr('checked');
            $('#update-form').find('#update_can_view').attr('checked', 'true');
        }

        if (canCreate == 'yes') {
            $('#update-form').find('#update_can_create').removeAttr('checked');
            $('#update-form').find('#update_can_create').attr('checked', 'true');
        }

        if (canUpdate == 'yes') {
            $('#update-form').find('#update_can_update').removeAttr('checked');
            $('#update-form').find('#update_can_update').attr('checked', 'true');
        }

        if (canDelete == 'yes') {
            $('#update-form').find('#update_can_delete').removeAttr('checked');
            $('#update-form').find('#update_can_delete').attr('checked', 'true');
        }
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