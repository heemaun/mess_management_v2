<div id="notice_create" class="notice-create">
    <h2>Notice Create</h2>
    <form action="{{ route('notices.store') }}" method="POST" id="notice_create_form">
        @csrf

        <label for="notice_create_heading" class="form-label">Heading</label>
        <textarea name="heading" id="notice_create_heading" placeholder="enter notice heading" autocomplete="OFF" class="form-control heading"></textarea>
        <span class="notice-create-error" id="notice_create_heading_error"></span>

        <label for="notice_create_body" class="form-label">Body</label>
        <textarea name="body" id="notice_create_body" placeholder="enter notice body" autocomplete="OFF" class="form-control body"></textarea>
        <span class="notice-create-error" id="notice_create_body_error"></span>

        <label for="notice_create_status" class="form-label">Select a status</label>
        <select id="notice_create_status" class="form-select">
            <option value="">Select a status</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
            <option value="pending">Pending</option>
        </select>
        <span id="notice_create_status_error" class="notice-create-error"></span>

        <div class="btn-container">
            <button type="submit" class="btn btn-primary">Add</button>
            <a href="{{ route('notices.index') }}" id="notice_create_back" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>
