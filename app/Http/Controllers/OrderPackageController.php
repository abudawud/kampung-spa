<?php

namespace App\Http\Controllers;

use App\Models\OrderPackage;
use App\Http\Requests\UpdateOrderPackageRequest;
use App\Http\Requests\StoreOrderPackageRequest;
use App\Policies\OrderPackagePolicy;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderPackageItem;
use App\Models\Package;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;


class OrderPackageController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->authorizeResource(OrderPackage::class);
    }

    protected function buildQuery(Order $order)
    {
        $table = OrderPackage::getTableName();
        return OrderPackage::select([
            "{$table}.id", "{$table}.order_id", "{$table}.package_id",
            "{$table}.qty", "{$table}.duration", "{$table}.price"
        ])->where('order_id', $order->id)->with('package');
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

    public function json(Order $order)
    {
        $query = $this->buildQuery($order)
            ->limit(20);
        return $this->buildDatatable($query)->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Order $order)
    {
        $user = auth()->user();
        if ($request->ajax()) {
            return $this->buildDatatable($this->buildQuery($order))
                ->addColumn('actions', function (OrderPackage $record) use ($user, $order) {
                    $actions = [
                        $user->can(OrderPackagePolicy::POLICY_NAME . ".view") ? "<a href='" . route("order-package.show", $record->id) . "' class='btn btn-xs btn-primary modal-remote' title='Show'><i class='fas fa-eye'></i></a>" : '', // show
                    ];
                    if ($order->is_draft) {
                        $actions[] = $user->can(OrderPackagePolicy::POLICY_NAME . ".update") ? "<a href='" . route("order-package.edit", $record->id) . "' class='btn btn-xs btn-warning modal-remote' title='Edit'><i class='fas fa-pencil-alt'></i></a>" : '';
                        $actions[] = $user->can(OrderPackagePolicy::POLICY_NAME . ".delete") ? "<a href='" . route("order-package.destroy", $record->id) . "' class='btn btn-xs btn-danger btn-delete' title='Delete'><i class='fas fa-trash'></i></a>" : '';
                    }

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
        $package = Package::with('items.item')
            ->whereHas('items')
            ->findOrFail($request->validated(['package_id']));
        $op = OrderPackage::create([
            'order_id' => $order->id,
            'created_by' => auth()->id()
        ] + $request->validated() + $this->calculateData($request, $order, $package));
        $this->insertItems($op);
        if ($request->ajax()) {
            return [
                'notification' => [
                    'type' => "success",
                    'title' => 'Tambah Order Package',
                    'message' => 'Berhasil menambah Order Package',
                ],
                'datatableId' => '#datatable-package',
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
            'record' => $orderPackage,
            'order' => $orderPackage->order,
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
        $orderPackage->update($this->calculateData($request, $orderPackage->order, $orderPackage->package) +$request->validated());
        $orderPackage->items()->delete();
        $this->insertItems($orderPackage);
        if ($request->ajax()) {
            return [
                'notification' => [
                    'type' => "success",
                    'title' => 'Update Order Package',
                    'message' => 'Berhasil merubah Order Package',
                ],
                'datatableId' => '#datatable-package',
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
            'datatableId' => '#datatable-package',
            'code' => 200,
            'message' => 'Success',
        ];
    }


    private function calculateData(FormRequest $request, Order $order, Package $package)
    {
        $price = $package->guestPrice($order->customer);
        return [
            'duration' => $package->duration * $request->validated('qty'),
            'price' => $price,
            'total' => $price * $request->validated('qty'),
        ];
    }

    private function insertItems(OrderPackage $op) {
        $order = $op->order;
        $package = $op->package;
        $totalPrice = $package->items->sum('item.normal_price');
        if ($order->customer->is_member) {
            $totalPrice = $package->items->sum('item.member_price');
        }
        $totalDuration = $package->items->sum('item.duration');
        foreach ($package->items as $item) {
            OrderPackageItem::create([
                'order_package_id' => $op->id,
                'item_id' => $item->item_id,
                'duration' => $totalDuration == 0 ? 0 : ($item->item->duration / $totalDuration) * $op->duration,
                'total' => $totalPrice == 0 ? 0 : ($item->item->price / $totalPrice) * $op->price,
            ]);
        }
    }

    private function formData()
    {
        return [];
    }
}
