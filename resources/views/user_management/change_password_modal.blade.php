<!-- Create Modal -->
<div class="modal" id="changePasswordModal">
    <div class="modal-dialog">
        <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">Change your password</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
            <!-- Modal body -->
            <form id="change-password-form" action="{{ route('change_password') }}" method="POST">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input class="form-control" type="password" name="password" value="" required>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger" id="change-password-submit-btn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>