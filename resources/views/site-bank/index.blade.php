@extends('adminlte::page')

@section('title', 'Daftar Bank #' . "{$site->city_code} - {$site->city_name}")
@section('plugins.Datatables', true)
@section('plugins.BootstrapICheck', true)
@section('plugins.Select2', true)

@section('content_header')
    <h1 class="m-0 text-dark">Daftar Bank #{{ "{$site->city_code} - {$site->city_name}" }}</h1>
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
                <h5 class="card-header bg-primary"><span class="fas fa-file-alt"></span> Data Daftar Bank</h5>
                <div class="card-body p-2">
                    <em>*Gunakan filter <b>Search</b> untuk pencarian global / filter perkolom pada bagian bawah</em>
                    <div class="float-right">
                        <div class="btn-group">
                            @can(App\Policies\SiteBankPolicy::POLICY_NAME . '.create')
                                <a id="btn-create" href="{{ route('site.site-bank.create', $site) }}"
                                    class="btn btn-primary modal-remote"> <span class="fas fa-plus"></span></a>
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
                                    <th class="text-primary">Jenis Bank</th>
                                    <th class="text-primary">No Rekenging</th>
                                    <th class="text-primary">Atas Nama</th>
                                    <th class="text-primary">Aktif</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr class="filter">
                                    <th></th>
                                    <th class="filter">Jenis Bank</th>
                                    <th class="filter">No Rekenging</th>
                                    <th class="filter">Atas Nama</th>
                                    <th class="filter">Aktif</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <a href='{{ route('site.index') }}' class='btn btn-secondary'>Kembali</a>
                </div>
            </div>
        </div>
    </div>

    <x-alcrud-modal title="Daftar Bank" tableId="#datatable" />
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
                ajax: "{{ route('site.site-bank.index', $site) }}",
                pageLength: 25,
                colReorder: true,
                order: [
                    [0, 'desc']
                ],
                columns: [{
                    "data": "id"
                }, {
                    "data": "bankType.name"
                }, {
                    "data": "bank_no"
                }, {
                    "data": "name"
                }, {
                    "data": "is_active"
                }, {
                    "data": "actions"
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
