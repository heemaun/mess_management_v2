<div id="notice_show" class="notice-show">
    <div class="top">
        <h2>Notice Details</h2>
        <div class="btn-container">
            <a href="{{ route('notices.edit',$notice->id) }}" id="notice_show_edit" class="btn btn-success">Edit</a>
            <a href="{{ route('notices.index') }}" id="notice_show_back" class="btn btn-secondary">Back</a>
            <button type="button" id="notice_show_delete" class="btn btn-danger">Delete</button>
        </div>
    </div>

    <div class="details-container">
        <div class="info-container">
            <h3 id="home_notice_view_header">{{ $notice->heading }}</h3>
            <p id="home_notice_view_body" class="body">{{ $notice->body }}</p>
            <p id="home_notice_view_footer" class="footer">
                <span id="home_notice_view_admin" class="admin">{{ $notice->user->name }}</span>
                <span id="home_notice_view_time" class="date">{{ date('D, M-d, Y',strtotime($notice->created_at)) }}</span>
            </p>
        </div>
    </div>

    <div id="notice_delete_div" class="notice-delete-div hide">
        <form action="{{ route('notices.destroy',$notice) }}" method="POST" id="notice_delete_form">
            @csrf
            @method("DELETE")

            <legend>Delete Notice</legend>

            <label for="notice_delete_password" class="form-label">Enter your password</label>
            <input type="password" id="notice_delete_password" placeholder="enter your password" class="form-control">
            <span id="notice_delete_password_error" class="notice-delete-error"></span>

            <input type="checkbox" id="notice_delete_permanent" class="form-check-input">
            <label for="notice_delete_permanent" class="form-label">Check if delete permanently</label>

            <div class="btn-container">
                <button type="submit" class="btn btn-primary">Confirm</button>
                <button type="button" id="notice_delete_close" class="btn btn-secondary">Close</button>
            </div>
        </form>
    </div>
</div>
