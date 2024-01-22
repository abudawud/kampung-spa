<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Http\Requests\UpdatePackageRequest;
use App\Http\Requests\StorePackageRequest;
use App\Policies\PackagePolicy;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Site;
use App\Models\Sys\Role;
use App\Policies\PackageItemPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PackageController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->authorizeResource(Package::class);
    }

    protected function buildQuery()
    {
        $user = auth()->user();
        $employee = $user->employee;
        $roles = $user->roles->pluck('name');
        $table = Package::getTableName();
        $query = Package::select([
            "{$table}.id", "{$table}.site_id", "{$table}.code",
            "{$table}.name", "{$table}.normal_price", "{$table}.member_price",
            "{$table}.description", "{$table}.launch_at", "{$table}.end_at",
            "{$table}.duration",
        ])->with(['site']);
        if (!$roles->contains(Role::ADMIN)) {
            $query->where('site_id', $employee->site_id);
        }
        return $query;
    }

    protected function buildDatatable($query)
    {
        return datatables($query)
            ->filterColumn('site_id', function ($query, $keyword) {
                $query->where('site_id', $keyword);
            });
        // ->addColumn("firstCol", function (Package $record) {
        //   return $record->field;
        // })
        // ->addColumn("secondCol", function (Package $record) {
        //   return $record->field;
        // });
    }

    public function json(Request $request)
    {
        $query = $this->buildQuery()
            ->limit(20);
        $datatable = $this->buildDatatable($query)
            ->rawColumns(['name']);

        if ($request->has('customer_id')) {
            $customer = Customer::find($request->get('customer_id'));
            $datatable->addColumn('guest_price', function ($record) use ($customer) {
                return $record->guestPrice($customer);
            });
        }

        return $datatable->make(true);
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
                ->addColumn('actions', function (Package $record) use ($user) {
                    $actions = [
                        $user->can(PackagePolicy::POLICY_NAME . ".view") ? "<a href='" . route("package.show", $record->id) . "' class='btn btn-xs btn-primary modal-remote' title='Show'><i class='fas fa-eye'></i></a>" : '', // show
                        $user->can(PackagePolicy::POLICY_NAME . ".update") ? "<a href='" . route("package.edit", $record->id) . "' class='btn btn-xs btn-warning modal-remote' title='Edit'><i class='fas fa-pencil-alt'></i></a>" : '', // edit
                        $user->can(PackagePolicy::POLICY_NAME . ".delete") ? "<a href='" . route("package.destroy", $record->id) . "' class='btn btn-xs btn-danger btn-delete' title='Delete'><i class='fas fa-trash'></i></a>" : '', // delete
                    ];

                    $extraAction = [];
                    if ($user->can(PackageItemPolicy::POLICY_NAME . ".viewAny")) {
                        $extraAction[] = "<a class='btn btn-xs bg-secondary' href='" . route('package.package-item.index', $record) . "'><span class='fas fa-fw fa-cubes'></span></a>";
                    }

                    return '<div class="btn-group mx-1">' . implode('', $extraAction) . '</div>' . '<div class="btn-group">' . implode('', $actions) . '</div>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        } else {
            return view('package.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $view = view('package.create', [
            'record' => null
        ] + $this->formData());
        if ($request->ajax()) {
            return response()->json([
                'title' => "Tambah Master Paket",
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
     * @param  StorePackageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePackageRequest $request)
    {
        $site = Site::findOrFail($request->validated('site_id'));
        Package::create([
            'created_by' => auth()->id(),
            'code' => Package::newCode($site->city_code),
        ] + $request->validated());
        if ($request->ajax()) {
            return [
                'notification' => [
                    'type' => "success",
                    'title' => 'Tambah Master Paket',
                    'message' => 'Berhasil menambah Master Paket',
                ],
                'code' => 200,
                'message' => 'Success',
            ];
        } else {
            return redirect()->route("package.index")->with('notification', [
                'type' => "success",
                'title' => 'Tambah Master Paket',
                'message' => 'Berhasil menambah data Master Paket',
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Package $package)
    {
        $view = view('package.show', ['record' => $package]);
        if ($request->ajax()) {
            return response()->json([
                'title' => "Lihat Master Paket",
                'content' => $view->render(),
            ]);
        } else {
            return $view;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Package $package)
    {
        $view = view('package.edit', [
            'record' => $package
        ] + $this->formData());
        if ($request->ajax()) {
            return response()->json([
                'title' => "Edit Master Paket",
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
     * @param  UpdatePackageRequest  $request
     * @param  Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePackageRequest $request, Package $package)
    {
        $package->update($request->validated());
        if ($request->ajax()) {
            return [
                'notification' => [
                    'type' => "success",
                    'title' => 'Update Master Paket',
                    'message' => 'Berhasil merubah Master Paket',
                ],
                'code' => 200,
                'message' => 'Success',
            ];
        } else {
            return redirect()->route("package.index")->with('notification', [
                'type' => "success",
                'title' => 'Update Master Paket',
                'message' => 'Berhasil merubah data Master Paket',
            ]);
        }
    }

    public function updateHarga(Request $request, Package $package)
    {
        $view = view('package.update-harga', [
            'record' => $package
        ] + $this->formData());
        if ($request->ajax()) {
            if ($request->isMethod('get')) {
                return response()->json([
                    'title' => "Update Harga Paket",
                    'content' => $view->render(),
                    'footer' => '<button type="submit" class="btn btn-primary">Simpan</button>',
                ]);
            } else {
                $validated = Validator::make($request->all(), [
                    'normal_price' => 'required|integer|gt:0',
                    'member_price' => 'required|integer|gt:0',
                ])->validate();
                $package->update($validated);
                return [
                    'notification' => [
                        'type' => "success",
                        'title' => 'Update Harga',
                        'message' => 'Berhasil merubah harga paket',
                    ],
                    'datatableId' => '#datatable-item',
                    'callback_function' => 'updateHarga',
                    'callback_data' => $package,
                    'code' => 200,
                    'message' => 'Success',
                ];
            }
        } else {
            return $view;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        $package->delete();
        return [
            'notification' => [
                'type' => "success",
                'title' => 'Hapus Master Paket',
                'message' => 'Berhasil menghapus Master Paket',
            ],
            'code' => 200,
            'message' => 'Success',
        ];
    }



    private function formData()
    {
        $user = auth()->user();
        return [
            'sites' => $user->availableSites()->get()->pluck('city_name', 'id'),
        ];
    }
}
