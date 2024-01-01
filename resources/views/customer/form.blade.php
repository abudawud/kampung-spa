{!! Form::token() !!}
<div class="row">
    <div class="col-md-12 form-group">
        {!! Form::label("site_id", "Site") !!}
        {!! Form::select("site_id", $sites, $record?->site_id, ["class" => "form-control select2"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("name", "Name") !!}
        {!! Form::text("name", $record?->name, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("instagram", "Instagram") !!}
        {!! Form::text("instagram", $record?->instagram, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("birth_date", "Birth Date") !!}
        {!! Form::text("birth_date", $record?->birth_date, ["class" => "form-control datepicker"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("no_hp", "No Hp") !!}
        {!! Form::text("no_hp", $record?->no_hp, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-12 form-group">
        {!! Form::label("address", "Address") !!}
        {!! Form::textarea("address", $record?->address, ["class" => "form-control", "rows" => 5]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::hidden('is_member', 0) !!}
        <div class="icheck-primary" title="Status">
            {!! Form::checkbox('is_member', 1, $record?->is_member ?? 0, ['id' => 'is_member']) !!}
            {!! Form::label('is_member', 'Status') !!}
        </div>
    </div>
</div>

<script>
    jQuery(function($) {
        $('select.select2').select2();
        $('.datepicker').daterangepicker({
            showDropdowns: true,
            singleDatePicker: true,
            autoApply: true,
            locale: {
                format: 'YYYY-MM-DD',
            }
        });
    });
</script>
