<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Http\Requests\UpdateSiteRequest;
use App\Http\Requests\StoreSiteRequest;
use App\Policies\SitePolicy;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class SiteController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->authorizeResource(Site::class);
    }

    protected function buildQuery()
    {
      $table = Site::getTableName();
      return Site::select([
       "{$table}.id","{$table}.city_code","{$table}.city_name","{$table}.owner_name","{$table}.no_hp","{$table}.address"
      ]);
    }

    protected function buildDatatable($query)
    {
      return datatables($query);
        // ->addColumn("firstCol", function (Site $record) {
        //   return $record->field;
        // })
        // ->addColumn("secondCol", function (Site $record) {
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
                ->addColumn('actions', function (Site $record) use ($user) {
                    $actions = [
                      $user->can(SitePolicy::POLICY_NAME.".view") ? "<a href='" . route("site.show", $record->id) . "' class='btn btn-xs btn-primary modal-remote' title='Show'><i class='fas fa-eye'></i></a>" : '', // show
                      $user->can(SitePolicy::POLICY_NAME.".update") ? "<a href='" . route("site.edit", $record->id) . "' class='btn btn-xs btn-warning modal-remote' title='Edit'><i class='fas fa-pencil-alt'></i></a>" : '', // edit
                      $user->can(SitePolicy::POLICY_NAME.".delete") ? "<a href='" . route("site.destroy", $record->id) . "' class='btn btn-xs btn-danger btn-delete' title='Delete'><i class='fas fa-trash'></i></a>" : '', // delete
                    ];

                    return '<div class="btn-group">' . implode('', $actions) . '</div>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        } else {
            return view('site.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      $view = view('site.create', [
        'record' => null
      ] + $this->formData());
      if ($request->ajax()) {
        return response()->json([
          'title' => "Tambah Master Cabang",
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
     * @param  StoreSiteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSiteRequest $request)
    {
        Site::create(['created_by' => auth()->id()] + $request->validated());
        if ($request->ajax()) {
            return [
                'notification' => [
                    'type' => "success",
                    'title' => 'Tambah Master Cabang',
                    'message' => 'Berhasil menambah Master Cabang',
                ],
                'code' => 200,
                'message' => 'Success',
            ];
        } else {
            return redirect()->route("site.index")->with('notification', [
                'type' => "success",
                'title' => 'Tambah Master Cabang',
                'message' => 'Berhasil menambah data Master Cabang',
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Site  $site
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Site $site)
    {
      $view = view('site.show', ['record' => $site]);
      if ($request->ajax()) {
        return response()->json([
          'title' => "Lihat Master Cabang",
          'content' => $view->render(),
        ]);
      } else {
        return $view;
      }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Site  $site
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Site $site)
    {
      $view = view('site.edit', [
        'record' => $site
      ] + $this->formData());
      if ($request->ajax()) {
        return response()->json([
          'title' => "Edit Master Cabang",
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
     * @param  UpdateSiteRequest  $request
     * @param  Site  $site
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSiteRequest $request, Site $site)
    {
        $site->update($request->validated());
        if ($request->ajax()) {
            return [
                'notification' => [
                    'type' => "success",
                    'title' => 'Update Master Cabang',
                    'message' => 'Berhasil merubah Master Cabang',
                ],
                'code' => 200,
                'message' => 'Success',
            ];
        } else {
            return redirect()->route("site.index")->with('notification', [
                'type' => "success",
                'title' => 'Update Master Cabang',
                'message' => 'Berhasil merubah data Master Cabang',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Site  $site
     * @return \Illuminate\Http\Response
     */
    public function destroy(Site $site)
    {
        $site->delete();
        return [
            'notification' => [
                'type' => "success",
                'title' => 'Hapus Master Cabang',
                'message' => 'Berhasil menghapus Master Cabang',
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
