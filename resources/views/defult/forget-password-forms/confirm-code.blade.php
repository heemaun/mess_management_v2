<form action="{{ route('forget-password') }}" method="POST" id="forget_password_form" data-stage=1>
    @csrf

    <legend>A 4-digit code has been sent to your email id. Enter the code</legend>

    <label for="forget_password_code" class="form-label">Enter 4-digit code</label>
    <input type="number" name="code" id="forget_password_code" placeholder="enter 4 digit code" class="form-control" autocomplete="OFF">
    <span id="forget_password_code_error" class="forget-password-error"></span>

    <input type="text" id="forget_password_user_email" hidden>

    <div class="btn-container">
        <button type="submit" class="btn btn-primary">Enter</button>
        <button type="button" id="forget_password_form_close" class="btn btn-secondary">Close</button>
    </div>
</form>
