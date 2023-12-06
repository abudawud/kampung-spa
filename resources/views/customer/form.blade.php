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
        {!! Form::label("instagram", "Instagram") !!}
        {!! Form::text("instagram", $record?->instagram, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("birth_date", "Birth Date") !!}
        {!! Form::text("birth_date", $record?->birth_date, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("no_hp", "No Hp") !!}
        {!! Form::text("no_hp", $record?->no_hp, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("address", "Address") !!}
        {!! Form::text("address", $record?->address, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("is_member", "Is Member") !!}
        {!! Form::text("is_member", $record?->is_member, ["class" => "form-control"]) !!}
    </div>
</div>

<script>
    jQuery(function($) {

    });
</script>
