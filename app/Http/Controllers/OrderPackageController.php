<?php

namespace App\Http\Controllers;

use App\Models\OrderPackage;
use App\Http\Requests\UpdateOrderPackageRequest;
use App\Http\Requests\StoreOrderPackageRequest;
use App\Policies\OrderPackagePolicy;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;


class OrderPackageController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->authorizeResource(OrderPackage::class);
    }

    protected function buildQuery()
    {
        $table = OrderPackage::getTableName();
        return OrderPackage::select([
            "{$table}.id", "{$table}.order_id", "{$table}.package_id", "{$table}.qty", "{$table}.duration", "{$table}.price"
        ]);
    }

    protected function buildDatatable($query)
    {
        return datatables($query);
        // ->addColumn("firstCol", function (OrderPackage $record) {
        //   return $record->field;
        // })
        // ->addColumn("secondCol", function (OrderPackage $record) {
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
                ->addColumn('actions', function (OrderPackage $record) use ($user) {
                    $actions = [
                        $user->can(OrderPackagePolicy::POLICY_NAME . ".view") ? "<a href='" . route("order-package.show", $record->id) . "' class='btn btn-xs btn-primary modal-remote' title='Show'><i class='fas fa-eye'></i></a>" : '', // show
                        $user->can(OrderPackagePolicy::POLICY_NAME . ".update") ? "<a href='" . route("order-package.edit", $record->id) . "' class='btn btn-xs btn-warning modal-remote' title='Edit'><i class='fas fa-pencil-alt'></i></a>" : '', // edit
                        $user->can(OrderPackagePolicy::POLICY_NAME . ".delete") ? "<a href='" . route("order-package.destroy", $record->id) . "' class='btn btn-xs btn-danger btn-delete' title='Delete'><i class='fas fa-trash'></i></a>" : '', // delete
                    ];

                    return '<div class="btn-group">' . implode('', $actions) . '</div>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        } else {
            abort(404);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Order $order)
    {
        $view = view('order-package.create', [
            'record' => null,
            'order' => $order,
        ] + $this->formData());
        if ($request->ajax()) {
            return response()->json([
                'title' => "Tambah Order Package",
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
     * @param  StoreOrderPackageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderPackageRequest $request, Order $order)
    {
        OrderPackage::create([
            'order_id' => $order->id,
            'created_by' => auth()->id()
        ] + $request->validated());
        if ($request->ajax()) {
            return [
                'notification' => [
                    'type' => "success",
                    'title' => 'Tambah Order Package',
                    'message' => 'Berhasil menambah Order Package',
                ],
                'code' => 200,
                'message' => 'Success',
            ];
        } else {
            return redirect()->route("order-package.index")->with('notification', [
                'type' => "success",
                'title' => 'Tambah Order Package',
                'message' => 'Berhasil menambah data Order Package',
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  OrderPackage  $orderPackage
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, OrderPackage $orderPackage)
    {
        $view = view('order-package.show', ['record' => $orderPackage]);
        if ($request->ajax()) {
            return response()->json([
                'title' => "Lihat Order Package",
                'content' => $view->render(),
            ]);
        } else {
            return $view;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  OrderPackage  $orderPackage
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, OrderPackage $orderPackage)
    {
        $view = view('order-package.edit', [
            'record' => $orderPackage
        ] + $this->formData());
        if ($request->ajax()) {
            return response()->json([
                'title' => "Edit Order Package",
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
     * @param  UpdateOrderPackageRequest  $request
     * @param  OrderPackage  $orderPackage
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderPackageRequest $request, OrderPackage $orderPackage)
    {
        $orderPackage->update($request->validated());
        if ($request->ajax()) {
            return [
                'notification' => [
                    'type' => "success",
                    'title' => 'Update Order Package',
                    'message' => 'Berhasil merubah Order Package',
                ],
                'code' => 200,
                'message' => 'Success',
            ];
        } else {
            return redirect()->route("order-package.index")->with('notification', [
                'type' => "success",
                'title' => 'Update Order Package',
                'message' => 'Berhasil merubah data Order Package',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  OrderPackage  $orderPackage
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderPackage $orderPackage)
    {
        $orderPackage->delete();
        return [
            'notification' => [
                'type' => "success",
                'title' => 'Hapus Order Package',
                'message' => 'Berhasil menghapus Order Package',
            ],
            'code' => 200,
            'message' => 'Success',
        ];
    }



    private function formData()
    {
        return [];
    }
}
