{!! Form::token() !!}
<div class="row">
    <div class="col-md-12 form-group">
        {!! Form::label("bank_type_id", "Jenis Bank") !!}
        {!! Form::select("bank_type_id", $bankTypes, $record?->bank_type_id, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("bank_no", "No Rekening") !!}
        {!! Form::text("bank_no", $record?->bank_no, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("name", "Atas Nama") !!}
        {!! Form::text("name", $record?->name, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-6 form-group">
        <x-alcrud-i-check title="Aktif" name="is_active"/>
    </div>
</div>

<script>
    jQuery(function($) {
        $('#bank_type_id').select2();
    });
</script>
