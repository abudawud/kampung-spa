<form class="form-crud" action="{{ route('package.update-harga', $record) }}" method="post">
    {!! Form::token() !!}
    <div class="row">
        <div class="col-md-6 form-group">
            {!! Form::label('normal_price', 'Normal Price') !!}
            {!! Form::text('normal_price', $record?->normal_price ?? 0, ['class' => 'form-control money']) !!}
        </div>
        <div class="col-md-6 form-group">
            {!! Form::label('member_price', 'Member Price') !!}
            {!! Form::text('member_price', $record?->member_price ?? 0, ['class' => 'form-control money']) !!}
        </div>
    </div>
</form>

<script>
    jQuery(function($) {
        $('input.money').inputmask({
            alias: 'numeric',
            groupSeparator: ',',
            placeholder: '0',
            removeMaskOnSubmit: true,
        });
    })
</script>
