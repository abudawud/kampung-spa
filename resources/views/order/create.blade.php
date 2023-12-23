@extends('adminlte::page')

@section('title', 'Tambah Order')
@section('content_header')
    <h1 class="m-0 text-dark">Tambah Order</h1>
@stop

@push('css')
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <h5 class="card-header bg-primary"><span class="fas fa-file-alt"></span> Tambah Order</h5>
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
                    <form class="form-crud" action="{{ route('order.store') }}" method="post">
                        @include('order.form')
                    </form>
                </div>
                <div class="card-footer">
                    <a href='{{ route('order.index') }}' class='btn btn-secondary'>Batal</a>
                    <button class='btn btn-primary float-right btn-submit'>Simpan</button>
                </div>
            </div>
        </div>
    </div>
@stop
