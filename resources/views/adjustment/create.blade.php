<div id="adjustment_create" class="adjustment-create">
    <h2>Adjustment Create</h2>
    <form action="{{ route('adjustments.store') }}" method="POST" id="adjustment_create_form">
        @csrf

        <label for="adjustment_create_floor" class="form-label">Select a floor</label>
        <select id="adjustment_create_floor" class="form-select">
            <option value="all">Select a floor</option>
            <option value="Ground Floor">Ground Floor</option>
            <option value="1st Floor">1st Floor</option>
            <option value="2nd Floor">2nd Floor</option>
        </select>
        <span id="adjustment_create_floor_error" class="adjustment-create-error"></span>

        <label for="adjustment_create_member" class="form-label">Select a member</label>
        <select id="adjustment_create_member" class="form-select">
            <option value="">Select a member</option>
            @foreach ($members as $member)
            <option value="{{ $member->id }}">{{ $member->name.' ['.$member->floor.']' }}</option>
            @endforeach
        </select>
        <span id="adjustment_create_member_id_error" class="adjustment-create-error"></span>

        <label for="adjustment_create_amount" class="form-label">Amount</label>
        <input type="number" name="amount" id="adjustment_create_amount" placeholder="enter adjustment amount" autocomplete="OFF" class="form-control">
        <span class="adjustment-create-error" id="adjustment_create_amount_error"></span>

        <label for="adjustment_create_type" class="form-label">Select a type</label>
        <select id="adjustment_create_type" class="form-select">
            <option value="" selected>Select a type</option>
            <option value="fine">Fine</option>
            <option value="adjustment">Adjustment</option>
        </select>
        <span id="adjustment_create_type_error" class="adjustment-create-error"></span>

        <label for="adjustment_create_status" class="form-label">Select a status</label>
        <select id="adjustment_create_status" class="form-select">
            <option value="">Select a status</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
            <option value="pending">Pending</option>
        </select>
        <span id="adjustment_create_status_error" class="adjustment-create-error"></span>

        <label for="adjustment_create_note" class="form-label">Note</label>
        <textarea name="note" id="adjustment_create_note" placeholder="enter adjustment note" autocomplete="OFF" class="form-control"></textarea>
        <span class="adjustment-create-error" id="adjustment_create_note_error"></span>

        <div class="btn-container">
            <button type="submit" class="btn btn-primary">Add</button>
            <a href="{{ route('adjustments.index') }}" id="adjustment_create_back" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>
