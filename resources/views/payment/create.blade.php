<div id="payment_create" class="payment-create">
    <h2>Payment Create</h2>
    <form action="{{ route('payments.store') }}" method="POST" id="payment_create_form">
        @csrf

        <label for="payment_create_floor" class="form-label">Select a floor</label>
        <select id="payment_create_floor" class="form-select">
            <option value="all">Select a floor</option>
            <option value="Ground Floor">Ground Floor</option>
            <option value="1st Floor">1st Floor</option>
            <option value="2nd Floor">2nd Floor</option>
        </select>
        <span id="payment_create_floor_error" class="payment-create-error"></span>

        <label for="payment_create_member" class="form-label">Select a member</label>
        <select id="payment_create_member" class="form-select">
            <option value="">Select a member</option>
            @foreach ($members as $member)
            <option value="{{ $member->id }}">{{ $member->name.' ['.$member->floor.']' }}</option>
            @endforeach
        </select>
        <span id="payment_create_member_id_error" class="payment-create-error"></span>

        <label for="payment_create_amount" class="form-label">Amount</label>
        <input type="number" name="amount" id="payment_create_amount" placeholder="enter payment amount" autocomplete="OFF" class="form-control">
        <span class="payment-create-error" id="payment_create_amount_error"></span>

        <label for="payment_create_status" class="form-label">Select a status</label>
        <select id="payment_create_status" class="form-select">
            <option value="">Select a status</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
            <option value="pending">Pending</option>
        </select>
        <span id="payment_create_status_error" class="payment-create-error"></span>

        <label for="payment_create_note" class="form-label">Note</label>
        <textarea name="note" id="payment_create_note" placeholder="enter payment note" autocomplete="OFF" class="form-control"></textarea>
        <span class="payment-create-error" id="payment_create_note_error"></span>

        <div class="btn-container">
            <button type="submit" class="btn btn-primary">Add</button>
            <a href="{{ route('payments.index') }}" id="payment_create_back" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>
