<div id="month_edit" class="month-edit">
    <h2>Month Edit</h2>
    <form action="{{ route('months.update',$month->id) }}" method="POST" id="month_edit_form">
        @csrf
        @method("PUT")

        <label for="month_edit_year" class="form-label">Select a year</label>
        <select id="month_edit_year" class="form-select" onchange="monthEditNameCreator()">
            @for ($x = date('Y')+10; $x >= 1970; $x--)
            <option value="{{ $x }}" {{ (date('Y',strtotime($month->name)) == $x) ? 'selected' : '' }}>{{ $x }}</option>
            @endfor
        </select>
        <span id="month_edit_year_error" class="month-edit-error"></span>

        <label for="month_edit_month" class="form-label">Select a month</label>
        <select id="month_edit_month" class="form-select" onchange="monthEditNameCreator()">
            <option value="">Select a month</option>
            <option value="01" {{ (date('m',strtotime($month->name)) == 1) ? 'selected' : '' }}>January</option>
            <option value="02" {{ (date('m',strtotime($month->name)) == 2) ? 'selected' : '' }}>February</option>
            <option value="03" {{ (date('m',strtotime($month->name)) == 3) ? 'selected' : '' }}>March</option>
            <option value="04" {{ (date('m',strtotime($month->name)) == 4) ? 'selected' : '' }}>April</option>
            <option value="05" {{ (date('m',strtotime($month->name)) == 5) ? 'selected' : '' }}>May</option>
            <option value="06" {{ (date('m',strtotime($month->name)) == 6) ? 'selected' : '' }}>June</option>
            <option value="07" {{ (date('m',strtotime($month->name)) == 7) ? 'selected' : '' }}>July</option>
            <option value="08" {{ (date('m',strtotime($month->name)) == 8) ? 'selected' : '' }}>August</option>
            <option value="09" {{ (date('m',strtotime($month->name)) == 9) ? 'selected' : '' }}>September</option>
            <option value="10" {{ (date('m',strtotime($month->name)) == 10) ? 'selected' : '' }}>October</option>
            <option value="11" {{ (date('m',strtotime($month->name)) == 11) ? 'selected' : '' }}>November</option>
            <option value="12" {{ (date('m',strtotime($month->name)) == 12) ? 'selected' : '' }}>December</option>
        </select>
        <span id="month_edit_month_error" class="month-edit-error"></span>

        <label for="month_edit_status" class="form-label">Select a status</label>
        <select id="month_edit_status" class="form-select">
            <option value="">Select a status</option>
            <option value="active" {{ (strcmp($month->status,'active')==0) ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ (strcmp($month->status,'inactive')==0) ? 'selected' : '' }}>Inactive</option>
            <option value="pending" {{ (strcmp($month->status,'pending')==0) ? 'selected' : '' }}>Pending</option>
            <option value="deleted" {{ (strcmp($month->status,'deleted')==0) ? 'selected' : '' }}>Deleted</option>
        </select>
        <span id="month_edit_status_error" class="month-edit-error"></span>

        <label for="" id="month_edit_name_viewer">Month Name: {{ $month->name }}</label>
        <span id="month_edit_name_error" class="month-edit-error"></span>

        <div class="btn-container">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('months.show',$month->id) }}" id="month_edit_back" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>
