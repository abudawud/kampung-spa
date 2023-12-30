<div class="card">
    <h5 class="card-header bg-light"><span class="fas fa-file-alt"></span> Package</h5>
    <div class="card-body p-2">
        <div class="float-right">
            <div class="btn-group">
                @can(App\Policies\OrderPackagePolicy::POLICY_NAME . '.create')
                <a id="btn-create" href="{{ route('order.order-package.create', $record) }}" class="btn btn-primary modal-remote"> <span class="fas fa-plus"></span></a>
                @endcan
                <a id="btn-reset" class="btn btn-default"> <span class="fas fa-sync"></span></a>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="table-responsive mt-2 table-package">
            <table width="100%" id="datatable-package" class="table table-sm table-hover">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th class="text-primary">Package</th>
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
                        <th class="filter">Package</th>
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
        $('#datatable-package tfoot tr.filter th.filter').each(function() {
            var title = $(this).text();
            $(this).html('<input class="form-control" type="text" placeholder="Search ' + title +
                '" />');
        });
        const dom = "<'row'<'col-sm-12 col-md-12'l>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>";
        const api = $('#datatable-package').DataTable({
            dom: dom,
            processing: true,
            serverSide: true,
            ajax: "{{ route('order.order-package.index', $record) }}",
            pageLength: 25,
            colReorder: true,
            order: [
                [0, 'desc']
            ],
            columns: [{
                "data": "id"
            }, {
                "data": "package.name"
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
                    targets: [2, 3, 4],
                    "width": "40px",
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
            var r = $('#datatable-package tfoot tr.filter');
            r.find('th').each(function() {
                $(this).css('padding', 8);
            });
            $('#datatable-package thead').append(r);

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
