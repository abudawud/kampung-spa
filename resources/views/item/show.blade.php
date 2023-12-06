        <table class="table table-sm table-bordered table-stripped">
            <tbody>
                <tr>
                    <th width="30%">Site Id</th>
                    <td>{{ $record->site_id }}</td>
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
                    <th width="30%">Is Active</th>
                    <td>{{ $record->is_active }}</td>
                </tr>
            </tbody>
        </table>
