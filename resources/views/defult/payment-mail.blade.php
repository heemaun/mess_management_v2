<div class="payment-mail">
    <span>Date: {{ date('d/m/Y h:i:s a',strtotime($payment->created_at)) }}</span>
    <h1>{{ $payment->memberMonth->member->name.',' }}</h1>
    <p>
        Your payment of <b>{{ $payment->amount.' Tk' }}</b> has been confirmed. Your current balance is <b>{{ $payment->memberMonth->due.' Tk' }}</b>. Please contact <i>{{ $payment->user->name.' ['.$payment->user->phone.']' }}</i> for any query.
    </p>
    <h2>Yours sincerely, <b>{{ $payment->user->name }}</b></h2>
</div>
