<?php

namespace App\Http\Controllers;

use App\Models\PackageItem;
use App\Http\Requests\UpdatePackageItemRequest;
use App\Http\Requests\StorePackageItemRequest;
use App\Policies\PackageItemPolicy;
use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;


class PackageItemController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->authorizeResource(PackageItem::class);
    }

    protected function buildQuery()
    {
        $table = PackageItem::getTableName();
        return PackageItem::select([
            "{$table}.id", "{$table}.package_id", "{$table}.item_id"
        ])->with('item');
    }

    protected function buildDatatable($query)
    {
        return datatables($query);
        // ->addColumn("firstCol", function (PackageItem $record) {
        //   return $record->field;
        // })
        // ->addColumn("secondCol", function (PackageItem $record) {
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
    public function index(Request $request, Package $package)
    {
        $user = auth()->user();
        if ($request->ajax()) {
            return $this->buildDatatable($this->buildQuery())
                ->addColumn('actions', function (PackageItem $record) use ($user) {
                    $actions = [
                        $user->can(PackageItemPolicy::POLICY_NAME . ".delete") ? "<a href='" . route("package-item.destroy", $record->id) . "' class='btn btn-xs btn-danger btn-delete' title='Delete'><i class='fas fa-trash'></i></a>" : '', // delete
                    ];

                    return '<div class="btn-group">' . implode('', $actions) . '</div>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        } else {
            return view('package-item.index', [
                'package' => $package,
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Package $package)
    {
        $view = view('package-item.create', [
            'record' => null,
            'package' => $package,
        ] + $this->formData());
        if ($request->ajax()) {
            return response()->json([
                'title' => "Tambah Package Detail",
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
     * @param  StorePackageItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePackageItemRequest $request, Package $package)
    {
        foreach ($request->validated('items') as $item) {
            PackageItem::create([
                'created_by' => auth()->id(),
                'item_id' => $item,
                'package_id' => $package->id,
            ] + $request->validated());
        }
        if ($request->ajax()) {
            return [
                'notification' => [
                    'type' => "success",
                    'title' => 'Tambah Package Detail',
                    'message' => 'Berhasil menambah Package Detail',
                ],
                'code' => 200,
                'message' => 'Success',
            ];
        } else {
            return redirect()->route("package-item.index")->with('notification', [
                'type' => "success",
                'title' => 'Tambah Package Detail',
                'message' => 'Berhasil menambah data Package Detail',
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  PackageItem  $packageItem
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, PackageItem $packageItem)
    {
        $view = view('package-item.show', ['record' => $packageItem]);
        if ($request->ajax()) {
            return response()->json([
                'title' => "Lihat Package Detail",
                'content' => $view->render(),
            ]);
        } else {
            return $view;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  PackageItem  $packageItem
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, PackageItem $packageItem)
    {
        $view = view('package-item.edit', [
            'record' => $packageItem
        ] + $this->formData());
        if ($request->ajax()) {
            return response()->json([
                'title' => "Edit Package Detail",
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
     * @param  UpdatePackageItemRequest  $request
     * @param  PackageItem  $packageItem
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePackageItemRequest $request, PackageItem $packageItem)
    {
        $packageItem->update($request->validated());
        if ($request->ajax()) {
            return [
                'notification' => [
                    'type' => "success",
                    'title' => 'Update Package Detail',
                    'message' => 'Berhasil merubah Package Detail',
                ],
                'code' => 200,
                'message' => 'Success',
            ];
        } else {
            return redirect()->route("package-item.index")->with('notification', [
                'type' => "success",
                'title' => 'Update Package Detail',
                'message' => 'Berhasil merubah data Package Detail',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  PackageItem  $packageItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(PackageItem $packageItem)
    {
        $packageItem->delete();
        return [
            'notification' => [
                'type' => "success",
                'title' => 'Hapus Package Detail',
                'message' => 'Berhasil menghapus Package Detail',
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
