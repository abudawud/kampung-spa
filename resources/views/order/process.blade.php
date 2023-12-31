<form class="form-crud" action="{{ route('order.process', $record) }}" method="post">
    {!! Form::token() !!}
    <p>
        Yakin ingin memulai proses order <span class="badge badge-primary">{{ $record->code }}</span> ?
    </p>
</form>
