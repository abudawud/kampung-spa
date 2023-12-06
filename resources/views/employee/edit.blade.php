<form class="form-crud" action="{{ route('employee.update', $record) }}" method="post">
    {!! Form::hidden('_method', 'PATCH') !!}
    @include('employee.form')
</form>

