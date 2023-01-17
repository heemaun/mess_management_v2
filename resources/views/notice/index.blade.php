<div id="notice_index" class="notice-index">
    <h2>Notices Index</h2>

    <div class="top">
        <div class="form-group search">
            <label for="notice_index_search" class="form-label">Search notice</label>
            <input type="text" id="notice_index_search" class="form-control" placeholder="search by name, email, phone" autocomplete="OFF" onkeyup="searchNotice()">
        </div>

        <div class="form-group select">
            <label for="notice_index_from" class="form-label">Select a notice from</label>
            <input type="date" id="notice_index_from" class="form-control" placeholder="enter from date" autocomplete="OFF" onchange="searchNotice()">
        </div>

        <div class="form-group select">
            <label for="notice_index_to" class="form-label">Select a notice to</label>
            <input type="date" id="notice_index_to" class="form-control" placeholder="enter to date" autocomplete="OFF" onchange="searchNotice()">
        </div>

        <div class="form-group select">
            <label for="notice_index_status" class="form-label">Select a notice status</label>
            <select id="notice_index_status" class="form-select" onchange="searchNotice()">
                <option value="all">All</option>
                <option value="pending">Pending</option>
                <option value="active" selected>Active</option>
                <option value="inactive">Inactive</option>
                <option value="deleted">Deleted</option>
            </select>
        </div>

        <a href="{{ route('notices.create') }}" id="notice_index_create" class="btn btn-success">Create</a>
    </div>

    <div id="notice_index_table_container" class="table-container">
        <table class="table table-dark table-striped table-hover table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Status</th>
                    <th>Heading</th>
                    <th>Created By</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($notices as $notice)
                <tr class="clickable" data-href="{{ route('notices.show',$notice->id) }}">
                    <td class="center">{{ $loop->iteration }}</td>
                    <td class="center">{{ ucwords($notice->status) }}</td>
                    <td class="center">{{ Str::limit($notice->heading,50,'...') }}</td>
                    <td class="center">{{ $notice->user->name }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
