{!! Form::token() !!}
<div class="row">
    <div class="col-md-6 form-group">
        {!! Form::label("customer_id", "Customer Id") !!}
        {!! Form::text("customer_id", $record?->customer_id, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("price", "Price") !!}
        {!! Form::text("price", $record?->price, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("description", "Description") !!}
        {!! Form::text("description", $record?->description, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("created_at", "Created At") !!}
        {!! Form::text("created_at", $record?->created_at, ["class" => "form-control"]) !!}
    </div>
</div>

<script>
    jQuery(function($) {

    });
</script>
