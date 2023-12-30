<table class="table table-sm table-bordered table-stripped">
    <tbody>
        <tr>
            <th width="30%">Package</th>
            <td>{{ $record->package->name }}</td>
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
<div class="bg-secondary p-1 text-bold rounded-top">
    Daftar Item
</div>
<table class="table table-sm table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($record->package->items as $index => $item)
        <tr>
            <td width="20px">{{ $index + 1 }}</td>
            <td>{{ $item->item->name }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
