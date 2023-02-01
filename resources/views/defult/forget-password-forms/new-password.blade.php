<form action="{{ route('forget-password') }}" method="POST" id="forget_password_form"  data-stage=2>
    @csrf
    <legend>Enter new password</legend>

    <label for="forget_password_new_password" class="form-label">Enter new password</label>
    <input type="password" name="new_password" id="forget_password_new_password" placeholder="enter new password" autocomplete="OFF" class="form-control">
    <span id="forget_password_new_password_error" class="forget-password-error"></span>

    <label for="forget_password_new_password_confirmation" class="form-label">Confirm new password</label>
    <input type="password" name="new_password_confirmation" id="forget_password_new_password_confirmation" placeholder="confirm new password" autocomplete="OFF" class="form-control">
    <span id="forget_password_new_password_confirmation_error" class="forget-password-error"></span>

    <input type="text" id="forget_password_user_email" hidden>

    <div class="btn-container">
        <button type="submit" class="btn btn-primary">Save</button>
        <button type="button" id="forget_password_form_close" class="btn btn-secondary">Close</button>
    </div>
</form>
