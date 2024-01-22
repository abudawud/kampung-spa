@extends('adminlte::page')

@section('title', 'Order')
@section('plugins.Datatables', true)
@section('plugins.Select2', true)
@section('plugins.DateRangePicker', true)
@section('plugins.TimePicker', true)
@section('plugins.InputMask', true)

@section('content_header')
    <h1 class="m-0 text-dark">Order</h1>
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
                <h5 class="card-header bg-primary"><span class="fas fa-file-alt"></span> Data Order</h5>
                <div class="card-body p-2">
                    <em>*Gunakan filter <b>Search</b> untuk pencarian global / filter perkolom pada bagian bawah</em>
                    <div class="float-right">
                        <div class="btn-group">
                            @can(App\Policies\OrderPolicy::POLICY_NAME . '.create')
                                <a id="btn-create" href="{{ route('order.create') }}" class="btn btn-primary modal-remote"> <span
                                        class="fas fa-plus"></span></a>
                            @endcan
                            <div class="btn-group">
                                <a class="btn btn-default dropdown-toggle" href="#" role="button"
                                    id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="fas fa-file-export"></span> Export Data
                                </a>

                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <button id="btn-export-excel" title="Export Excel" class="dropdown-item"> <span
                                            class="fas fa-file-excel"></span> Excel</button>
                                </div>
                            </div>
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
                                    <th class="text-primary">Customer</th>
                                    <th class="text-primary">Order Date</th>
                                    <th class="text-primary">Name</th>
                                    <th class="text-primary">Terapis</th>
                                    <th class="text-primary">Price</th>
                                    <th class="text-primary">Ongkos</th>
                                    <th class="text-primary">Invoice Total</th>
                                    <th class="text-primary">Payment Total</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr class="filter">
                                    <th></th>
                                    <th class="filter">Site</th>
                                    <th class="filter">Customer</th>
                                    <th class="filter">Order Date</th>
                                    <th class="filter">Name</th>
                                    <th class="filter">Terapis</th>
                                    <th class="filter">Price</th>
                                    <th class="filter">Ongkos</th>
                                    <th class="filter">Invoice Total</th>
                                    <th class="filter">Payment Total</th>
                                    <th></th>
                                </tr>
                                <tr class="bg-light">
                                    <th class="text-center" colspan="6">TOTAL</th>
                                    <th class="text-right" id="total-price"></th>
                                    <th class="text-right" id="total-ongkos"></th>
                                    <th class="text-right" id="total-invoice"></th>
                                    <th class="text-right" id="total-payment"></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-alcrud-modal title="Order" tableId="#datatable" />
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
                ajax: {
                    url: "{{ route('order.index') }}",
                    dataSrc: function(json) {
                        $('#total-price').html(json.total.price);
                        $('#total-ongkos').html(json.total.ongkos);
                        $('#total-invoice').html(json.total.invoice_total);
                        $('#total-payment').html(json.total.payment_total);
                        return json.data;
                    }
                },
                pageLength: 25,
                colReorder: true,
                order: [
                    [0, 'desc']
                ],
                columns: [{
                    "data": "id"
                }, {
                    "data": "site.city_code",
                    "width": "50px",
                }, {
                    "data": "customer.name"
                }, {
                    "data": "order_date"
                }, {
                    "data": "name"
                }, {
                    "data": "terapis.name"
                }, {
                    "data": "price"
                }, {
                    "data": "terapis_price"
                }, {
                    "data": "invoice_total"
                }, {
                    "data": "payment_total"
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
                        targets: [-2, -3, -4, -5],
                        width: "60px",
                        class: 'text-right',
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

            function downloadInNewTab(url) {
                const a = document.createElement('a');
                a.href = url;
                a.target = '_blank'; // Open in a new tab
                a.rel = 'noopener noreferrer'; // No referrer for security reasons
                document.body.appendChild(a); // Temporarily add to the DOM
                a.click(); // Trigger a click
                document.body.removeChild(a); // Remove from the DOM
            }

            $('#btn-export-excel').on('click', function(e) {
                const params = api.ajax.params();
                delete params.start;
                delete params.limit;

                downloadInNewTab("{{ route('order.export') }}" + "?type=excel&" + $.param(
                    params));
            });
        });
    </script>
@stop
