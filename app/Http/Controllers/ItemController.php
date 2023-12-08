<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Http\Requests\UpdateItemRequest;
use App\Http\Requests\StoreItemRequest;
use App\Policies\ItemPolicy;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class ItemController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->authorizeResource(Item::class);
    }

    protected function buildQuery()
    {
      $table = Item::getTableName();
      return Item::with('site')
          ->select([
       "{$table}.id","{$table}.site_id","{$table}.code","{$table}.name","{$table}.duration","{$table}.normal_price","{$table}.member_price","{$table}.description","{$table}.is_active"
      ]);
    }

    protected function buildDatatable($query)
    {
      return datatables($query);
        // ->addColumn("firstCol", function (Item $record) {
        //   return $record->field;
        // })
        // ->addColumn("secondCol", function (Item $record) {
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
                ->addColumn('actions', function (Item $record) use ($user) {
                    $actions = [
                      $user->can(ItemPolicy::POLICY_NAME.".view") ? "<a href='" . route("item.show", $record->id) . "' class='btn btn-xs btn-primary modal-remote' title='Show'><i class='fas fa-eye'></i></a>" : '', // show
                      $user->can(ItemPolicy::POLICY_NAME.".update") ? "<a href='" . route("item.edit", $record->id) . "' class='btn btn-xs btn-warning modal-remote' title='Edit'><i class='fas fa-pencil-alt'></i></a>" : '', // edit
                      $user->can(ItemPolicy::POLICY_NAME.".delete") ? "<a href='" . route("item.destroy", $record->id) . "' class='btn btn-xs btn-danger btn-delete' title='Delete'><i class='fas fa-trash'></i></a>" : '', // delete
                    ];

                    return '<div class="btn-group">' . implode('', $actions) . '</div>';
                })
                ->editColumn('is_active', function($record) {
                    return $record->statusIcon;
                })
                ->rawColumns(['actions', 'is_active'])
                ->make(true);
        } else {
            return view('item.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      $view = view('item.create', [
        'record' => null
      ] + $this->formData());
      if ($request->ajax()) {
        return response()->json([
          'title' => "Tambah Master Treatment",
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
     * @param  StoreItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreItemRequest $request)
    {
        Item::create(['created_by' => auth()->id()] + $request->validated());
        if ($request->ajax()) {
            return [
                'notification' => [
                    'type' => "success",
                    'title' => 'Tambah Master Treatment',
                    'message' => 'Berhasil menambah Master Treatment',
                ],
                'code' => 200,
                'message' => 'Success',
            ];
        } else {
            return redirect()->route("item.index")->with('notification', [
                'type' => "success",
                'title' => 'Tambah Master Treatment',
                'message' => 'Berhasil menambah data Master Treatment',
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Item $item)
    {
      $view = view('item.show', ['record' => $item]);
      if ($request->ajax()) {
        return response()->json([
          'title' => "Lihat Master Treatment",
          'content' => $view->render(),
        ]);
      } else {
        return $view;
      }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Item $item)
    {
      $view = view('item.edit', [
        'record' => $item
      ] + $this->formData());
      if ($request->ajax()) {
        return response()->json([
          'title' => "Edit Master Treatment",
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
     * @param  UpdateItemRequest  $request
     * @param  Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateItemRequest $request, Item $item)
    {
        $item->update($request->validated());
        if ($request->ajax()) {
            return [
                'notification' => [
                    'type' => "success",
                    'title' => 'Update Master Treatment',
                    'message' => 'Berhasil merubah Master Treatment',
                ],
                'code' => 200,
                'message' => 'Success',
            ];
        } else {
            return redirect()->route("item.index")->with('notification', [
                'type' => "success",
                'title' => 'Update Master Treatment',
                'message' => 'Berhasil merubah data Master Treatment',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $item->delete();
        return [
            'notification' => [
                'type' => "success",
                'title' => 'Hapus Master Treatment',
                'message' => 'Berhasil menghapus Master Treatment',
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
