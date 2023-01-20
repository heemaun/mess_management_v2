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
