<form class="form-crud" action="{{ route('order-package.update', $record) }}" method="post">
    {!! Form::hidden('_method', 'PATCH') !!}
    @include('order-package.form')
</form>

