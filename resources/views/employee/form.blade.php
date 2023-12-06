{!! Form::token() !!}
<div class="row">
    <div class="col-md-6 form-group">
        {!! Form::label("site_id", "Site Id") !!}
        {!! Form::text("site_id", $record?->site_id, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("position_id", "Position Id") !!}
        {!! Form::text("position_id", $record?->position_id, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("nip", "Nip") !!}
        {!! Form::text("nip", $record?->nip, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("name", "Name") !!}
        {!! Form::text("name", $record?->name, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("sex_id", "Sex Id") !!}
        {!! Form::text("sex_id", $record?->sex_id, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("dob", "Dob") !!}
        {!! Form::text("dob", $record?->dob, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("no_hp", "No Hp") !!}
        {!! Form::text("no_hp", $record?->no_hp, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("height", "Height") !!}
        {!! Form::text("height", $record?->height, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("weight", "Weight") !!}
        {!! Form::text("weight", $record?->weight, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("hire_at", "Hire At") !!}
        {!! Form::text("hire_at", $record?->hire_at, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("address", "Address") !!}
        {!! Form::text("address", $record?->address, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("is_active", "Is Active") !!}
        {!! Form::text("is_active", $record?->is_active, ["class" => "form-control"]) !!}
    </div>
</div>

<script>
    jQuery(function($) {

    });
</script>
