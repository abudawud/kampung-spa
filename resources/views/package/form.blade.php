{!! Form::token() !!}
<div class="row">
    <div class="col-md-6 form-group">
        {!! Form::label("site_id", "Site Id") !!}
        {!! Form::text("site_id", $record?->site_id, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("code", "Code") !!}
        {!! Form::text("code", $record?->code, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("name", "Name") !!}
        {!! Form::text("name", $record?->name, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("normal_price", "Normal Price") !!}
        {!! Form::text("normal_price", $record?->normal_price, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("member_price", "Member Price") !!}
        {!! Form::text("member_price", $record?->member_price, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("description", "Description") !!}
        {!! Form::text("description", $record?->description, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("launch_at", "Launch At") !!}
        {!! Form::text("launch_at", $record?->launch_at, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("end_at", "End At") !!}
        {!! Form::text("end_at", $record?->end_at, ["class" => "form-control"]) !!}
    </div>
</div>

<script>
    jQuery(function($) {

    });
</script>
