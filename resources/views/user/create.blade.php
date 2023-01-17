<div id="user_create" class="user-create">
    <h2>User Create</h2>
    <form action="{{ route('users.store') }}" method="POST" id="user_create_form">
        @csrf

        <label for="user_create_name">Name</label>
        <input type="text" name="name" id="user_create_name" placeholder="enter user name" autocomplete="OFF" class="form-control">
        <span class="user-create-error" id="user_create_name_error"></span>

        <label for="user_create_phone">Phone</label>
        <input type="number" name="phone" id="user_create_phone" placeholder="enter user phone" autocomplete="OFF" class="form-control">
        <span class="user-create-error" id="user_create_phone_error"></span>

        <label for="user_create_email">Email</label>
        <input type="text" email="email" id="user_create_email" placeholder="enter user email" autocomplete="OFF" class="form-control">
        <span class="user-create-error" id="user_create_email_error"></span>

        <label for="user_create_status" class="form-label">Select a status</label>
        <select id="user_create_status" class="form-select">
            <option value="">Select a status</option>
            <option value="active">Active</option>
            <option value="pending">Pending</option>
        </select>
        <span id="user_create_status_error" class="user-create-error"></span>

        <div class="btn-container">
            <button type="submit" class="btn btn-primary">Add</button>
            <a href="{{ route('users.index') }}" id="user_create_back" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>
