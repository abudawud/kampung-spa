@extends('adminlte::page')

@section('title', 'Master Cabang')
@section('plugins.Datatables', true)

@section('content_header')
    <h1 class="m-0 text-dark">Master Cabang</h1>
@stop
@push('css')
<style>
    .table > thead > tr > th {
        text-align: left !important;
    }
</style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-0">
                <h5 class="card-header bg-primary"><span class="fas fa-file-alt"></span> Data Master Cabang</h5>
                <div class="card-body p-2">
                    <em>*Gunakan filter <b>Search</b> untuk pencarian global / filter perkolom pada bagian bawah</em>
                    <div class="float-right">
                        <div class="btn-group">
                            @can(App\Policies\SitePolicy::POLICY_NAME.".create")
                                <a id="btn-create" href="{{ route('site.create') }}" class="btn btn-primary modal-remote"> <span
                                        class="fas fa-plus"></span></a>
                            @endcan

                            <a data-datatable-id="#datatable" id="btn-reset" class="btn btn-default"> <span class="fas fa-sync"></span></a>
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
                          <th class="text-primary">City Code</th>
                          <th class="text-primary">City Name</th>
                          <th class="text-primary">Owner Name</th>
                          <th class="text-primary">No Hp</th>
                          <th class="text-primary">Address</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                      <tfoot>
                        <tr class="filter">
                          <th></th>
                          <th class="filter">City Code</th>
                          <th class="filter">City Name</th>
                          <th class="filter">Owner Name</th>
                          <th class="filter">No Hp</th>
                          <th class="filter">Address</th>
                          <th></th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
            </div>
        </div>
    </div>

    <x-alcrud-modal title="Master Cabang" tableId="#datatable" />
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
              ajax: '{{ route("site.index") }}',
              pageLength: 25,
              colReorder: true,
              order: [[0, 'desc']],
              columns: [{"data":"id"},{"data":"city_code"},{"data":"city_name"},{"data":"owner_name"},{"data":"no_hp"},{"data":"address"},{"data":"actions"}],
              columnDefs: [
                {targets: -1, searchable: false, orderable: false, class: "text-center"},
                {targets: 0, searchable: false},
                {targets: 0, visible: false},
                {targets: "_all", defaultContent: '-'},
              ]
            });
            api.on('init.dt', function() {
                var r = $('#datatable tfoot tr.filter');
                r.find('th').each(function(){
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

