<div class="card">
    <h5 class="card-header bg-light"><span class="fas fa-file-alt"></span> Item</h5>
    <div class="card-body p-2">
        <div class="float-right">
            <div class="btn-group">
                @can(App\Policies\OrderItemPolicy::POLICY_NAME . '.create')
                <a id="btn-create" href="{{ route('order.order-item.create', $record) }}" class="btn btn-primary modal-remote"> <span class="fas fa-plus"></span></a>
                @endcan
                <a id="btn-reset" class="btn btn-default"> <span class="fas fa-sync"></span></a>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="table-responsive mt-2 table-package">
            <table width="100%" id="datatable-item" class="table table-sm table-hover">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th class="text-primary">Order Id</th>
                        <th class="text-primary">Item Id</th>
                        <th class="text-primary">Qty</th>
                        <th class="text-primary">Duration</th>
                        <th class="text-primary">Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr class="filter">
                        <th></th>
                        <th class="filter">Order Id</th>
                        <th class="filter">Item Id</th>
                        <th class="filter">Qty</th>
                        <th class="filter">Duration</th>
                        <th class="filter">Price</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@push('js')
<script>
    $(document).ready(function() {
        // add search and exclude first and last column
        $('#datatable-item tfoot tr.filter th.filter').each(function() {
            var title = $(this).text();
            $(this).html('<input class="form-control" type="text" placeholder="Search ' + title +
                '" />');
        });
        const dom = "<'row'<'col-sm-12 col-md-12'l>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>";
        const api = $('#datatable-item').DataTable({
            dom: dom,
            processing: true,
            serverSide: true,
            ajax: "{{ route('order.order-item.index', $record) }}",
            pageLength: 25,
            colReorder: true,
            order: [
                [0, 'desc']
            ],
            columns: [{
                "data": "id"
            }, {
                "data": "order_id"
            }, {
                "data": "item_id"
            }, {
                "data": "qty"
            }, {
                "data": "duration"
            }, {
                "data": "price"
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
            var r = $('#datatable-item tfoot tr.filter');
            r.find('th').each(function() {
                $(this).css('padding', 8);
            });
            $('#datatable-item thead').append(r);

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
@endpush
