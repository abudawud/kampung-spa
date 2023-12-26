        <table class="table table-sm table-bordered table-stripped">
            <tbody>
                <tr>
                    <th width="30%">Order Id</th>
                    <td>{{ $record->order_id }}</td>
                </tr>
                <tr>
                    <th width="30%">Package Id</th>
                    <td>{{ $record->package_id }}</td>
                </tr>
                <tr>
                    <th width="30%">Qty</th>
                    <td>{{ $record->qty }}</td>
                </tr>
                <tr>
                    <th width="30%">Duration</th>
                    <td>{{ $record->duration }}</td>
                </tr>
                <tr>
                    <th width="30%">Price</th>
                    <td>{{ $record->price }}</td>
                </tr>
            </tbody>
        </table>
