<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Requests\StoreCustomerRequest;
use App\Policies\CustomerPolicy;
use App\Http\Controllers\Controller;
use App\Models\Site;
use App\Models\Sys\Role;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->authorizeResource(Customer::class);
    }

    protected function buildQuery()
    {
        $user = auth()->user();
        $employee = $user->employee;
        $roles = $user->roles->pluck('name');
        $table = Customer::getTableName();
        $query = Customer::with('site')
            ->select([
                "{$table}.id", "{$table}.site_id", "{$table}.code",
                "{$table}.name", "{$table}.instagram", "{$table}.birth_date",
                "{$table}.no_hp", "{$table}.address", "{$table}.is_member"
            ]);

        if (!$roles->contains(Role::ADMIN)) {
            $query->where('site_id', $employee->site_id);
        }
        return $query;
    }

    protected function buildDatatable($query)
    {
        return datatables($query);
        // ->addColumn("firstCol", function (Customer $record) {
        //   return $record->field;
        // })
        // ->addColumn("secondCol", function (Customer $record) {
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
                ->addColumn('actions', function (Customer $record) use ($user) {
                    $actions = [
                        $user->can(CustomerPolicy::POLICY_NAME . ".view") ? "<a href='" . route("customer.show", $record->id) . "' class='btn btn-xs btn-primary modal-remote' title='Show'><i class='fas fa-eye'></i></a>" : '', // show
                        $user->can(CustomerPolicy::POLICY_NAME . ".update") ? "<a href='" . route("customer.edit", $record->id) . "' class='btn btn-xs btn-warning modal-remote' title='Edit'><i class='fas fa-pencil-alt'></i></a>" : '', // edit
                        $user->can(CustomerPolicy::POLICY_NAME . ".delete") ? "<a href='" . route("customer.destroy", $record->id) . "' class='btn btn-xs btn-danger btn-delete' title='Delete'><i class='fas fa-trash'></i></a>" : '', // delete
                    ];

                    return '<div class="btn-group">' . implode('', $actions) . '</div>';
                })
                ->editColumn('is_member', function ($record) {
                    return $record->memberIcon;
                })
                ->rawColumns(['actions', 'is_member'])
                ->make(true);
        } else {
            return view('customer.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $view = view('customer.create', [
            'record' => null
        ] + $this->formData());
        if ($request->ajax()) {
            return response()->json([
                'title' => "Tambah Master Customer",
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
     * @param  StoreCustomerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerRequest $request)
    {
        $site = Site::findOrFail($request->validated('site_id'));
        Customer::create([
            'created_by' => auth()->id(),
            'code' => Customer::newCode($site->city_code),
        ] + $request->validated());
        if ($request->ajax()) {
            return [
                'notification' => [
                    'type' => "success",
                    'title' => 'Tambah Master Customer',
                    'message' => 'Berhasil menambah Master Customer',
                ],
                'code' => 200,
                'message' => 'Success',
            ];
        } else {
            return redirect()->route("customer.index")->with('notification', [
                'type' => "success",
                'title' => 'Tambah Master Customer',
                'message' => 'Berhasil menambah data Master Customer',
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Customer $customer)
    {
        $view = view('customer.show', ['record' => $customer]);
        if ($request->ajax()) {
            return response()->json([
                'title' => "Lihat Master Customer",
                'content' => $view->render(),
            ]);
        } else {
            return $view;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Customer $customer)
    {
        $view = view('customer.edit', [
            'record' => $customer
        ] + $this->formData());
        if ($request->ajax()) {
            return response()->json([
                'title' => "Edit Master Customer",
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
     * @param  UpdateCustomerRequest  $request
     * @param  Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->validated());
        if ($request->ajax()) {
            return [
                'notification' => [
                    'type' => "success",
                    'title' => 'Update Master Customer',
                    'message' => 'Berhasil merubah Master Customer',
                ],
                'code' => 200,
                'message' => 'Success',
            ];
        } else {
            return redirect()->route("customer.index")->with('notification', [
                'type' => "success",
                'title' => 'Update Master Customer',
                'message' => 'Berhasil merubah data Master Customer',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return [
            'notification' => [
                'type' => "success",
                'title' => 'Hapus Master Customer',
                'message' => 'Berhasil menghapus Master Customer',
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
