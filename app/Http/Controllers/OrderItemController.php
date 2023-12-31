<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Http\Requests\UpdateOrderItemRequest;
use App\Http\Requests\StoreOrderItemRequest;
use App\Policies\OrderItemPolicy;
use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;


class OrderItemController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->authorizeResource(OrderItem::class);
    }

    protected function buildQuery()
    {
        $table = OrderItem::getTableName();
        return OrderItem::select([
            "{$table}.id", "{$table}.order_id", "{$table}.item_id",
            "{$table}.qty", "{$table}.duration", "{$table}.price"
        ])->with(['item']);
    }

    protected function buildDatatable($query)
    {
        return datatables($query);
        // ->addColumn("firstCol", function (OrderItem $record) {
        //   return $record->field;
        // })
        // ->addColumn("secondCol", function (OrderItem $record) {
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
    public function index(Request $request, Order $order)
    {
        $user = auth()->user();
        if ($request->ajax()) {
            return $this->buildDatatable($this->buildQuery()->where('order_id', $order->id))
                ->addColumn('actions', function (OrderItem $record) use ($user, $order) {
                    $actions = [
                        $user->can(OrderItemPolicy::POLICY_NAME . ".view") ? "<a href='" . route("order-item.show", $record->id) . "' class='btn btn-xs btn-primary modal-remote' title='Show'><i class='fas fa-eye'></i></a>" : '', // show
                    ];

                    if ($order->is_draft) {
                        $actions[] = $user->can(OrderItemPolicy::POLICY_NAME . ".update") ? "<a href='" . route("order-item.edit", $record->id) . "' class='btn btn-xs btn-warning modal-remote' title='Edit'><i class='fas fa-pencil-alt'></i></a>" : '';
                        $actions[] = $user->can(OrderItemPolicy::POLICY_NAME . ".delete") ? "<a href='" . route("order-item.destroy", $record->id) . "' class='btn btn-xs btn-danger btn-delete' title='Delete'><i class='fas fa-trash'></i></a>" : '';
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
        $view = view('order-item.create', [
            'record' => null,
            'order' => $order,
        ] + $this->formData());
        if ($request->ajax()) {
            return response()->json([
                'title' => "Tambah Order Item",
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
     * @param  StoreOrderItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderItemRequest $request, Order $order)
    {
        $item = Item::findOrFail($request->validated(['item_id']));
        OrderItem::create([
            'created_by' => auth()->id(),
            'order_id' => $order->id,
        ] + $request->validated() + $this->calculateData($request, $order, $item));
        if ($request->ajax()) {
            return [
                'notification' => [
                    'type' => "success",
                    'title' => 'Tambah Order Item',
                    'message' => 'Berhasil menambah Order Item',
                ],
                'datatableId' => '#datatable-item',
                'code' => 200,
                'message' => 'Success',
            ];
        } else {
            return redirect()->route("order-item.index")->with('notification', [
                'type' => "success",
                'title' => 'Tambah Order Item',
                'message' => 'Berhasil menambah data Order Item',
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  OrderItem  $orderItem
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, OrderItem $orderItem)
    {
        $view = view('order-item.show', ['record' => $orderItem]);
        if ($request->ajax()) {
            return response()->json([
                'title' => "Lihat Order Item",
                'content' => $view->render(),
            ]);
        } else {
            return $view;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  OrderItem  $orderItem
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, OrderItem $orderItem)
    {
        $view = view('order-item.edit', [
            'record' => $orderItem,
            'order' => $orderItem->order,
        ] + $this->formData());
        if ($request->ajax()) {
            return response()->json([
                'title' => "Edit Order Item",
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
     * @param  UpdateOrderItemRequest  $request
     * @param  OrderItem  $orderItem
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderItemRequest $request, OrderItem $orderItem)
    {
        $orderItem->update($this->calculateData($request, $orderItem->order, $orderItem->item) + $request->validated());
        if ($request->ajax()) {
            return [
                'notification' => [
                    'type' => "success",
                    'title' => 'Update Order Item',
                    'message' => 'Berhasil merubah Order Item',
                ],
                'datatableId' => '#datatable-item',
                'code' => 200,
                'message' => 'Success',
            ];
        } else {
            return redirect()->route("order-item.index")->with('notification', [
                'type' => "success",
                'title' => 'Update Order Item',
                'message' => 'Berhasil merubah data Order Item',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  OrderItem  $orderItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderItem $orderItem)
    {
        $orderItem->delete();
        return [
            'notification' => [
                'type' => "success",
                'title' => 'Hapus Order Item',
                'message' => 'Berhasil menghapus Order Item',
            ],
            'datatableId' => '#datatable-item',
            'code' => 200,
            'message' => 'Success',
        ];
    }

    private function calculateData(FormRequest $request, Order $order, Item $item)
    {
        $price = $item->guestPrice($order->customer);
        return [
            'duration' => $item->duration * $request->validated('qty'),
            'price' => $price,
            'total' => $price * $request->validated('qty'),
        ];
    }

    private function formData()
    {
        return [];
    }
}
