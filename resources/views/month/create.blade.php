<div id="month_create" class="month-create">
    <h2>Month Create</h2>
    <form action="{{ route('months.store') }}" method="POST" id="month_create_form">
        @csrf

        <label for="month_create_year" class="form-label">Select a year</label>
        <select id="month_create_year" class="form-select" onchange="monthNameCreator()">
            @for ($x = date('Y')+10; $x >= 1970; $x--)
            <option value="{{ $x }}" {{ (date('Y') == $x) ? 'selected' : '' }}>{{ $x }}</option>
            @endfor
        </select>
        <span id="month_create_year_error" class="month-create-error"></span>

        <label for="month_create_month" class="form-label">Select a month</label>
        <select id="month_create_month" class="form-select" onchange="monthNameCreator()">
            <option value="">Select a month</option>
            <option value="01">January</option>
            <option value="02">February</option>
            <option value="03">March</option>
            <option value="04">April</option>
            <option value="05">May</option>
            <option value="06">June</option>
            <option value="07">July</option>
            <option value="08">August</option>
            <option value="09">September</option>
            <option value="10">October</option>
            <option value="11">November</option>
            <option value="12">December</option>
        </select>
        <span id="month_create_month_error" class="month-create-error"></span>

        <label for="month_create_status" class="form-label">Select a status</label>
        <select id="month_create_status" class="form-select">
            <option value="">Select a status</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
            <option value="pending">Pending</option>
            <option value="deleted">Deleted</option>
        </select>
        <span id="month_create_status_error" class="month-create-error"></span>

        <label for="" id="month_create_name_viewer" class="form-label">Month Name: </label>
        <span id="month_create_name_error" class="month-create-error"></span>

        <div class="btn-container">
            <button type="submit" class="btn btn-primary">Add</button>
            <a href="{{ route('months.index') }}" id="month_create_back" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>
