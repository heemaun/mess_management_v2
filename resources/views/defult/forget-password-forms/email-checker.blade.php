<form action="{{ route('forget-password') }}" method="POST" id="forget_password_form" data-stage=0>
    <legend>Password recovary</legend>
    @csrf

    <label for="forget_password_email" class="form-label">Enter your email</label>
    <input type="email" name="email" id="forget_password_email" placeholder="enter your email to search your account" autocomplete="OFF" class="form-control">
    <span id="forget_password_email_error" class="forget-password-error"></span>

    <div class="btn-container">
        <button type="submit" class="btn btn-primary">Search</button>
        <button type="button" id="forget_password_form_close" class="btn btn-secondary">Close</button>
    </div>
</form>
