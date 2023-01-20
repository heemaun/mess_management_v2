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
{{ $adjustments->links() }}
