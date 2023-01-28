<div id="user_show" class="user-show">
    <div class="top">
        <h2>User Details</h2>
        <div class="btn-container">
            <a href="{{ route('users.edit',$user->id) }}" id="user_show_edit" class="btn btn-success">Edit</a>
            <button type="button" id="user_show_delete" class="btn btn-danger">Delete</button>
            <a href="{{ route('users.index') }}" id="user_show_back" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <div class="image-viewer">
        <img src="{{ asset('images/default_member_picture_male.png') }}" alt="">
    </div>

    <div class="info-container">
        <h3>User Information</h3>
        <label for="">Name:<span>{{ $user->name }}</span></label>
        <label for="">Status:<span>{{ ucwords($user->status) }}</span></label>
        <label for="">Email:<span>{{ $user->email }}</span></label>
        <label for="">Phone:<span>{{ $user->phone }}</span></label>
        <label for="">Created At<span>{{ date('d/m/Y h:m:i A',strtotime($user->created_at)) }}</span></label>
        <label for="">Updated At<span>{{ date('d/m/Y h:m:i A',strtotime($user->updated_at)) }}</span></label>
    </div>

    <div id="user_delete_div" class="user-delete-div hide">
        <form action="{{ route('users.destroy',$user) }}" method="POST" id="user_delete_form">
            @csrf
            @method("DELETE")

            <legend>Delete User</legend>

            <label for="user_delete_password" class="form-label">Enter your password</label>
            <input type="password" id="user_delete_password" placeholder="enter your password" class="form-control">
            <span id="user-delete-error" class="user-delete-password-error"></span>

            <input type="checkbox" id="user_delete_permanent" class="form-check-input">
            <label for="user_delete_permanent" class="form-label">Check if delete permanently</label>

            <div class="btn-container">
                <button type="submit" class="btn btn-primary">Confirm</button>
                <button type="button" id="user_delete_close" class="btn btn-secondary">Close</button>
            </div>
        </form>
    </div>
</div>
