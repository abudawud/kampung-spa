<form class="form-crud" action="{{ route('customer.update', $record) }}" method="post">
    {!! Form::hidden('_method', 'PATCH') !!}
    @include('customer.form')
</form>

