<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Requests\StoreEmployeeRequest;
use App\Policies\EmployeePolicy;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class EmployeeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->authorizeResource(Employee::class);
    }

    protected function buildQuery()
    {
      $table = Employee::getTableName();
      return Employee::select([
       "{$table}.id","{$table}.site_id","{$table}.position_id","{$table}.nip","{$table}.name","{$table}.sex_id","{$table}.dob","{$table}.no_hp","{$table}.height","{$table}.weight","{$table}.hire_at","{$table}.address","{$table}.is_active"
      ]);
    }

    protected function buildDatatable($query)
    {
      return datatables($query);
        // ->addColumn("firstCol", function (Employee $record) {
        //   return $record->field;
        // })
        // ->addColumn("secondCol", function (Employee $record) {
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
                ->addColumn('actions', function (Employee $record) use ($user) {
                    $actions = [
                      $user->can(EmployeePolicy::POLICY_NAME.".view") ? "<a href='" . route("employee.show", $record->id) . "' class='btn btn-xs btn-primary modal-remote' title='Show'><i class='fas fa-eye'></i></a>" : '', // show
                      $user->can(EmployeePolicy::POLICY_NAME.".update") ? "<a href='" . route("employee.edit", $record->id) . "' class='btn btn-xs btn-warning modal-remote' title='Edit'><i class='fas fa-pencil-alt'></i></a>" : '', // edit
                      $user->can(EmployeePolicy::POLICY_NAME.".delete") ? "<a href='" . route("employee.destroy", $record->id) . "' class='btn btn-xs btn-danger btn-delete' title='Delete'><i class='fas fa-trash'></i></a>" : '', // delete
                    ];

                    return '<div class="btn-group">' . implode('', $actions) . '</div>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        } else {
            return view('employee.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      $view = view('employee.create', [
        'record' => null
      ] + $this->formData());
      if ($request->ajax()) {
        return response()->json([
          'title' => "Tambah Master Pegawai",
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
     * @param  StoreEmployeeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmployeeRequest $request)
    {
        Employee::create(['created_by' => auth()->id()] + $request->validated());
        if ($request->ajax()) {
            return [
                'notification' => [
                    'type' => "success",
                    'title' => 'Tambah Master Pegawai',
                    'message' => 'Berhasil menambah Master Pegawai',
                ],
                'code' => 200,
                'message' => 'Success',
            ];
        } else {
            return redirect()->route("employee.index")->with('notification', [
                'type' => "success",
                'title' => 'Tambah Master Pegawai',
                'message' => 'Berhasil menambah data Master Pegawai',
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Employee $employee)
    {
      $view = view('employee.show', ['record' => $employee]);
      if ($request->ajax()) {
        return response()->json([
          'title' => "Lihat Master Pegawai",
          'content' => $view->render(),
        ]);
      } else {
        return $view;
      }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Employee $employee)
    {
      $view = view('employee.edit', [
        'record' => $employee
      ] + $this->formData());
      if ($request->ajax()) {
        return response()->json([
          'title' => "Edit Master Pegawai",
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
     * @param  UpdateEmployeeRequest  $request
     * @param  Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $employee->update($request->validated());
        if ($request->ajax()) {
            return [
                'notification' => [
                    'type' => "success",
                    'title' => 'Update Master Pegawai',
                    'message' => 'Berhasil merubah Master Pegawai',
                ],
                'code' => 200,
                'message' => 'Success',
            ];
        } else {
            return redirect()->route("employee.index")->with('notification', [
                'type' => "success",
                'title' => 'Update Master Pegawai',
                'message' => 'Berhasil merubah data Master Pegawai',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return [
            'notification' => [
                'type' => "success",
                'title' => 'Hapus Master Pegawai',
                'message' => 'Berhasil menghapus Master Pegawai',
            ],
            'code' => 200,
            'message' => 'Success',
        ];
    }

    

    private function formData() {
        return [

        ];
    }
}
