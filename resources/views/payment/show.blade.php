<div id="payment_show" class="payment-show">
    <div class="top">
        <h2>Payment Details</h2>
        <div class="btn-container">
            <a href="{{ route('payments.index') }}" id="payment_show_back" class="btn btn-secondary">Back</a>
            <button type="button" id="payment_show_delete" class="btn btn-danger">Delete</button>
        </div>
    </div>

    <div class="details-container">
        <div class="info-container">
            <label for="">Member:<span>{{ $payment->memberMonth->member->name }}</span></label>
            <label for="">Month:<span>{{ $payment->memberMonth->month->name }}</span></label>
            <label for="">Status:<span>{{ ucwords($payment->status) }}</span></label>
            <label for="">Amount:<span>{{ number_format($payment->amount) }}</span></label>
            <label for="">Last modified by:<span>{{ $payment->user->name }}</span></label>
            <label for="">Created at:<span>{{ date('d/m/Y h:i:s a',strtotime($payment->created_at)) }}</span></label>
            <label for="">Updated at:<span>{{ date('d/m/Y h:i:s a',strtotime($payment->updated_at)) }}</span></label>
            @if (!empty($payment->note))
            <label for="" class="note">Note</label>
            <p>{{ $payment->note }}</p>
            @endif
        </div>
    </div>

    <div id="payment_delete_div" class="payment-delete-div hide">
        <form action="{{ route('payments.destroy',$payment) }}" method="POST" id="payment_delete_form">
            @csrf
            @method("DELETE")

            <legend>Delete Payment</legend>

            <label for="payment_delete_password" class="form-label">Enter your password</label>
            <input type="password" id="payment_delete_password" placeholder="enter your password" class="form-control">
            <span id="payment_delete_password_error" class="payment-delete-error"></span>

            <div class="btn-container">
                <button type="submit" class="btn btn-primary">Confirm</button>
                <button type="button" id="payment_delete_close" class="btn btn-secondary">Close</button>
            </div>
        </form>
    </div>
</div>
