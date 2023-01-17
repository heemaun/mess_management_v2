<div id="member_edit" class="member-edit">
    <h2>Member Edit</h2>
    <form action="{{ route('members.update',$member->id) }}" method="POST" id="member_edit_form">
        @csrf
        @method("PUT")

        <label for="member_edit_name">Name</label>
        <input type="text" name="name" id="member_edit_name" placeholder="enter member name" autocomplete="OFF" class="form-control" value="{{ $member->name }}">
        <span class="member-edit-error" id="member_edit_name_error"></span>

        <label for="member_edit_phone">Phone</label>
        <input type="number" name="phone" id="member_edit_phone" placeholder="enter member phone" autocomplete="OFF" class="form-control" value="{{ $member->phone }}">
        <span class="member-edit-error" id="member_edit_phone_error"></span>

        <label for="member_edit_email">Email</label>
        <input type="text" email="email" id="member_edit_email" placeholder="enter member email" autocomplete="OFF" class="form-control" value="{{ $member->email }}">
        <span class="member-edit-error" id="member_edit_email_error"></span>

        <label for="member_edit_initial_balance">Initial Balance</label>
        <input type="number" name="initial_balance" id="member_edit_initial_balance" placeholder="enter member initial balance" autocomplete="OFF" class="form-control" value="{{ $member->initial_balance }}">
        <span class="member-edit-error" id="member_edit_initial_balance_error"></span>

        <label for="member_edit_current_balance">Current Balance</label>
        <input type="number" name="current_balance" id="member_edit_current_balance" placeholder="enter member current balance" autocomplete="OFF" class="form-control" value="{{ $member->current_balance }}">
        <span class="member-edit-error" id="member_edit_current_balance_error"></span>

        <label for="member_edit_joining_date">Joining date</label>
        <input type="date" name="joining_date" id="member_edit_joining_date" placeholder="enter member joining date" autocomplete="OFF" class="form-control" value="{{ $member->joining_date }}">
        <span class="member-edit-error" id="member_edit_joining_date_error"></span>

        @if (strcmp($member->status,'deleted')==0)
        <label for="member_edit_leaving_date">Leaving date</label>
        <input type="date" name="leaving_date" id="member_edit_leaving_date" placeholder="enter member leaving date" autocomplete="OFF" class="form-control" value="{{ $member->leaving_date }}">
        <span class="member-edit-error" id="member_edit_leaving_date_error"></span>
        @endif

        <label for="member_edit_status" class="form-label">Select a status</label>
        <select id="member_edit_status" class="form-select">
            <option value="">Select a status</option>
            <option value="active" {{ (strcmp('active',$member->status)==0) ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ (strcmp('inactive',$member->status)==0) ? 'selected' : '' }}>Inactive</option>
            <option value="pending" {{ (strcmp('pending',$member->status)==0) ? 'selected' : '' }}>Pending</option>
            @if(strcmp('deleted',$member->status)==0)
            <option value="deleted" {{ (strcmp('deleted',$member->status)==0) ? 'selected' : '' }}>Deleted</option>
            @endif
        </select>
        <span id="member_edit_status_error" class="member-edit-error"></span>

        <label for="member_edit_floor" class="form-label">Select a floor</label>
        <select id="member_edit_floor" class="form-select">
            <option value="">Select a floor</option>
            <option value="Ground Floor" {{ (strcmp('Ground Floor',$member->floor)==0)? 'selected' : '' }}>Ground Floor</option>
            <option value="1st Floor" {{ (strcmp('Ground Floor',$member->floor)==0)? 'selected' : '' }}>1st Floor</option>
            <option value="2nd Floor" {{ (strcmp('Ground Floor',$member->floor)==0)? 'selected' : '' }}>2nd Floor</option>
        </select>
        <span id="member_edit_floor_error" class="member-edit-error"></span>

        <div class="btn-container">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('members.show',$member->id) }}" id="member_edit_back" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>
