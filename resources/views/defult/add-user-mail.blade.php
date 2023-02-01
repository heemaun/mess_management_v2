<div class="add-user-mail">
    <span>Date: {{ date('d/m/Y h:i:s a',strtotime($user->created_at)) }}</span>
    <h1>{{ $user->name.',' }}</h1>
    <p>
        Your user account has been created for <a href="https://www.zamanmess.zamanscorp.com">zamanmess.zamanscorp.com</a>. Use this mail to login as a user. Your password is <b>{{ $password }}</b>.
    </p>
    <span>Curtesy</span>
    <h2>Zaman Mess</h2>
</div>
