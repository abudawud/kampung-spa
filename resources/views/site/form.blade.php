{!! Form::token() !!}
<div class="row">
    <div class="col-md-6 form-group">
        {!! Form::label("city_code", "City Code") !!}
        {!! Form::text("city_code", $record?->city_code, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("city_name", "City Name") !!}
        {!! Form::text("city_name", $record?->city_name, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("owner_name", "Owner Name") !!}
        {!! Form::text("owner_name", $record?->owner_name, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("no_hp", "No Hp") !!}
        {!! Form::text("no_hp", $record?->no_hp, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-12 form-group">
        {!! Form::label("address", "Address") !!}
        {!! Form::textarea("address", $record?->address, ["class" => "form-control", "rows" => 5]) !!}
    </div>
</div>

<script>
    jQuery(function($) {

    });
</script>
