@extends('adminlte::page')

@section('plugins.Datatables', true)
@section('plugins.Select2', true)
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
                                            <td>{{ $record->customer->name }}
                                                <i>({{ $record->customer->is_member ? 'Member' : 'Non-Member' }})</i></td>
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
                                        @if (!$record->is_draft)
                                            <tr>
                                                <td colspan="2" class="bg-secondary">Rincian Biaya</td>
                                            </tr>
                                            <tr>
                                                <th>Harga</th>
                                                <td>{{ $record->price }}</td>
                                            </tr>
                                            <tr>
                                                <th>Transport</th>
                                                <td>{{ $record->transport }}</td>
                                            </tr>
                                            <tr class="bg-light">
                                                <th>Total Tagihan</th>
                                                <td>{{ $record->invoice_total }}</td>
                                            </tr>
                                            <tr>
                                                <th>Cash</th>
                                                <td>{{ $record->cash }}</td>
                                            </tr>
                                            <tr>
                                                <th>Transfer</th>
                                                <td>{{ $record->transfer }}</td>
                                            </tr>
                                            <tr class="bg-light">
                                                <th>Total Pembayaran</th>
                                                <td>{{ $record->payment_total }}</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            @include('order.details.package')
                        </div>
                        <div class="col-xl-6">
                            @include('order.details.item')
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href='{{ route('order.index') }}' class='btn btn-secondary'>Kembali</a>
                    @if ($record->is_draft)
                        <a href='{{ route('order.process', $record) }}' class='btn btn-primary float-right modal-remote'><span class="fas fa-fw fa-play-circle"></span>
                            Proses Pesanan</a>
                    @else
                        <a target="_blank" href='{{ route('order.print-invoice', $record) }}' class='btn btn-info float-right'><span class="fas fa-fw fa-print"></span>
                            Cetak Invoice</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <x-alcrud-modal title="Master Cabang" tableId="#datatable" />
@stop
