<div id="payment_index" class="payment-index">
    <h2>Payments Index</h2>

    <div class="top">
        <div class="form-group search">
            <label for="payment_index_search" class="form-label">Search payment</label>
            <input type="text" id="payment_index_search" class="form-control" placeholder="search by name, email, phone" autocomplete="OFF" onkeyup="searchPayment()">
        </div>

        <div class="form-group select">
            <label for="payment_index_from" class="form-label">Select from date</label>
            <input type="date" id="payment_index_from" class="form-control" placeholder="enter from date" autocomplete="OFF" onchange="searchPayment()">
        </div>

        <div class="form-group select">
            <label for="payment_index_to" class="form-label">Select to date</label>
            <input type="date" id="payment_index_to" class="form-control" placeholder="enter to date" autocomplete="OFF" onchange="searchPayment()">
        </div>

        <div class="form-group select">
            <label for="payment_index_status" class="form-label">Select a payment status</label>
            <select id="payment_index_status" class="form-select" onchange="searchPayment()">
                <option value="all">All</option>
                <option value="pending">Pending</option>
                <option value="active" selected>Active</option>
                <option value="inactive">Inactive</option>
                <option value="deleted">Deleted</option>
            </select>
        </div>

        <div class="form-group select">
            <label for="payment_index_limit" class="form-label">Select a limit</label>
            <select id="payment_index_limit" class="form-select" onchange="searchPayment()">
                <option value="5">5</option>
                <option value="10" selected>10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="500">500</option>
            </select>
        </div>

        <a href="{{ route('payments.create') }}" id="payment_index_create" class="btn btn-success">Create</a>
    </div>

    <div id="payment_index_table_container" class="table-container">
        <table class="table table-dark table-striped table-hover table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Date</th>
                    <th>Member</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payments as $payment)
                <tr class="clickable" data-href="{{ route('payments.show',$payment->id) }}">
                    <td class="center">{{ $loop->iteration }}</td>
                    <td class="center">{{ date('d/m/Y',strtotime($payment->created_at)) }}</td>
                    <td class="center">{{ $payment->memberMonth->member->name }}</td>
                    <td class="center">{{ number_format($payment->amount) }}</td>
                    <td class="center">{{ ucwords($payment->status) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $payments->links() }}
    </div>
</div>
