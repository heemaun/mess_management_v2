@foreach ($users as $user)
<tr class="clickable" data-href="{{ route('users.show',$user->id) }}">
    <td class="center">{{ $loop->iteration }}</td>
    <td class="left">{{ $user->name }}</td>
    <td class="center">{{ $user->email }}</td>
    <td class="center">{{ $user->phone }}</td>
    <td class="center">{{ ucwords($user->status) }}</td>
</tr>
@endforeach
