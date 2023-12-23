<table>
    <thead>
        <tr>
            <th class="text-primary">Customer Id</th>
                          <th class="text-primary">Price</th>
                          <th class="text-primary">Description</th>
                          <th class="text-primary">Created At</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($records as $record)
            <tr>
                <td>{{ $record['customer_id'] }}</td>
          <td>{{ $record['price'] }}</td>
          <td>{{ $record['description'] }}</td>
          <td>{{ $record['created_at'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
