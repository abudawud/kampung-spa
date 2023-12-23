<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Policies\OrderPolicy;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\OrderExport;
use App\Models\Sys\Role;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->authorizeResource(Order::class);
    }

    protected function buildQuery()
    {
        $user = auth()->user();
        $employee = $user->employee;
        $roles = $user->roles->pluck('name');
        $table = Order::getTableName();
        $query = Order::select([
            "{$table}.id", "{$table}.code", "{$table}.customer_id",
            "{$table}.order_date", "{$table}.name", "{$table}.terapis_id",
            "{$table}.price", "{$table}.transport", "{$table}.invoice_total",
            "{$table}.payment_total"
        ])->with([
            'customer', 'customer.site',
            'terapis',
        ]);
        if (!$roles->contains(Role::ADMIN)) {
            $query->whereHas('customer', function($query) use ($employee) {
                $query->where('site_id', $employee->site_id);
            });
            if ($roles->contains(Role::TERAPIS)) {
                $query->where('terapis_id', $employee->id);
            } else {
                $query->where('created_by', $user->id);
            }
        }

        return $query;
    }

    protected function buildDatatable($query)
    {
        return datatables($query);
        // ->addColumn("firstCol", function (Order $record) {
        //   return $record->field;
        // })
        // ->addColumn("secondCol", function (Order $record) {
        //   return $record->field;
        // });
    }

    public function json()
    {
        $query = $this->buildQuery()
            ->limit(20);
        return $this->buildDatatable($query)->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        if ($request->ajax()) {
            return $this->buildDatatable($this->buildQuery())
                ->addColumn('actions', function (Order $record) use ($user) {
                    $actions = [
                        $user->can(OrderPolicy::POLICY_NAME . ".view") ? "<a href='" . route("order.show", $record->id) . "' class='btn btn-xs btn-primary ' title='Show'><i class='fas fa-eye'></i></a>" : '', // show
                        $user->can(OrderPolicy::POLICY_NAME . ".update") ? "<a href='" . route("order.edit", $record->id) . "' class='btn btn-xs btn-warning ' title='Edit'><i class='fas fa-pencil-alt'></i></a>" : '', // edit
                        $user->can(OrderPolicy::POLICY_NAME . ".delete") ? "<a href='" . route("order.destroy", $record->id) . "' class='btn btn-xs btn-danger btn-delete' title='Delete'><i class='fas fa-trash'></i></a>" : '', // delete
                    ];

                    return '<div class="btn-group">' . implode('', $actions) . '</div>';
                })
                ->editColumn('price', function($record) {
                    return number_format($record->price);
                })
                ->editColumn('transport', function($record) {
                    return number_format($record->transport);
                })
                ->editColumn('invoice_total', function($record) {
                    return number_format($record->invoice_total);
                })
                ->editColumn('payment_total', function($record) {
                    return number_format($record->payment_total);
                })
                ->rawColumns(['actions'])
                ->make(true);
        } else {
            return view('order.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $view = view('order.create', [
            'record' => null
        ] + $this->formData());
        if ($request->ajax()) {
            return response()->json([
                'title' => "Tambah Order",
                'content' => $view->render(),
                'footer' => '<button type="submit" class="btn btn-primary">Simpan</button>',
            ]);
        } else {
            return $view;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreOrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderRequest $request)
    {
        Order::create(['created_by' => auth()->id()] + $request->validated());
        if ($request->ajax()) {
            return [
                'notification' => [
                    'type' => "success",
                    'title' => 'Tambah Order',
                    'message' => 'Berhasil menambah Order',
                ],
                'code' => 200,
                'message' => 'Success',
            ];
        } else {
            return redirect()->route("order.index")->with('notification', [
                'type' => "success",
                'title' => 'Tambah Order',
                'message' => 'Berhasil menambah data Order',
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Order $order)
    {
        $view = view('order.show', ['record' => $order]);
        if ($request->ajax()) {
            return response()->json([
                'title' => "Lihat Order",
                'content' => $view->render(),
            ]);
        } else {
            return $view;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Order $order)
    {
        $view = view('order.edit', [
            'record' => $order
        ] + $this->formData());
        if ($request->ajax()) {
            return response()->json([
                'title' => "Edit Order",
                'content' => $view->render(),
                'footer' => '<button type="submit" class="btn btn-primary">Simpan</button>',
            ]);
        } else {
            return $view;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateOrderRequest  $request
     * @param  Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        $order->update($request->validated());
        if ($request->ajax()) {
            return [
                'notification' => [
                    'type' => "success",
                    'title' => 'Update Order',
                    'message' => 'Berhasil merubah Order',
                ],
                'code' => 200,
                'message' => 'Success',
            ];
        } else {
            return redirect()->route("order.index")->with('notification', [
                'type' => "success",
                'title' => 'Update Order',
                'message' => 'Berhasil merubah data Order',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return [
            'notification' => [
                'type' => "success",
                'title' => 'Hapus Order',
                'message' => 'Berhasil menghapus Order',
            ],
            'code' => 200,
            'message' => 'Success',
        ];
    }


    public function export(Request $request)
    {
        if ($request->get("type") == "excel") {
            return $this->exportExcel();
        } else if ($request->get("type") == "pdf") {
            return $this->exportPdf();
        } else {
            abort(403, "Unknown filetype!");
        }
    }

    private function exportExcel()
    {
        $data = $this->buildDatatable($this->buildQuery())->toArray();
        $exporter = new OrderExport($data["data"]);
        return Excel::download($exporter, "Order.xlsx");
    }

    private function formData()
    {
        return [];
    }
}
