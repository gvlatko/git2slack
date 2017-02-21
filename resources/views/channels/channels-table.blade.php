<table class="table table-responsive table-bordered table-hover">

    <thead>
        <tr>
            <th>Repository</th>
            <th>Destionation</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>

    @if(count($channels))
        @foreach($channels as $channel)
        <tr>
            <td>{{ $channel->repository() }}</td>
            <td>{{ $channel->destination() }}</td>
            <td>
                <form method="POST" action="{{ route('channels.delete', $channel->id) }}">
                    {{  method_field('DELETE')}}
                    {{ csrf_field() }}
                    <button class="btn btn-sm btn-danger" type="submit">Remove</button>
                </form>
            </td>
        </tr>
        @endforeach
    @else
        <tr>
            <td colspan="3">No channels added yet.</td>
        </tr>
    @endif
    </tbody>


</table>

