<form class="form-crud" action="{{ route('site.update', $record) }}" method="post">
    {!! Form::hidden('_method', 'PATCH') !!}
    @include('site.form')
</form>

