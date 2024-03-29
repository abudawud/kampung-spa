@extends('adminlte::page')

@section('title', 'Master Paket')
@section('plugins.Datatables', true)
@section('plugins.BootstrapICheck', true)
@section('plugins.Select2', true)
@section('plugins.DateRangePicker', true)
@section('plugins.InputMask', true)

@section('content_header')
    <h1 class="m-0 text-dark">Master Paket</h1>
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
                <h5 class="card-header bg-primary"><span class="fas fa-file-alt"></span> Data Master Paket</h5>
                <div class="card-body p-2">
                    <em>*Gunakan filter <b>Search</b> untuk pencarian global / filter perkolom pada bagian bawah</em>
                    <div class="float-right">
                        <div class="btn-group">
                            @can(App\Policies\PackagePolicy::POLICY_NAME . '.create')
                                <a id="btn-create" href="{{ route('package.create') }}" class="btn btn-primary modal-remote">
                                    <span class="fas fa-plus"></span></a>
                            @endcan

                            <a id="btn-reset" class="btn btn-default"> <span class="fas fa-sync"></span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-0">
                <div class="card-body p-2">
                    <div class="table-responsive">
                        <table width="100%" id="datatable" class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th class="text-primary">Site</th>
                                    <th class="text-primary">Code</th>
                                    <th class="text-primary">Name</th>
                                    <th class="text-primary">Duration</th>
                                    <th class="text-primary">Normal Price</th>
                                    <th class="text-primary">Member Price</th>
                                    <th class="text-primary">Description</th>
                                    <th class="text-primary">Launch At</th>
                                    <th class="text-primary">End At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr class="filter">
                                    <th></th>
                                    <th class="filter">Site</th>
                                    <th class="filter">Code</th>
                                    <th class="filter">Name</th>
                                    <th class="filter">Duration</th>
                                    <th class="filter">Normal Price</th>
                                    <th class="filter">Member Price</th>
                                    <th class="filter">Description</th>
                                    <th class="filter">Launch At</th>
                                    <th class="filter">End At</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-alcrud-modal title="Master Paket" tableId="#datatable" />
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
                ajax: '{{ route('package.index') }}',
                pageLength: 25,
                colReorder: true,
                order: [
                    [0, 'desc']
                ],
                columns: [{
                    "data": "id"
                }, {
                    "data": "site.city_name"
                }, {
                    "data": "code"
                }, {
                    "data": "name"
                }, {
                    "data": "duration"
                }, {
                    "data": "normal_price"
                }, {
                    "data": "member_price"
                }, {
                    "data": "description"
                }, {
                    "data": "launch_at"
                }, {
                    "data": "end_at"
                }, {
                    "data": "actions",
                    "width": "100px",
                }],
                columnDefs: [{
                        targets: -1,
                        searchable: false,
                        orderable: false,
                        class: "text-center"
                    },
                    {
                        targets: [4, 5, 6],
                        width: "50px",
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
