<div class="add-user-mail">
    <span>Date: {{ date('d/m/Y h:i:s a',strtotime($user->created_at)) }}</span>
    <h4>{{ $user->name.',' }}</h4>
    <p>
        Your user account has been created for <a href="https://www.zamanmess.zamanscorp.com">zamanmess.zamanscorp.com</a>. Use this mail to login as a user. Your password is <b>{{ $password }}</b>.
    </p>
    <span>Curtesy</span>
    <h5>Zaman Mess</h5>
</div>
