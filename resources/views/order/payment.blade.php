<form class="form-crud" action="{{ route('order.payment', $record) }}" method="post">
    {!! Form::token() !!}
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-primary">
                Pelunasan Order No <b>{{ $record->code }}</b> atas nama customer {{ $record->name }}
                dengan total tagihan <b>{{ number_format($record->invoice_total) }}</b>
            </div>
        </div>
        <div class="col-md-12 form-group">
            {!! Form::label('cash', 'Cash') !!}
            {!! Form::text('cash', $record?->cash, ['class' => 'form-control money']) !!}
        </div>
        <div class="col-md-12 form-group">
            {!! Form::label('transfer', 'Transfer') !!}
            {!! Form::text('transfer', $record?->transfer, ['class' => 'form-control money']) !!}
        </div>
        <div style="display: none;" class="col-md-12 form-group site-bank">
            {!! Form::label('site_bank_id', 'Bank') !!}
            {!! Form::select('site_bank_id', $banks, $record?->site_bank_id, ['class' => 'form-control']) !!}
        </div>
        <div class="col-md-12">
            <div class="bg-light p-2 text-bold">
                <div class="float-right" id="payment-total">0</div>
                <div>Total Pembayaran</div>
            </div>
        </div>
    </div>
</form>

<script>
    jQuery(function($) {
        $('#site_bank_id').select2({
            width: '100%',
            placeholder: 'Pilih bank'
        });
        $('#site_bank_id').val('').trigger('change');

        $('#payment-total').inputmask({
            alias: 'numeric',
            groupSeparator: ',',
            placeholder: '0',
        })

        $('input.money').inputmask({
            alias: 'numeric',
            groupSeparator: ',',
            placeholder: '0',
            removeMaskOnSubmit: true,
        });

        function xUpdatePayment() {
            const cash = parseInt($('#cash').inputmask('unmaskedvalue'));
            const transfer = parseInt($('#transfer').inputmask('unmaskedvalue'));
            $('#payment-total').text((cash + transfer).toLocaleString());
        }


        $('#transfer').on('keyup', function() {
            const nilai = $(this).inputmask('unmaskedvalue');
            if (nilai > 0) {
                $('div.site-bank').slideDown();
            } else {
                $('#site_bank_id').val('').trigger('change');
                $('div.site-bank').slideUp();
            }
            xUpdatePayment();
        })
        $('#cash').on('keyup', function() {
            xUpdatePayment();
        })


    })
</script>
