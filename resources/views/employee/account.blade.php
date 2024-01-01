<form class="form-crud" action="{{ route('employee.account', $record) }}" method="post">
{!! Form::token() !!}
<div class="row">
    <div class="col-md-12 form-group">
        {!! Form::label("email", "Username") !!}
        {!! Form::text("email", $record?->email, ["class" => "form-control", "disabled" => "true"]) !!}
    </div>
    <div class="col-md-12 form-group">
        {!! Form::label("password", "Password") !!}
        {!! Form::password("password", ["class" => "form-control"]) !!}
    </div>
</div>
</form>
