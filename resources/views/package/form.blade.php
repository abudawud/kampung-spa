{!! Form::token() !!}
<div class="row">
    <div class="col-md-12 form-group">
        {!! Form::label("site_id", "Site") !!}
        {!! Form::select("site_id", $sites, $record?->site_id, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("name", "Name") !!}
        {!! Form::text("name", $record?->name, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("duration", "Duration") !!}
        {!! Form::text("duration", $record?->duration, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("normal_price", "Normal Price") !!}
        {!! Form::text("normal_price", $record?->normal_price, ["class" => "form-control money"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("member_price", "Member Price") !!}
        {!! Form::text("member_price", $record?->member_price, ["class" => "form-control money"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("launch_at", "Launch At") !!}
        {!! Form::text("launch_at", $record?->launch_at, ["class" => "form-control datepicker"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("end_at", "End At") !!}
        {!! Form::text("end_at", $record?->end_at, ["class" => "form-control datepicker"]) !!}
    </div>
    <div class="col-md-12 form-group">
        {!! Form::label("description", "Description") !!}
        {!! Form::textarea("description", $record?->description, ["class" => "form-control", "rows" => "5"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::hidden('is_active', 0) !!}
        <div class="icheck-primary" title="Status">
            {!! Form::checkbox('is_active', 1, $record?->is_active ?? 1, ['id' => 'is_active']) !!}
            {!! Form::label('is_active', 'Status') !!}
        </div>
    </div>
</div>

<script>
    jQuery(function($) {
        $('#site_id').select2();

        $('.datepicker').daterangepicker({
            showDropdowns: true,
            singleDatePicker: true,
            autoApply: true,
            locale: {
                format: 'YYYY-MM-DD',
            }
        });
        $('input.money').inputmask({
            alias: 'numeric',
            groupSeparator: ',',
            placeholder: '0',
            removeMaskOnSubmit: true,
        });
    });
</script>
