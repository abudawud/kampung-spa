<?php

namespace App\Http\Controllers;

use App\Models\SiteBank;
use App\Http\Requests\UpdateSiteBankRequest;
use App\Http\Requests\StoreSiteBankRequest;
use App\Policies\SiteBankPolicy;
use App\Http\Controllers\Controller;
use App\Models\Reference;
use App\Models\Site;
use Illuminate\Http\Request;


class SiteBankController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->authorizeResource(SiteBank::class);
    }

    protected function buildQuery(Site $site)
    {
        $table = SiteBank::getTableName();
        return SiteBank::with('bankType')->select([
            "{$table}.id", "{$table}.site_id", "{$table}.bank_type_id",
            "{$table}.bank_no", "{$table}.is_active",
            "{$table}.name",
        ])->where("site_id", $site->id);
    }

    protected function buildDatatable($query)
    {
        return datatables($query);
        // ->addColumn("firstCol", function (SiteBank $record) {
        //   return $record->field;
        // })
        // ->addColumn("secondCol", function (SiteBank $record) {
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
    public function index(Request $request, Site $site)
    {
        $user = auth()->user();
        if ($request->ajax()) {
            return $this->buildDatatable($this->buildQuery($site))
                ->addColumn('actions', function (SiteBank $record) use ($user) {
                    $actions = [
                        $user->can(SiteBankPolicy::POLICY_NAME . ".view") ? "<a href='" . route("site-bank.show", $record->id) . "' class='btn btn-xs btn-primary modal-remote' title='Show'><i class='fas fa-eye'></i></a>" : '', // show
                        $user->can(SiteBankPolicy::POLICY_NAME . ".update") ? "<a href='" . route("site-bank.edit", $record->id) . "' class='btn btn-xs btn-warning modal-remote' title='Edit'><i class='fas fa-pencil-alt'></i></a>" : '', // edit
                        $user->can(SiteBankPolicy::POLICY_NAME . ".delete") ? "<a href='" . route("site-bank.destroy", $record->id) . "' class='btn btn-xs btn-danger btn-delete' title='Delete'><i class='fas fa-trash'></i></a>" : '', // delete
                    ];

                    return '<div class="btn-group">' . implode('', $actions) . '</div>';
                })
                ->editColumn('is_active', function($record) {
                    return $record->statusIcon;
                })
                ->rawColumns(['actions', 'is_active'])
                ->make(true);
        } else {
            return view('site-bank.index', ['site' => $site]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Site $site)
    {
        $view = view('site-bank.create', [
            'record' => null,
            'site' => $site,
        ] + $this->formData());
        if ($request->ajax()) {
            return response()->json([
                'title' => "Tambah Daftar Bank",
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
     * @param  StoreSiteBankRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSiteBankRequest $request, Site $site)
    {
        SiteBank::create([
            'created_by' => auth()->id(),
            'site_id' => $site->id,
        ] + $request->validated());
        if ($request->ajax()) {
            return [
                'notification' => [
                    'type' => "success",
                    'title' => 'Tambah Daftar Bank',
                    'message' => 'Berhasil menambah Daftar Bank',
                ],
                'code' => 200,
                'message' => 'Success',
            ];
        } else {
            return redirect()->route("site-bank.index")->with('notification', [
                'type' => "success",
                'title' => 'Tambah Daftar Bank',
                'message' => 'Berhasil menambah data Daftar Bank',
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  SiteBank  $siteBank
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, SiteBank $siteBank)
    {
        $view = view('site-bank.show', ['record' => $siteBank]);
        if ($request->ajax()) {
            return response()->json([
                'title' => "Lihat Daftar Bank",
                'content' => $view->render(),
            ]);
        } else {
            return $view;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  SiteBank  $siteBank
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, SiteBank $siteBank)
    {
        $view = view('site-bank.edit', [
            'record' => $siteBank
        ] + $this->formData());
        if ($request->ajax()) {
            return response()->json([
                'title' => "Edit Daftar Bank",
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
     * @param  UpdateSiteBankRequest  $request
     * @param  SiteBank  $siteBank
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSiteBankRequest $request, SiteBank $siteBank)
    {
        $siteBank->update($request->validated());
        if ($request->ajax()) {
            return [
                'notification' => [
                    'type' => "success",
                    'title' => 'Update Daftar Bank',
                    'message' => 'Berhasil merubah Daftar Bank',
                ],
                'code' => 200,
                'message' => 'Success',
            ];
        } else {
            return redirect()->route("site-bank.index")->with('notification', [
                'type' => "success",
                'title' => 'Update Daftar Bank',
                'message' => 'Berhasil merubah data Daftar Bank',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  SiteBank  $siteBank
     * @return \Illuminate\Http\Response
     */
    public function destroy(SiteBank $siteBank)
    {
        $siteBank->delete();
        return [
            'notification' => [
                'type' => "success",
                'title' => 'Hapus Daftar Bank',
                'message' => 'Berhasil menghapus Daftar Bank',
            ],
            'code' => 200,
            'message' => 'Success',
        ];
    }



    private function formData()
    {
        return [
            'bankTypes' => Reference::byCat(Reference::BANK_TYPE_CID)->pluck('name', 'id'),
        ];
    }
}
