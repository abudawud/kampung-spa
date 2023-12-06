<form class="form-crud" action="{{ route('package.update', $record) }}" method="post">
    {!! Form::hidden('_method', 'PATCH') !!}
    @include('package.form')
</form>

