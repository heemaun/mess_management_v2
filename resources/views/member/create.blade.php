<div id="member_create" class="member-create">
    <h2>Member Create</h2>
    <form action="{{ route('members.store') }}" method="POST" id="member_create_form">
        @csrf

        <label for="member_create_name">Name</label>
        <input type="text" name="name" id="member_create_name" placeholder="enter member name" autocomplete="OFF" class="form-control">
        <span class="member-create-error" id="member_create_name_error"></span>

        <label for="member_create_phone">Phone</label>
        <input type="number" name="phone" id="member_create_phone" placeholder="enter member phone" autocomplete="OFF" class="form-control">
        <span class="member-create-error" id="member_create_phone_error"></span>

        <label for="member_create_email">Email</label>
        <input type="text" email="email" id="member_create_email" placeholder="enter member email" autocomplete="OFF" class="form-control">
        <span class="member-create-error" id="member_create_email_error"></span>

        <label for="member_create_initial_balance">Initial Balance</label>
        <input type="number" name="initial_balance" id="member_create_initial_balance" placeholder="enter member initial balance" autocomplete="OFF" class="form-control">
        <span class="member-create-error" id="member_create_initial_balance_error"></span>

        <label for="member_create_status" class="form-label">Select a status</label>
        <select id="member_create_status" class="form-select">
            <option value="">Select a status</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
            <option value="pending">Pending</option>
            <option value="deleted">Deleted</option>
        </select>
        <span id="member_create_status_error" class="member-create-error"></span>

        <label for="member_create_floor" class="form-label">Select a floor</label>
        <select id="member_create_floor" class="form-select">
            <option value="">Select a floor</option>
            <option value="Ground Floor">Ground Floor</option>
            <option value="1st Floor">1st Floor</option>
            <option value="2nd Floor">2nd Floor</option>
        </select>
        <span id="member_create_floor_error" class="member-create-error"></span>

        <div class="btn-container">
            <button type="submit" class="btn btn-primary">Add</button>
            <a href="{{ route('members.index') }}" id="member_create_back" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>
