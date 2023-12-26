@extends('adminlte::page')

@section('plugins.Datatables', true)
@section('title', 'Detail Order #' . $record->code)
@section('content_header')
<h1 class="m-0 text-dark">Detail Order #{{ $record->code }}</h1>
@stop

@push('css')
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <h5 class="card-header bg-primary"><span class="fas fa-file-alt"></span> Data Order</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-stripped">
                                <tbody>
                                    <tr>
                                        <th width="250px">No Order</th>
                                        <td>{{ $record->code }}</td>
                                    </tr>
                                    <tr>
                                        <th>Customer</th>
                                        <td>{{ $record->customer->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Pesan</th>
                                        <td>{{ $record->order_date }}</td>
                                    </tr>
                                    <tr>
                                        <th>Waktu Pesan</th>
                                        <td>{{ $record->start_time }} - {{ $record->end_time }}</td>
                                    </tr>
                                    <tr>
                                        <th>Atas Nama</th>
                                        <td>{{ $record->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Terapis</th>
                                        <td>{{ $record->terapis->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Harga</th>
                                        <td>{{ $record->price }}</td>
                                    </tr>
                                    <tr>
                                        <th>Transport</th>
                                        <td>{{ $record->transport }}</td>
                                    </tr>
                                    <tr>
                                        <th>Total Tagihan</th>
                                        <td>{{ $record->invoice_total }}</td>
                                    </tr>
                                    <tr>
                                        <th>Total Pembayaran</th>
                                        <td>{{ $record->payment_total }}</td>
                                    </tr>
                                    <tr>
                                        <th>Catatan Order</th>
                                        <td>{!! nl2br($record->description) !!}</td>
                                    </tr>
                                    <tr>
                                        <th>Admin</th>
                                        <td>{{ $record->createdBy?->employee->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Terakhir dirubah</th>
                                        <td>{{ $record->updated_at }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        @include("order.details.package")
                    </div>
                    <div class="col-xl-6">
                        @include("order.details.item")
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href='{{ route('order.index') }}' class='btn btn-secondary'>Batal</a>
            </div>
        </div>
    </div>
</div>
<x-alcrud-modal title="Master Cabang" tableId="#datatable" />
@stop
