<div id="adjustment_edit" class="adjustment-edit">
    <h2>Adjustment Edit</h2>
    <form action="{{ route('adjustments.update',$adjustment->id) }}" method="POST" id="adjustment_edit_form">
        @csrf
        @method("PUT")

        <label for="adjustment_edit_heading">Heading</label>
        <textarea name="heading" id="adjustment_edit_heading" placeholder="enter adjustment heading" autocomplete="OFF" class="form-control heading">{{ $adjustment->heading }}</textarea>
        <span class="adjustment-edit-error" id="adjustment_edit_heading_error"></span>

        <label for="adjustment_edit_body">Body</label>
        <textarea name="body" id="adjustment_edit_body" placeholder="enter adjustment body" autocomplete="OFF" class="form-control body">{{ $adjustment->body }}</textarea>
        <span class="adjustment-edit-error" id="adjustment_edit_body_error"></span>

        <label for="adjustment_edit_status" class="form-label">Select a status</label>
        <select id="adjustment_edit_status" class="form-select">
            <option value="">Select a status</option>
            <option value="active" {{ (strcmp('active',$adjustment->status)==0) ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ (strcmp('inactive',$adjustment->status)==0) ? 'selected' : '' }}>Inactive</option>
            <option value="pending" {{ (strcmp('pending',$adjustment->status)==0) ? 'selected' : '' }}>Pending</option>
            @if (strcmp('deleted',$adjustment->status)==0)
            <option value="deleted" {{ (strcmp('deleted',$adjustment->status)==0) ? 'selected' : '' }}>Deleted</option>
            @endif
        </select>
        <span id="adjustment_edit_status_error" class="adjustment-edit-error"></span>

        <div class="btn-container">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('adjustments.show',$adjustment->id) }}" id="adjustment_edit_back" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>
