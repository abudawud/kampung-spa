@extends('adminlte::page')

@section('title', 'Package Detail')
@section('plugins.Datatables', true)
@section('plugins.Select2', true)

@section('content_header')
<h1 class="m-0 text-dark">Package Detail</h1>
@stop
@push('css')
<style>
    .table>thead>tr>th {
        text-align: left !important;
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-0">
            <h5 class="card-header bg-primary"><span class="fas fa-file-alt"></span> Data Package Detail</h5>
            <div class="card-body p-2">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-stripped">
                                <tbody>
                                    <tr>
                                        <th width="250px">Site</th>
                                        <td>{{ $package->site->city_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Kode Paket</th>
                                        <td>{{ $package->code }}</td>
                                    </tr>
                                    <tr>
                                        <th>Paket</th>
                                        <td>{{ $package->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Duration (menit)</th>
                                        <td>{{ $package->duration }}</td>
                                    </tr>
                                    <tr>
                                        <th>Normal Price</th>
                                        <td>{{ $package->normal_price }}</td>
                                    </tr>
                                    <tr>
                                        <th>Member Price</th>
                                        <td>{{ $package->member_price }}</td>
                                    </tr>
                                    <tr>
                                        <th>Launch At</th>
                                        <td>{{ $package->launch_at }}</td>
                                    </tr>
                                    <tr>
                                        <th>End At</th>
                                        <td>{{ $package->end_at }}</td>
                                    </tr>
                                    <tr>
                                        <th>Description</th>
                                        <td>{{ $package->description }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header bg-light py-2 pr-2">
                                <div class="float-right">
                                    <div class="btn-group">
                                        @can(App\Policies\PackageItemPolicy::POLICY_NAME . '.create')
                                        <a id="btn-create" href="{{ route('package.package-item.create', $package) }}" class="btn btn-primary modal-remote"> <span class="fas fa-plus"></span></a>
                                        @endcan

                                        <a id="btn-reset" class="btn btn-default"> <span class="fas fa-sync"></span></a>
                                    </div>
                                </div>
                                <h5 class="mt-2"><span class="fas fa-file-alt"></span> List Item</h5>
                            </div>
                            <div class="card-body p-2">
                                <div class="table-responsive">
                                    <table width="100%" id="datatable" class="table table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th class="text-primary">Item</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                            <tr class="filter">
                                                <th></th>
                                                <th class="filter">Item</th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href='{{ route('package.index') }}' class='btn btn-secondary'>Kembali</a>
            </div>
        </div>
    </div>
</div>

<x-alcrud-modal title="Package Detail" tableId="#datatable" />
@stop

@section('js')
<script>
    $(document).ready(function() {
        // add search and exclude first and last column
        $('#datatable tfoot tr.filter th.filter').each(function() {
            var title = $(this).text();
            $(this).html('<input class="form-control" type="text" placeholder="Search ' + title +
                '" />');
        });
        const dom = "<'row'<'col-sm-12 col-md-12'l>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>";
        const api = $('#datatable').DataTable({
            dom: dom,
            processing: true,
            serverSide: true,
            ajax: "{{ route('package.package-item.index', $package) }}",
            pageLength: 25,
            colReorder: true,
            order: [
                [0, 'desc']
            ],
            columns: [{
                "data": "id"
            }, {
                "data": "item.name"
            }, {
                "data": "actions",
                "width": "50px",
            }],
            columnDefs: [{
                    targets: -1,
                    searchable: false,
                    orderable: false,
                    class: "text-center"
                },
                {
                    targets: 0,
                    searchable: false
                },
                {
                    targets: 0,
                    visible: false
                },
                {
                    targets: "_all",
                    defaultContent: '-'
                },
            ]
        });
        api.on('init.dt', function() {
            var r = $('#datatable tfoot tr.filter');
            r.find('th').each(function() {
                $(this).css('padding', 8);
            });
            $('#datatable thead').append(r);

            api.columns()
                .every(function() {
                    var that = this;

                    $('input', this.footer()).on('keyup change clear', function() {
                        if (that.search() !== this.value) {
                            that.search(this.value).draw();
                        }
                    });
                });
        });


    });
</script>
@stop
