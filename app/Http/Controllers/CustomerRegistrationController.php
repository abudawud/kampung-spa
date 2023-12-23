<?php

namespace App\Http\Controllers;

use App\Models\CustomerRegistration;
use App\Http\Requests\UpdateCustomerRegistrationRequest;
use App\Http\Requests\StoreCustomerRegistrationRequest;
use App\Policies\CustomerRegistrationPolicy;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\CustomerRegistrationExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class CustomerRegistrationController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->authorizeResource(CustomerRegistration::class);
    }

    protected function buildQuery()
    {
        $table = CustomerRegistration::getTableName();
        return CustomerRegistration::select([
            "{$table}.id", "{$table}.customer_id", "{$table}.price",
            "{$table}.description", "{$table}.created_at",
        ])->with([
            'customer', 'customer.site',
        ]);
    }

    protected function buildDatatable($query)
    {
        return datatables($query);
        // ->addColumn("firstCol", function (CustomerRegistration $record) {
        //   return $record->field;
        // })
        // ->addColumn("secondCol", function (CustomerRegistration $record) {
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
                ->addColumn('actions', function (CustomerRegistration $record) use ($user) {
                    $actions = [
                        $user->can(CustomerRegistrationPolicy::POLICY_NAME . ".view") ? "<a href='" . route("customer-registration.show", $record->id) . "' class='btn btn-xs btn-primary modal-remote' title='Show'><i class='fas fa-eye'></i></a>" : '', // show
                        $user->can(CustomerRegistrationPolicy::POLICY_NAME . ".update") ? "<a href='" . route("customer-registration.edit", $record->id) . "' class='btn btn-xs btn-warning modal-remote' title='Edit'><i class='fas fa-pencil-alt'></i></a>" : '', // edit
                        $user->can(CustomerRegistrationPolicy::POLICY_NAME . ".delete") ? "<a href='" . route("customer-registration.destroy", $record->id) . "' class='btn btn-xs btn-danger btn-delete' title='Delete'><i class='fas fa-trash'></i></a>" : '', // delete
                    ];

                    return '<div class="btn-group">' . implode('', $actions) . '</div>';
                })
                ->editColumn('created_at', function($record) {
                    return $record->created_at->format('Y-m-d');
                })
                ->editColumn('price', function($record) {
                    return number_format($record->price);
                })
                ->rawColumns(['actions'])
                ->make(true);
        } else {
            return view('customer-registration.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $view = view('customer-registration.create', [
            'record' => null
        ] + $this->formData());
        if ($request->ajax()) {
            return response()->json([
                'title' => "Tambah Registrasi Member",
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
     * @param  StoreCustomerRegistrationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerRegistrationRequest $request)
    {
        CustomerRegistration::create(['created_by' => auth()->id()] + $request->validated());
        if ($request->ajax()) {
            return [
                'notification' => [
                    'type' => "success",
                    'title' => 'Tambah Registrasi Member',
                    'message' => 'Berhasil menambah Registrasi Member',
                ],
                'code' => 200,
                'message' => 'Success',
            ];
        } else {
            return redirect()->route("customer-registration.index")->with('notification', [
                'type' => "success",
                'title' => 'Tambah Registrasi Member',
                'message' => 'Berhasil menambah data Registrasi Member',
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  CustomerRegistration  $customerRegistration
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, CustomerRegistration $customerRegistration)
    {
        $view = view('customer-registration.show', ['record' => $customerRegistration]);
        if ($request->ajax()) {
            return response()->json([
                'title' => "Lihat Registrasi Member",
                'content' => $view->render(),
            ]);
        } else {
            return $view;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  CustomerRegistration  $customerRegistration
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, CustomerRegistration $customerRegistration)
    {
        $view = view('customer-registration.edit', [
            'record' => $customerRegistration
        ] + $this->formData());
        if ($request->ajax()) {
            return response()->json([
                'title' => "Edit Registrasi Member",
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
     * @param  UpdateCustomerRegistrationRequest  $request
     * @param  CustomerRegistration  $customerRegistration
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerRegistrationRequest $request, CustomerRegistration $customerRegistration)
    {
        $customerRegistration->update($request->validated());
        if ($request->ajax()) {
            return [
                'notification' => [
                    'type' => "success",
                    'title' => 'Update Registrasi Member',
                    'message' => 'Berhasil merubah Registrasi Member',
                ],
                'code' => 200,
                'message' => 'Success',
            ];
        } else {
            return redirect()->route("customer-registration.index")->with('notification', [
                'type' => "success",
                'title' => 'Update Registrasi Member',
                'message' => 'Berhasil merubah data Registrasi Member',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  CustomerRegistration  $customerRegistration
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerRegistration $customerRegistration)
    {
        $customerRegistration->delete();
        return [
            'notification' => [
                'type' => "success",
                'title' => 'Hapus Registrasi Member',
                'message' => 'Berhasil menghapus Registrasi Member',
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
        $exporter = new CustomerRegistrationExport($data["data"]);
        return Excel::download($exporter, "Registrasi Member.xlsx");
    }

    private function formData()
    {
        return [];
    }
}
