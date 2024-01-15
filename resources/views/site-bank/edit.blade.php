<form class="form-crud" action="{{ route('site-bank.update', $record) }}" method="post">
    {!! Form::hidden('_method', 'PATCH') !!}
    @include('site-bank.form')
</form>

