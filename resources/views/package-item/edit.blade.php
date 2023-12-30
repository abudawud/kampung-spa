<form class="form-crud" action="{{ route('package-item.update', $record) }}" method="post">
    {!! Form::hidden('_method', 'PATCH') !!}
    @include('package-item.form')
</form>

