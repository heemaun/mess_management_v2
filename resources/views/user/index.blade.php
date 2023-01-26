<div id="user_index" class="user-index">
    <h2>Users Index</h2>

    <div class="top top-hide">
        <span id="user_index_filter_trigger" class="filter-show filter-close">Filter<svg xmlns="http://www.w3.org/2000/svg" height="48" width="48"><path d="M24 40 8 24 24 8l2.1 2.1-12.4 12.4H40v3H13.7l12.4 12.4Z"/></svg></span>

        <div class="form-group search">
            <label for="user_index_search" class="form-label">Search user</label>
            <input type="text" id="user_index_search" class="form-control" placeholder="search by name, email, phone" autocomplete="OFF" onkeyup="searchUser()">
        </div>

        <div class="form-group select">
            <label for="user_index_status" class="form-label">Select a user status</label>
            <select id="user_index_status" class="form-select" onchange="searchUser()">
                <option value="all">All</option>
                <option value="pending">Pending</option>
                <option value="active" selected>Active</option>
                <option value="banned">Banned</option>
                <option value="restricted">Restricted</option>
                <option value="deleted">Deleted</option>
            </select>
        </div>

        <div class="form-group select">
            <label for="user_index_limit" class="form-label">Select a limit</label>
            <select id="user_index_limit" class="form-select" onchange="searchUser()">
                <option value="5">5</option>
                <option value="10" selected>10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="500">500</option>
            </select>
        </div>

        <a href="{{ route('users.create') }}" id="user_index_create" class="btn btn-success">Create</a>
    </div>

    <div id="user_index_table_container" class="table-container">
        <table class="table table-dark table-striped table-hover table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr class="clickable" data-href="{{ route('users.show',$user->id) }}">
                    <td class="center">{{ $loop->iteration }}</td>
                    <td class="left">{{ $user->name }}</td>
                    <td class="center">{{ $user->email }}</td>
                    <td class="center">{{ $user->phone }}</td>
                    <td class="center">{{ ucwords($user->status) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $users->links() }}
    </div>
</div>
