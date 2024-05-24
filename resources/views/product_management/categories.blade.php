<!DOCTYPE html>
<html>
<head>
    <title>Categories</title>
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
            Add Category
        </button>
    </div>
    <br />

    <div class="card">
        <div class="card-header text-center font-weight-bold">
          Categories
        </div>
        <div class="card-body">
          <div class="row">
              <div class="col-md-12">
                  <table class="table">
                      <tr>
                          <th width="65%">Category Name</th>
                          <th width="15%">Action</th>
                      </tr>
                      @foreach ($categories as $category)
                      <tr class="data-container">
                          <td class="category_name"> {{ $category->category_name }}</td>
                            <td>
                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="button" class="update-category btn btn-primary" data-toggle="modal" data-target="#updateFormModal">
                                           Update
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <form method="POST" action="{{ route('delete_categories') }}">
                                            <input type="hidden" class="record_id" value="{{ $category->id }}" name="id">
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
                <h4 class="modal-title">Add Category</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
                <!-- Modal body -->
                <form id="create-form" action="{{ route('create_categories') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="category_name">Name</label>
                            <input class="form-control" type="text" name="category_name" value="" required>
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
                <h4 class="modal-title">Update Category</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
                <!-- Modal body -->
                <form id="update-form" action="{{ route('update_categories') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <input id="record_id" type="hidden" name="id">
                        <div class="form-group">
                            <label for="category_name">Name</label>
                            <input class="form-control" type="text" id="category_name" name="category_name" value="" required>
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
    $('.update-category').on('click', function () {

        var recordId = $(this).parent().parent().parent().parent().find('.record_id').val();
        var categoryName = $(this).parent().parent().parent().parent().find('.category_name').html();

        $('#update-form').find('#record_id').val(recordId);
        $('#update-form').find('#category_name').val(categoryName);

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