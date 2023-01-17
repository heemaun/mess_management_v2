<div id="notice_edit" class="notice-edit">
    <h2>Notice Edit</h2>
    <form action="{{ route('notices.update',$notice->id) }}" method="POST" id="notice_edit_form">
        @csrf
        @method("PUT")

        <label for="notice_edit_heading">Heading</label>
        <textarea name="heading" id="notice_edit_heading" placeholder="enter notice heading" autocomplete="OFF" class="form-control heading">{{ $notice->heading }}</textarea>
        <span class="notice-edit-error" id="notice_edit_heading_error"></span>

        <label for="notice_edit_body">Body</label>
        <textarea name="body" id="notice_edit_body" placeholder="enter notice body" autocomplete="OFF" class="form-control body">{{ $notice->body }}</textarea>
        <span class="notice-edit-error" id="notice_edit_body_error"></span>

        <label for="notice_edit_status" class="form-label">Select a status</label>
        <select id="notice_edit_status" class="form-select">
            <option value="">Select a status</option>
            <option value="active" {{ (strcmp('active',$notice->status)==0) ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ (strcmp('inactive',$notice->status)==0) ? 'selected' : '' }}>Inactive</option>
            <option value="pending" {{ (strcmp('pending',$notice->status)==0) ? 'selected' : '' }}>Pending</option>
            @if (strcmp('deleted',$notice->status)==0)
            <option value="deleted" {{ (strcmp('deleted',$notice->status)==0) ? 'selected' : '' }}>Deleted</option>
            @endif
        </select>
        <span id="notice_edit_status_error" class="notice-edit-error"></span>

        <div class="btn-container">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('notices.show',$notice->id) }}" id="notice_edit_back" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>
