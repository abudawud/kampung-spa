{!! Form::token() !!}
<div class="row">
    <div class="col-md-6 form-group">
        {!! Form::label("order_id", "Order Id") !!}
        {!! Form::text("order_id", $record?->order_id, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("item_id", "Item Id") !!}
        {!! Form::text("item_id", $record?->item_id, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("qty", "Qty") !!}
        {!! Form::text("qty", $record?->qty, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("duration", "Duration") !!}
        {!! Form::text("duration", $record?->duration, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("price", "Price") !!}
        {!! Form::text("price", $record?->price, ["class" => "form-control"]) !!}
    </div>
</div>

<script>
    jQuery(function($) {

    });
</script>
