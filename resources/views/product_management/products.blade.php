<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
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
            <!-- Button to trigger modal -->
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
            Add Product
        </button>
    </div>
    <br />

    <div class="card">
        <div class="card-header text-center font-weight-bold">
          Products
        </div>
        <div class="card-body">
          <div class="row">
              <div class="col-md-12">
                  <table class="table">
                      <tr>
                          <th width="25%">Product Name</th>
                          <th width="25%">Categories</th>
                          <th width="15%">Quantity</th>
                          <th width="20%">Price</th>
                          <th width="15%">Action</th>
                      </tr>
                      @foreach ($products as $product)
                      <tr class="data-container">
                            <td class="product_name"> {{ $product['product']->product_name }}</td>
                            <td class="categories">
                                @foreach($product['categories'] as $category)
                                    <span> {{ $category->category_name }} </span>
                                    <input class="category_ids" type="hidden" value="{{ $category->id }}">
                                    <br>
                                @endforeach
                            </td>
                            <td class="quantity"> {{ $product['product']->quantity }}</td>
                            <td class="price"> {{ $product['product']->price }}</td>
                            <td>
                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="button" class="update-product btn btn-primary" data-toggle="modal" data-target="#updateFormModal">
                                            Update
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <form method="POST" action="{{ route('delete_products') }}">
                                            <input type="hidden" class="record_id" value="{{ $product['product']->id }}" name="id">
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
                <h4 class="modal-title">Add Product</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
                <!-- Modal body -->
                <form id="create-form" action="{{ route('create_products') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="product_name">Name</label>
                            <input class="form-control" type="text" name="product_name" value="" required>
                        </div>
                        <div class="form-group">
                            <label for="categories">Categories</label>
                            <select multiple class="form form-control selectpicker" id="categories" name="categories[]" data-live-search="true">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"> {{ $category->category_name }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input class="form-control" type="number" name="quantity" value="" required>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input class="form-control" type="number" name="price" value="" required>
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
                <h4 class="modal-title">Update Product</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
                <!-- Modal body -->
                <form id="update-form" action="{{ route('update_products') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <input id="record_id" type="hidden" name="id">
                        <div class="form-group">
                            <label for="product_name">Product Name</label>
                            <input class="form-control" type="text" id="product_name" name="product_name" value="" required>
                        </div>
                        <div class="form-group">
                            <label for="categories">Categories</label>
                            <select multiple class="form form-control selectpicker" id="categories" name="categories[]" data-live-search="true">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"> {{ $category->category_name }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input class="form-control" id="quantity" type="number" name="quantity" value="" required>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input class="form-control" id="price" type="number" name="price" value="" required>
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
    $('.update-product').on('click', function () {

        var recordId = $(this).parent().parent().parent().parent().find('.record_id').val();
        var productName = $(this).parent().parent().parent().parent().find('.product_name').html();
        var quantity = $(this).parent().parent().parent().parent().find('.quantity').html();
        var price = $(this).parent().parent().parent().parent().find('.price').html();

        var categoriesElements = $(this).parent().parent().parent().parent().find('.category_ids');
        var categoriesIds = [];

        categoriesElements.each(function(index, elem) {
                categoriesIds.push($(elem).val())
        });

        $('#update-form').find('#record_id').val(recordId);
        $('#update-form').find('#product_name').val(productName);
        $('#update-form').find('#quantity').val(parseFloat(quantity));
        $('#update-form').find('#price').val(parseFloat(price));
        $('#update-form').find('#categories').val(categoriesIds);
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