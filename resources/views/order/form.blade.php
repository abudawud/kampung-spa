{!! Form::token() !!}
<div class="row">
    <div class="col-md-12 form-group">
        {!! Form::label("site_id", "Site") !!}
        {!! Form::select("site_id", $sites, $record?->site_id, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label('customer_id', 'Customer') !!}
        {!! Form::select('customer_id', [], $record?->customer_id, ['class' => 'form-control']) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label('order_date', 'Order Date') !!}
        {!! Form::text('order_date', $record?->order_date, ['class' => 'form-control datepicker']) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label('terapis_id', 'Terapis') !!}
        {!! Form::select('terapis_id', [], $record?->terapis_id, ['class' => 'form-control']) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label('name', 'Order Name') !!}
        {!! Form::text('name', $record?->name, ['class' => 'form-control']) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("transport", "Transport") !!}
        {!! Form::text("transport", $record?->transport, ["class" => "form-control money"]) !!}
    </div>
    <div class="col-md-3 form-group">
        {!! Form::label("start_time", "Start Time") !!}
        {!! Form::text("start_time", $record?->start_time, ["class" => "form-control timepicker"]) !!}
    </div>
    <div class="col-md-3 form-group">
        {!! Form::label("end_time", "End Time") !!}
        {!! Form::text("end_time", $record?->end_time, ["class" => "form-control timepicker"]) !!}
    </div>
    <div class="col-md-12 form-group">
        {!! Form::label('description', 'Note') !!}
        {!! Form::textarea('description', $record?->description, ['class' => 'form-control', 'rows' => 5]) !!}
    </div>
</div>

<script>
    jQuery(function($) {
        $('#site_id').select2();
        $("input.timepicker").timepicker({
            'timeFormat': 'H:i',
            'minTime': '06:00',
            'maxTime': '23:00',
        })
        $('input.money').inputmask({
            alias: 'numeric',
            groupSeparator: ',',
            placeholder: '0',
            removeMaskOnSubmit: true,
        });
        $('#customer_id').select2({
            width: "100%",
            ajax: {
                url: "{{ route('customer.json') }}",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        start: 0,
                        length: 10,
                        "columns[0][data]": "name",
                        "columns[1][data]": "code",
                        "columns[2][data]": "site_id",
                        "columns[2][search][value]": $('#site_id').val(),
                        "order[0][column]": 0,
                        "order[0][dir]": "asc",
                        "search[value]": params.term,
                    };
                },
                processResults: function(data) {
                    return {
                        results: data.data.map(function(item) {
                            return {
                                id: item.id,
                                text: `${item.code} ${item.name}`,
                                name: item.name,
                            };
                        })
                    };
                },
            },
        }).on('change', function() {
            const data = $(this).select2('data')[0];
            $('#name').val(`An. ${data.name}`);
        });

        $('#terapis_id').select2({
            width: "100%",
            ajax: {
                url: "{{ route('employee.json') }}",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        start: 0,
                        length: 10,
                        "columns[0][data]": "name",
                        "columns[1][data]": "nip",
                        "columns[2][data]": "site_id",
                        "columns[2][search][value]": $('#site_id').val(),
                        "order[0][column]": 0,
                        "order[0][dir]": "asc",
                        "search[value]": params.term,
                    };
                },
                processResults: function(data) {
                    return {
                        results: data.data.map(function(item) {
                            return {
                                id: item.id,
                                text: `${item.nip} ${item.name}`,
                                name: item.name,
                            };
                        })
                    };
                },
            },
        })

        $('.datepicker').daterangepicker({
            showDropdowns: true,
            singleDatePicker: true,
            autoApply: true,
            locale: {
                format: 'YYYY-MM-DD',
            }
        });

        $('button[type=submit]').on('click', function() {
            $(this).attr('disabled', true);
            $('form.form-crud').submit();
        })
    })
</script>
