<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Http\Requests\UpdatePackageRequest;
use App\Http\Requests\StorePackageRequest;
use App\Policies\PackagePolicy;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class PackageController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->authorizeResource(Package::class);
    }

    protected function buildQuery()
    {
      $table = Package::getTableName();
      return Package::select([
       "{$table}.id","{$table}.site_id","{$table}.code","{$table}.name","{$table}.normal_price","{$table}.member_price","{$table}.description","{$table}.launch_at","{$table}.end_at"
      ]);
    }

    protected function buildDatatable($query)
    {
      return datatables($query);
        // ->addColumn("firstCol", function (Package $record) {
        //   return $record->field;
        // })
        // ->addColumn("secondCol", function (Package $record) {
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
                ->addColumn('actions', function (Package $record) use ($user) {
                    $actions = [
                      $user->can(PackagePolicy::POLICY_NAME.".view") ? "<a href='" . route("package.show", $record->id) . "' class='btn btn-xs btn-primary modal-remote' title='Show'><i class='fas fa-eye'></i></a>" : '', // show
                      $user->can(PackagePolicy::POLICY_NAME.".update") ? "<a href='" . route("package.edit", $record->id) . "' class='btn btn-xs btn-warning modal-remote' title='Edit'><i class='fas fa-pencil-alt'></i></a>" : '', // edit
                      $user->can(PackagePolicy::POLICY_NAME.".delete") ? "<a href='" . route("package.destroy", $record->id) . "' class='btn btn-xs btn-danger btn-delete' title='Delete'><i class='fas fa-trash'></i></a>" : '', // delete
                    ];

                    return '<div class="btn-group">' . implode('', $actions) . '</div>';
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
        Package::create(['created_by' => auth()->id()] + $request->validated());
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

    

    private function formData() {
        return [

        ];
    }
}
