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
