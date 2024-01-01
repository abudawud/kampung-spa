{!! Form::token() !!}
<div class="row">
    <div class="col-md-6 form-group">
        {!! Form::label("site_id", "Site") !!}
        {!! Form::select("site_id", $sites, $record?->site_id, ["class" => "form-control select2"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("name", "Name") !!}
        {!! Form::text("name", $record?->name, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("email", "Email") !!}
        {!! Form::text("email", $record?->email, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("position_id", "Position") !!}
        {!! Form::select("position_id", $positions, $record?->position_id, ["class" => "form-control select2"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("sex_id", "Sex") !!}
        {!! Form::select("sex_id", $sexs, $record?->sex_id, ["class" => "form-control select2"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("dob", "Dob") !!}
        {!! Form::text("dob", $record?->dob, ["class" => "form-control datepicker"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("no_hp", "No Hp") !!}
        {!! Form::text("no_hp", $record?->no_hp, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("height", "Height") !!}
        {!! Form::text("height", $record?->height, ["class" => "form-control money"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("weight", "Weight") !!}
        {!! Form::text("weight", $record?->weight, ["class" => "form-control money"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("hire_at", "Hire At") !!}
        {!! Form::text("hire_at", $record?->hire_at, ["class" => "form-control datepicker"]) !!}
    </div>
    <div class="col-md-12 form-group">
        {!! Form::label("address", "Address") !!}
        {!! Form::textarea("address", $record?->address, ["class" => "form-control", "rows" => 5]) !!}
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
        $('select.select2').select2();
        $('input.money').inputmask({
            alias: 'numeric',
            groupSeparator: ',',
            placeholder: '0',
            removeMaskOnSubmit: true,
        });
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
