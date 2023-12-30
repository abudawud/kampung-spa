        <table class="table table-sm table-bordered table-stripped">
            <tbody>
                <tr>
                    <th width="30%">Site</th>
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
                    <th width="30%">Duration</th>
                    <td>{{ $record->duration }}</td>
                </tr>
                <tr>
                    <th width="30%">Normal Price</th>
                    <td>{{ $record->normal_price }}</td>
                </tr>
                <tr>
                    <th width="30%">Member Price</th>
                    <td>{{ $record->member_price }}</td>
                </tr>
                <tr>
                    <th width="30%">Description</th>
                    <td>{{ $record->description }}</td>
                </tr>
                <tr>
                    <th width="30%">Launch At</th>
                    <td>{{ $record->launch_at }}</td>
                </tr>
                <tr>
                    <th width="30%">End At</th>
                    <td>{{ $record->end_at }}</td>
                </tr>
                <tr>
                    <th width="30%">Last Update</th>
                    <td>{{ $record->updated_at }}</td>
                </tr>
                <tr>
                    <th width="30%">Created By</th>
                    <td>{{ $record->createdBy->employee->name }}</td>
                </tr>
            </tbody>
        </table>
