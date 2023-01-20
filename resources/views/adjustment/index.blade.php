<div id="adjustment_index" class="adjustment-index">
    <h2>Adjustments Index</h2>

    <div class="top">
        <div class="rows">
            <div class="form-group search">
                <label for="adjustment_index_search" class="form-label">Search adjustment</label>
                <input type="text" id="adjustment_index_search" class="form-control" placeholder="search by member name, email, phone" autocomplete="OFF" onkeyup="searchAdjustment()">
            </div>
            <a href="{{ route('adjustments.create') }}" id="adjustment_index_create" class="btn btn-success">Create</a>
        </div>
        <div class="rows">
            <div class="form-group select">
                <label for="adjustment_index_from" class="form-label">Select from date</label>
                <input type="date" id="adjustment_index_from" class="form-control" placeholder="enter from date" autocomplete="OFF" onchange="searchAdjustment()">
            </div>

            <div class="form-group select">
                <label for="adjustment_index_to" class="form-label">Select to date</label>
                <input type="date" id="adjustment_index_to" class="form-control" placeholder="enter to date" autocomplete="OFF" onchange="searchAdjustment()">
            </div>

            <div class="form-group select">
                <label for="adjustment_index_type" class="form-label">Select a adjustment type</label>
                <select id="adjustment_index_type" class="form-select" onchange="searchAdjustment()">
                    <option value="all" selected>All</option>
                    <option value="fine">Fine</option>
                    <option value="adjustment">Adjustment</option>
                </select>
            </div>

            <div class="form-group select">
                <label for="adjustment_index_status" class="form-label">Select a adjustment status</label>
                <select id="adjustment_index_status" class="form-select" onchange="searchAdjustment()">
                    <option value="all">All</option>
                    <option value="pending">Pending</option>
                    <option value="active" selected>Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="deleted">Deleted</option>
                </select>
            </div>

            <div class="form-group select">
                <label for="adjustment_index_floor" class="form-label">Select a member floor</label>
                <select id="adjustment_index_floor" class="form-select" onchange="searchAdjustment()">
                    <option value="all" selected>All</option>
                    <option value="Ground Floor">Ground Floor</option>
                    <option value="1st Floor">1st Floor</option>
                    <option value="2nd Floor">2nd Floor</option>
                </select>
            </div>

            <div class="form-group select">
                <label for="adjustment_index_limit" class="form-label">Select row count</label>
                <select id="adjustment_index_limit" class="form-select" onchange="searchAdjustment()">
                    <option value="all" selected>All</option>
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="500">500</option>
                </select>
            </div>
        </div>
    </div>

    <div id="adjustment_index_table_container" class="table-container">
        <table class="table table-dark table-striped table-hover table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Date</th>
                    <th>Member</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($adjustments as $adjustment)
                <tr class="clickable" data-href="{{ route('adjustments.show',$adjustment->id) }}">
                    <td class="center">{{ $loop->iteration }}</td>
                    <td class="center">{{ date('d/m/Y',strtotime($adjustment->created_at)) }}</td>
                    <td class="center">{{ $adjustment->memberMonth->member->name }}</td>
                    <td class="center">{{ ucwords($adjustment->type) }}</td>
                    <td class="center">{{ number_format($adjustment->amount) }}</td>
                    <td class="center">{{ ucwords($adjustment->status) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
