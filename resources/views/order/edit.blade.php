@extends('adminlte::page')

@section('title', 'Update Order')
@section('content_header')
    <h1 class="m-0 text-dark">Update Order</h1>
@stop

@push('css')
@endpush

@section('content')
<div class="card">
    <h5 class="card-header bg-primary"><span class="fas fa-file-alt"></span> Update Order</h5>
    <div class="card-body">
        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Maaf!</strong> Ada data yang belum sesuai.<br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
<form class="form-crud" action="{{ route('order.update', $record) }}" method="post">
    {!! Form::hidden('_method', 'PATCH') !!}
    @include('order.form')
</form>

    </div>
    <div class="card-footer">
        <a href='{{ route('order.show', $record->id) }}' class='btn btn-secondary'>Batal</a>
        <button type='submit' class='btn btn-primary float-right btn-submit'>Simpan</button>
    </div>
</div>
@stop
