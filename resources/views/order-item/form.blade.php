{!! Form::token() !!}
<div class="row">
    <input type="hidden" value="{{ $order->customer_id }}" id="order-item-customer-id">
    <div class="col-md-10 form-group">
        {!! Form::label('item_id', 'Item') !!}
        {!! Form::select('item_id', [$record?->item_id => $record?->item->fullName($record?->order->customer)], $record?->item_id, ['class' => 'form-control']) !!}
    </div>
    <div class="col-md-2 form-group">
        {!! Form::label('qty', 'Qty') !!}
        {!! Form::text('qty', $record?->qty, ['class' => 'form-control text-right']) !!}
    </div>
</div>

<script>
    jQuery(function($) {
        $('#item_id').select2({
            width: "100%",
            ajax: {
                url: "{{ route('item.json') }}",
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
                                text: `${item.name} | ${item.duration}" | Rp ${item.normal_price}`,
                                name: item.name,
                            };
                        })
                    };
                },
            },
        });
    });
</script>
