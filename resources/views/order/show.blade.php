@extends('adminlte::page')

@section('title', 'Lihat Order')
@section('content_header')
    <h1 class="m-0 text-dark">Lihat Order</h1>
@stop

@push('css')
@endpush

@section('content')
<div class="card">
    <h5 class="card-header bg-primary"><span class="fas fa-file-alt"></span> Lihat Order</h5>
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
        <table class="table table-sm table-bordered table-stripped">
            <tbody>
                <tr>
                    <th width="30%">Code</th>
                    <td>{{ $record->code }}</td>
                </tr>
                <tr>
                    <th width="30%">Customer Id</th>
                    <td>{{ $record->customer_id }}</td>
                </tr>
                <tr>
                    <th width="30%">Order Date</th>
                    <td>{{ $record->order_date }}</td>
                </tr>
                <tr>
                    <th width="30%">Name</th>
                    <td>{{ $record->name }}</td>
                </tr>
                <tr>
                    <th width="30%">Terapis Id</th>
                    <td>{{ $record->terapis_id }}</td>
                </tr>
                <tr>
                    <th width="30%">Price</th>
                    <td>{{ $record->price }}</td>
                </tr>
                <tr>
                    <th width="30%">Transport</th>
                    <td>{{ $record->transport }}</td>
                </tr>
                <tr>
                    <th width="30%">Invoice Total</th>
                    <td>{{ $record->invoice_total }}</td>
                </tr>
                <tr>
                    <th width="30%">Payment Total</th>
                    <td>{{ $record->payment_total }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="card-footer need-delete">
        <a href='{{ route('order.index') }}' class='btn btn-secondary'>Kembali</a>
        <a href="{{ route('order.edit', $record->id) }}" class="btn bg-warning text-dark mx-1 float-right"><span class="fas fa-pencil-alt"></span> Update</a>
        <a href="#" data-redirect="{{ route('order.index') }}" class="btn btn-danger bg-danger float-right btn-delete"><span class="fas fa-trash"></span> Hapus</a>
    </div>
</div>

<x-modal-crud title="Kelompok Tani" tableId="#datatable" />
@stop
