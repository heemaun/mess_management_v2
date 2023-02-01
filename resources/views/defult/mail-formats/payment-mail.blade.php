<div class="payment-mail">
    <span>Date: {{ date('d/m/Y h:i:s a',strtotime($payment->created_at)) }}</span>
    <h4>{{ $payment->memberMonth->member->name.',' }}</h4>
    <p>
        Your payment of <b>{{ $payment->amount.' Tk' }}</b> has been confirmed. Your current balance is <b>{{ $payment->memberMonth->due.' Tk' }}</b>. Please contact <i>{{ $payment->user->name.' ['.$payment->user->phone.']' }}</i> for any query.
    </p>
    <h5>Yours sincerely, <b>{{ $payment->user->name }}</b></h5>
</div>
