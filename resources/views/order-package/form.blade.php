{!! Form::token() !!}
<div class="row">
    <input type="hidden" value="{{ $order->customer_id }}" id="order-item-customer-id">
    <div class="col-md-10 form-group">
        {!! Form::label('package_id', 'Item') !!}
        {!! Form::select('package_id', [$record?->package_id => $record?->package->fullName($record?->order->customer)], $record?->package_id, ['class' => 'form-control']) !!}
    </div>
    <div class="col-md-2 form-group">
        {!! Form::label('qty', 'Qty') !!}
        {!! Form::text('qty', $record?->qty, ['class' => 'form-control text-right']) !!}
    </div>
</div>

<script>
    jQuery(function($) {
        $('#package_id').select2({
            width: "100%",
            ajax: {
                url: "{{ route('package.json') }}",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        start: 0,
                        length: 10,
                        "columns[0][data]": "name",
                        "columns[0][search][value]": params.term,
                        "order[0][column]": 0,
                        "order[0][dir]": "asc",
                        "customer_id": $('#order-item-customer-id').val(),
                    };
                },
                processResults: function(data) {
                    return {
                        results: data.data.map(function(item) {
                            return {
                                id: item.id,
                                text: `${item.name} | ${item.duration}" | Rp ${item.guest_price}`,
                                name: item.name,
                            };
                        })
                    };
                },
            },
        });
    });
</script>
