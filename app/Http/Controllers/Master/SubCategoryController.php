<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatesubcategoryRequest;
use App\Http\Requests\UpdatesubcategoryRequest;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Yajra\DataTables\Facades\DataTables;

class SubCategoryController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master.subcategory.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master.subcategory.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatesubcategoryRequest $request)
    {
        $subcategory = new Subcategory();
        $subcategory->subcategory_name = $request->subcategory_name;
        $subcategory->category_id = $request->category;
        if($subcategory->save()) {
            Flash::success(__('global.inserted'));
            return redirect()->route('subcategory.index');
        }
        Flash::error(__('global.something'));
        return redirect()->route('subcategory.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('master.subcategory.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result = Subcategory::find($id);
        if( !empty( $result ) ) {
            return view('master.subcategory.edit', compact('result'));
        } 
        Flash::error(__('global.something'));
        return redirect()->route('subcategory.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatesubcategoryRequest $request, $id)
    {
        $subcategory = Subcategory::find($id);
        $subcategory->subcategory_name = $request->subcategory_name;
        $subcategory->category_id = $request->category;
        if($subcategory->save()) {
            Flash::success(__('global.updated'));
            return redirect()->route('subcategory.index');
        }
        Flash::error(__('global.something'));
        return redirect()->route('subcategory.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subcategory = Subcategory::with('item')->find($id);

        if (empty($subcategory)) {
           Flash::error( __('global.not_found'));

            return redirect()->route('subcategory.index');
        }
        if( $subcategory->item()->exists() ) {
            Flash::error( __('global.can_not_delete'));
            return redirect()->route('subcategory.index');
        }

        $subcategory->delete();
        Flash::success(  __('global.deleted'));
        return redirect()->route('subcategory.index');
    }

    public function datatable(Request $request) {
        if ($request->ajax() == true) {
            $dataDb =  Subcategory::with(['category','item'])
                        ->whereHas('category', function($q) {
                           $q->where('is_active',1);
                        });
            return DataTables::eloquent($dataDb)
            ->editColumn('category', function($dataDb){
                return $dataDb->category->category_name;
            })
            ->editColumn('created_at', function($dataDb){
                return Carbon::parse($dataDb->created_at)->format('d-m-Y');
            })
            ->editColumn('updated_at', function($dataDb){
                return Carbon::parse($dataDb->updated_at)->format('d-m-Y');
            })
            ->addColumn('status', function ($dataDb) {
               
                if ($dataDb->is_active == 1) {
                    $message = $dataDb->item()->exists() ? trans('global.deactivate_subheading_master', ['name' => $dataDb->subcategory_name]) : trans('global.deactivate_subheading', ['name' => $dataDb->subcategory_name]);
                    return '<a href="#" data-message="' .  $message . '" data-href="' . route('subcategory.status', $dataDb->id) . '" id="tooltip" data-method="PUT" data-title="' . trans('global.activate_subheading') . '" data-title-modal="' . trans('global.activate_subheading') . '" data-toggle="modal" data-target="#delete" title="' . trans('global.deactivate') . '"><span class="label label-success label-sm">' . trans('auth.index_active_link') . '</span></a>';
                }
                return '<a href="#" data-message="' . trans('global.activate_subheading', ['name' => $dataDb->subcategory_name]) . '" data-href="' . route('subcategory.status', $dataDb->id) . '" id="tooltip" data-method="PUT" data-title="' . trans('global.activate_subheading') . '" data-title-modal="' . trans('global.activate_subheading') . '" data-toggle="modal" data-target="#delete" title="' . trans('global.activate') . '"><span class="label label-danger label-sm">' . trans('auth.index_inactive_link') . '</span></a>';
            })
            ->addColumn('action', function ($dataDb) {
                return '<a href="' . route('subcategory.edit', $dataDb->id) . '" id="tooltip" title="Edit"><span class="label label-warning label-sm"><i class="fa fa-edit"></i></span></a>
                        <a href="#" data-message="' . trans('global.delete_confirmation', ['name' => $dataDb->material_code]) . '" data-href="' . route('subcategory.destroy', $dataDb->id) . '" id="tooltip" data-method="DELETE" data-title="Delete" data-title-modal="' . trans('auth.delete_confirmation_heading') . '" data-toggle="modal" data-target="#delete"><span class="label label-danger label-sm"><i class="fa fa-trash-o"></i></span></a>';     
            })
            ->rawColumns(['status','action'])
            ->make(true);
        }
    }

    
    public function status($id)
    {
        $result = subcategory::find($id);
        $result->is_active = ($result->is_active == 1) ? 0 : 1;
        $result->update();
        if( $result ) {
            Flash::success(__('global.status_updated'));
            return redirect()->route('subcategory.index');
        }
        Flash::error(__('global.something'));
        return redirect()->route('subcategory.index');
    }

    public function getDropdown(Request $request)
    {
        $query = $request->input('q');
        $category = $request->input('category');
        return subcategory::where('category_id', $category)
                        ->where('subcategory_name', 'like', '%' .  $query. '%')
                        ->where('is_active', 1)
                        ->limit(25)
                        ->get()
                        ->map(function($row) {
                            return  ["id" => $row->id, "text" => $row->subcategory_name ];
                        });
    }
}
