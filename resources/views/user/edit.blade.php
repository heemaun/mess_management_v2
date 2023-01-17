<div id="user_edit" class="user-edit">
    <h2>User Edit</h2>
    <form action="{{ route('users.update',$user->id) }}" method="POST" id="user_edit_form">
        @csrf
        @method("PUT")

        <label for="user_edit_name">Name</label>
        <input type="text" name="name" id="user_edit_name" placeholder="enter user name" autocomplete="OFF" class="form-control" value="{{ $user->name }}">
        <span class="user-edit-error" id="user_edit_name_error"></span>

        <label for="user_edit_phone">Phone</label>
        <input type="number" name="phone" id="user_edit_phone" placeholder="enter user phone" autocomplete="OFF" class="form-control" value="{{ $user->phone }}">
        <span class="user-edit-error" id="user_edit_phone_error"></span>

        <label for="user_edit_email">Email</label>
        <input type="text" email="email" id="user_edit_email" placeholder="enter user email" autocomplete="OFF" class="form-control" value="{{ $user->email }}">
        <span class="user-edit-error" id="user_edit_email_error"></span>

        <label for="user_edit_status" class="form-label">Select a status</label>
        <select id="user_edit_status" class="form-select">
            <option value="">Select a status</option>
            <option value="active" {{ (strcmp('active',$user->status)==0) ? 'selected' : '' }}>Active</option>
            <option value="pending" {{ (strcmp('pending',$user->status)==0) ? 'selected' : '' }}>Pending</option>
            <option value="banned" {{ (strcmp('banned',$user->status)==0) ? 'selected' : '' }}>Banned</option>
            <option value="restricted" {{ (strcmp('restricted',$user->status)==0) ? 'selected' : '' }}>Restricted</option>
            @if(strcmp('deleted',$user->status)==0)
            <option value="deleted" {{ (strcmp('deleted',$user->status)==0) ? 'selected' : '' }}>Deleted</option>
            @endif
        </select>
        <span id="user_edit_status_error" class="user-edit-error"></span>

        <div class="btn-container">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('users.show',$user->id) }}" id="user_edit_back" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>
