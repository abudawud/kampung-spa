{!! Form::token() !!}
<div class="row">
    <div class="col-md-6 form-group">
        {!! Form::label('customer_id', 'Customer Id') !!}
        {!! Form::text('customer_id', $record?->customer_id, ['class' => 'form-control']) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label('order_date', 'Order Date') !!}
        {!! Form::text('order_date', $record?->order_date, ['class' => 'form-control']) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label('name', 'Name') !!}
        {!! Form::text('name', $record?->name, ['class' => 'form-control']) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label('terapis_id', 'Terapis Id') !!}
        {!! Form::text('terapis_id', $record?->terapis_id, ['class' => 'form-control']) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label('price', 'Price') !!}
        {!! Form::text('price', $record?->price, ['class' => 'form-control']) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label('transport', 'Transport') !!}
        {!! Form::text('transport', $record?->transport, ['class' => 'form-control']) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label('invoice_total', 'Invoice Total') !!}
        {!! Form::text('invoice_total', $record?->invoice_total, ['class' => 'form-control']) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label('payment_total', 'Payment Total') !!}
        {!! Form::text('payment_total', $record?->payment_total, ['class' => 'form-control']) !!}
    </div>
</div>
@push('js')
    <script>
        $(document).ready(function() {
            $('button[type=submit]').on('click', function() {
                $(this).attr('disabled', true);
                $('form.form-crud').submit();
            })
        })
    </script>
@endpush
