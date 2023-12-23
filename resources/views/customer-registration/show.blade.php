        <table class="table table-sm table-bordered table-stripped">
            <tbody>
                <tr>
                    <th width="30%">Customer Id</th>
                    <td>{{ $record->customer_id }}</td>
                </tr>
                <tr>
                    <th width="30%">Price</th>
                    <td>{{ $record->price }}</td>
                </tr>
                <tr>
                    <th width="30%">Description</th>
                    <td>{{ $record->description }}</td>
                </tr>
                <tr>
                    <th width="30%">Created At</th>
                    <td>{{ $record->created_at }}</td>
                </tr>
            </tbody>
        </table>
