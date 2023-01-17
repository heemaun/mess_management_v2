@foreach ($notices as $notice)
<tr class="clickable" data-href="{{ route('notices.show',$notice->id) }}">
    <td class="center">{{ $loop->iteration }}</td>
    <td class="center">{{ ucwords($notice->status) }}</td>
    <td class="center">{{ Str::limit($notice->heading,50,'...') }}</td>
    <td class="center">{{ $notice->user->name }}</td>
</tr>
@endforeach
