@extends('adminlte::page')

@section('title', 'Master Pegawai')
@section('plugins.Datatables', true)
@section('plugins.Select2', true)
@section('plugins.DateRangePicker', true)
@section('plugins.InputMask', true)
@section('plugins.BootstrapICheck', true)

@section('content_header')
<h1 class="m-0 text-dark">Master Pegawai</h1>
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
            <h5 class="card-header bg-primary"><span class="fas fa-file-alt"></span> Data Master Pegawai</h5>
            <div class="card-body p-2">
                <em>*Gunakan filter <b>Search</b> untuk pencarian global / filter perkolom pada bagian bawah</em>
                <div class="float-right">
                    <div class="btn-group">
                        @can(App\Policies\EmployeePolicy::POLICY_NAME . '.create')
                        <a id="btn-create" href="{{ route('employee.create') }}" class="btn btn-primary modal-remote">
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
                                <th class="text-primary">Position</th>
                                <th class="text-primary">Nip</th>
                                <th class="text-primary">Name</th>
                                <th class="text-primary">Sex</th>
                                <th class="text-primary">Dob</th>
                                <th class="text-primary">No Hp</th>
                                <th class="text-primary">Height</th>
                                <th class="text-primary">Weight</th>
                                <th class="text-primary">Hire At</th>
                                <th class="text-primary">Address</th>
                                <th class="text-primary">Is Active</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr class="filter">
                                <th></th>
                                <th class="filter">Site</th>
                                <th class="filter">Position</th>
                                <th class="filter">Nip</th>
                                <th class="filter">Name</th>
                                <th class="filter">Sex</th>
                                <th class="filter">Dob</th>
                                <th class="filter">No Hp</th>
                                <th class="filter">Height</th>
                                <th class="filter">Weight</th>
                                <th class="filter">Hire At</th>
                                <th class="filter">Address</th>
                                <th class="filter">Is Active</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<x-alcrud-modal title="Master Pegawai" tableId="#datatable" />
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
            ajax: "{{ route('employee.index') }}",
            pageLength: 25,
            colReorder: true,
            order: [
                [0, 'desc']
            ],
            columns: [{
                "data": "id"
            }, {
                "data": "site.city_code",
                "width": "40px",
            }, {
                "data": "position.name"
            }, {
                "data": "nip"
            }, {
                "data": "name"
            }, {
                "data": "sex.name"
            }, {
                "data": "dob"
            }, {
                "data": "no_hp"
            }, {
                "data": "height"
            }, {
                "data": "weight"
            }, {
                "data": "hire_at"
            }, {
                "data": "address"
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
