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
