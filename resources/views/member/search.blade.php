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
