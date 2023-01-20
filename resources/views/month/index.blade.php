<div id="month_index" class="month-index">
    <h2>Months Index</h2>

    <div class="top">
        <div class="form-group">
            <label for="month_index_status" class="form-label">Select a month status</label>
            <select id="month_index_status" class="form-select" onchange="searchMonth()">
                <option value="all" selected>All</option>
                <option value="pending">Pending</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="deleted">Deleted</option>
            </select>
        </div>

        <div class="form-group">
            <label for="month_index_year" class="form-label">Select a year</label>
            <select id="month_index_year" class="form-select" onchange="searchMonth()">
                <option value="" selected>All</option>
                @for ($x = date('Y'); $x >= date('Y',strtotime($months->last()->name)); $x--)
                <option value="{{ $x }}">{{ $x }}</option>
                @endfor
            </select>
        </div>

        <div class="form-group">
            <label for="month_index_month" class="form-label">Select a month</label>
            <select id="month_index_month" class="form-select" onchange="searchMonth()">
                <option value="" selected>All</option>
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
        </div>

        <div class="form-group select">
            <label for="month_index_limit" class="form-label">Select a limit</label>
            <select id="month_index_limit" class="form-select" onchange="searchMonth()">
                <option value="5">5</option>
                <option value="10" selected>10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="500">500</option>
            </select>
        </div>

        <a href="{{ route('months.create') }}" id="month_index_create" class="btn btn-success">Create</a>
    </div>

    <div id="month_index_table_container" class="table-container">
        <table class="table table-dark table-striped table-hover table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($months as $month)
                <tr class="clickable" data-href="{{ route('months.show',$month->id) }}">
                    <td class="center">{{ $loop->iteration }}</td>
                    <td class="center">{{ $month->name.' ['.date('F',strtotime($month->name)).']' }}</td>
                    <td class="center">{{ ucwords($month->status) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $months->links() }}
    </div>
</div>
