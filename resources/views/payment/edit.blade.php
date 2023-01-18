<div id="payment_edit" class="payment-edit">
    <h2>Payment Edit</h2>
    <form action="{{ route('payments.update',$payment->id) }}" method="POST" id="payment_edit_form">
        @csrf
        @method("PUT")

        <label for="payment_edit_heading">Heading</label>
        <textarea name="heading" id="payment_edit_heading" placeholder="enter payment heading" autocomplete="OFF" class="form-control heading">{{ $payment->heading }}</textarea>
        <span class="payment-edit-error" id="payment_edit_heading_error"></span>

        <label for="payment_edit_body">Body</label>
        <textarea name="body" id="payment_edit_body" placeholder="enter payment body" autocomplete="OFF" class="form-control body">{{ $payment->body }}</textarea>
        <span class="payment-edit-error" id="payment_edit_body_error"></span>

        <label for="payment_edit_status" class="form-label">Select a status</label>
        <select id="payment_edit_status" class="form-select">
            <option value="">Select a status</option>
            <option value="active" {{ (strcmp('active',$payment->status)==0) ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ (strcmp('inactive',$payment->status)==0) ? 'selected' : '' }}>Inactive</option>
            <option value="pending" {{ (strcmp('pending',$payment->status)==0) ? 'selected' : '' }}>Pending</option>
            @if (strcmp('deleted',$payment->status)==0)
            <option value="deleted" {{ (strcmp('deleted',$payment->status)==0) ? 'selected' : '' }}>Deleted</option>
            @endif
        </select>
        <span id="payment_edit_status_error" class="payment-edit-error"></span>

        <div class="btn-container">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('payments.show',$payment->id) }}" id="payment_edit_back" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>
