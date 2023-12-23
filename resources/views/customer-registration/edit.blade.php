<form class="form-crud" action="{{ route('customer-registration.update', $record) }}" method="post">
    {!! Form::hidden('_method', 'PATCH') !!}
    @include('customer-registration.form')
</form>

