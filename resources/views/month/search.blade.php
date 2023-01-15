@foreach ($months as $month)
<tr class="clickable" data-href="{{ route('months.show',$month->id) }}">
    <td>{{ $loop->iteration }}</td>
    <td>{{ $month->name.' ['.date('F',strtotime($month->name)).']' }}</td>
    <td>{{ ucwords($month->status) }}</td>
</tr>
@endforeach
