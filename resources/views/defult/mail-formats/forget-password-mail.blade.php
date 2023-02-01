<div class="forget-password-mail">
    <span>Date: {{ date('d/m/Y h:i:s a') }}</span>
    <h4>{{ $user->name.',' }}</h4>
    <p>
        As a response to your forget password request this mail is being sent to you with your password recovery code. Your 4-digit recovary code is <b>{{ $code }}</b>.
    </p>
    <h5>Zaman Mess</h5>
</div>
