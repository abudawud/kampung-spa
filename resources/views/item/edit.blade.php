<form class="form-crud" action="{{ route('item.update', $record) }}" method="post">
    {!! Form::hidden('_method', 'PATCH') !!}
    @include('item.form')
</form>

