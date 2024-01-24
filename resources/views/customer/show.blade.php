<table class="table table-sm table-bordered table-stripped">
    <tbody>
        <tr>
            <th width="30%">Site Id</th>
            <td>{{ $record->site->city_name }}</td>
        </tr>
        <tr>
            <th width="30%">Code</th>
            <td>{{ $record->code }}</td>
        </tr>
        <tr>
            <th width="30%">Name</th>
            <td>{{ $record->name }}</td>
        </tr>
        <tr>
            <th width="30%">Instagram</th>
            <td>{{ $record->instagram }}</td>
        </tr>
        <tr>
            <th width="30%">Birth Date</th>
            <td>{{ $record->birth_date }}</td>
        </tr>
        <tr>
            <th width="30%">No Hp</th>
            <td>{{ $record->no_hp }}</td>
        </tr>
        <tr>
            <th width="30%">Address</th>
            <td>{{ $record->address }}</td>
        </tr>
        <tr>
            <th width="30%">Is Member</th>
            <td>{!! $record->memberIcon !!}</td>
        </tr>
        @if ($record->is_member)
            <tr>
                <th>Tanggal Member</th>
                <td>{{ $record->member_at }}</td>
            </tr>
            <tr>
                <th>Status Member</th>
                <td>{{ $record->memberStatus?->name }}</td>
            </tr>
            <tr>
                <th>Expired</th>
                <td>{{ $record->member_count_down }}</td>
            </tr>
        @endif
    </tbody>
</table>
