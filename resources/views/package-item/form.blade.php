{!! Form::token() !!}
<div class="row">
    <input id="site-id" value="{{ $package->site_id }}" type="hidden">

    <div class="col-md-12 form-group">
        {!! Form::label("item_id", "Pilih Treatment") !!}
        {!! Form::select("item_id", [], $record?->item_id, ["class" => "form-control", "multiple" => "multiple", "name" => "items[]"]) !!}
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
                        "columns[1][data]": "site_id",
                        "columns[1][search][value]": $('#site-id').val(),
                        "order[0][column]": 0,
                        "order[0][dir]": "asc",
                    };
                },
                processResults: function(data) {
                    return {
                        results: data.data.map(function(item) {
                            return {
                                id: item.id,
                                text: item.name,
                            };
                        })
                    };
                },
            },
        });
    });
</script>
