<table>
    <thead>
        <tr>
            <th>Site</th>
            <th>Customer</th>
            <th>Order Date</th>
            <th>Name</th>
            <th>Terapis</th>
            <th>Price</th>
            <th>Transport</th>
            <th>Invoice Total</th>
            <th>Payment Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($records as $record)
            <tr>
                <td>{{ $record['customer']['site']['city_name'] }}</td>
                <td>{{ $record['customer']['name'] }}</td>
                <td>{{ $record['order_date'] }}</td>
                <td>{{ $record['name'] }}</td>
                <td>{{ $record['terapis']['name'] }}</td>
                <td>{{ $record['price'] }}</td>
                <td>{{ $record['transport'] }}</td>
                <td>{{ $record['invoice_total'] }}</td>
                <td>{{ $record['payment_total'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
