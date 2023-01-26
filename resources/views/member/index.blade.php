<div id="member_index" class="member-index">
    <h2>Members Index</h2>

    <div class="top top-hide">
        <span id="member_index_filter_trigger" class="filter-show filter-close">Filter<svg xmlns="http://www.w3.org/2000/svg" height="48" width="48"><path d="M24 40 8 24 24 8l2.1 2.1-12.4 12.4H40v3H13.7l12.4 12.4Z"/></svg></span>

        <div class="form-group search">
            <label for="member_index_search" class="form-label">Search member</label>
            <input type="text" id="member_index_search" class="form-control" placeholder="search by name, email, phone" autocomplete="OFF" onkeyup="searchMember()">
        </div>

        <div class="form-group select">
            <label for="member_index_status" class="form-label">Select a member status</label>
            <select id="member_index_status" class="form-select" onchange="searchMember()">
                <option value="all">All</option>
                <option value="pending">Pending</option>
                <option value="active" selected>Active</option>
                <option value="banned">Banned</option>
                <option value="restricted">Restricted</option>
                <option value="deleted">Deleted</option>
            </select>
        </div>

        <div class="form-group select">
            <label for="member_index_floor" class="form-label">Select a floor</label>
            <select id="member_index_floor" class="form-select" onchange="searchMember()">
                <option value="all" selected>All</option>
                <option value="Ground Floor">Ground Floor</option>
                <option value="1st Floor">1st Floor</option>
                <option value="2nd Floor">2nd Floor</option>
            </select>
        </div>

        <div class="form-group select">
            <label for="member_index_limit" class="form-label">Select a limit</label>
            <select id="member_index_limit" class="form-select" onchange="searchMember()">
                <option value="5">5</option>
                <option value="10" selected>10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="500">500</option>
            </select>
        </div>

        <a href="{{ route('members.create') }}" id="member_index_create" class="btn btn-success">Create</a>
    </div>

    <div id="member_index_table_container" class="table-container">
        <table class="table table-dark table-striped table-hover table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Floor</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Current Balance</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($members as $member)
                <tr class="clickable" data-href="{{ route('members.show',$member->id) }}">
                    <td class="center">{{ $loop->iteration }}</td>
                    <td class="left">{{ $member->name }}</td>
                    <td class="center">{{ $member->floor }}</td>
                    <td class="center">{{ $member->email }}</td>
                    <td class="center">{{ $member->phone }}</td>
                    <td class="center">{{ ucwords($member->status) }}</td>
                    <td class="right">{{ number_format($member->current_balance) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $members->links() }}
    </div>
</div>
