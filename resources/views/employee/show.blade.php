        <table class="table table-sm table-bordered table-stripped">
            <tbody>
                <tr>
                    <th width="30%">Site</th>
                    <td>{{ $record->site->city_name }}</td>
                </tr>
                <tr>
                    <th width="30%">Position</th>
                    <td>{{ $record->position->name }}</td>
                </tr>
                <tr>
                    <th width="30%">Nip</th>
                    <td>{{ $record->nip }}</td>
                </tr>
                <tr>
                    <th width="30%">Name</th>
                    <td>{{ $record->name }}</td>
                </tr>
                <tr>
                    <th width="30%">Email</th>
                    <td>{{ $record->email }}</td>
                </tr>
                <tr>
                    <th width="30%">Sex</th>
                    <td>{{ $record->sex->name }}</td>
                </tr>
                <tr>
                    <th width="30%">Dob</th>
                    <td>{{ $record->dob }}</td>
                </tr>
                <tr>
                    <th width="30%">No Hp</th>
                    <td>{{ $record->no_hp }}</td>
                </tr>
                <tr>
                    <th width="30%">Height</th>
                    <td>{{ $record->height }}</td>
                </tr>
                <tr>
                    <th width="30%">Weight</th>
                    <td>{{ $record->weight }}</td>
                </tr>
                <tr>
                    <th width="30%">Hire At</th>
                    <td>{{ $record->hire_at }}</td>
                </tr>
                <tr>
                    <th width="30%">Address</th>
                    <td>{{ $record->address }}</td>
                </tr>
                <tr>
                    <th width="30%">Terakhir Dirubah</th>
                    <td>{{ $record->updated_at }}</td>
                </tr>
                <tr>
                    <th width="30%">Active</th>
                    <td>{!! $record->statusIcon !!}</td>
                </tr>
            </tbody>
        </table>
