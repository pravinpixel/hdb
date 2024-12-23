<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master.category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategoryRequest $request)
    {
        $category = new Category();
        $category->category_name = $request->category_name;
        if($category->save()) {
            Flash::success(__('global.inserted'));
            return redirect()->route('category.index');
        }
        Flash::error(__('global.something'));
        return redirect()->route('category.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('master.category.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result = Category::find($id);
        if( !empty( $result ) ) {
            return view('master.category.edit', compact('result'));
        } 
        Flash::error(__('global.something'));
        return redirect()->route('category.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        $category = Category::find($id);
        $category->category_name = $request->category_name;
        if($category->save()) {
            Flash::success(__('global.updated'));
            return redirect()->route('category.index');
        }
        Flash::error(__('global.something'));
        return redirect()->route('category.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::with('subcategory')->find($id);
     
        if (empty($category)) {
           Flash::error( __('global.not_found'));
            return redirect()->route('category.index');
        }
        if( $category->subcategory()->exists()) {
            Flash::error( __('global.can_not_delete'));
            return redirect()->route('category.index');
        }

        $category->delete();
        Flash::success( __('global.deleted'));
        return redirect()->route('category.index');
    }

    public function datatable(Request $request) {
        if ($request->ajax() == true) {
            $dataDb =  Category::with('subcategory');
            return DataTables::eloquent($dataDb)
            ->editColumn('created_at', function($dataDb){
                return Carbon::parse($dataDb->created_at)->format('d-m-Y');
            })
            ->editColumn('updated_at', function($dataDb){
                return Carbon::parse($dataDb->updated_at)->format('d-m-Y');
            })
            ->addColumn('status', function ($dataDb) {
               
                if ($dataDb->is_active == 1) {
                    $message = $dataDb->subcategory()->exists() ? trans('global.deactivate_subheading_master', ['name' => $dataDb->category_name]) : trans('global.deactivate_subheading', ['name' => $dataDb->category_name]);
                    return '<a href="#" data-message="' . $message . '" data-href="' . route('category.status', $dataDb->id) . '" id="tooltip" data-method="PUT" data-title="' . trans('global.activate_subheading') . '" data-title-modal="' . trans('global.activate_subheading') . '" data-toggle="modal" data-target="#delete" title="' . trans('global.deactivate') . '"><span class="label label-success label-sm">' . trans('auth.index_active_link') . '</span></a>';
                }
                return '<a href="#" data-message="' . trans('global.activate_subheading', ['name' => $dataDb->category_name]) . '" data-href="' . route('category.status', $dataDb->id) . '" id="tooltip" data-method="PUT" data-title="' . trans('global.activate_subheading') . '" data-title-modal="' . trans('global.activate_subheading') . '" data-toggle="modal" data-target="#delete" title="' . trans('global.activate') . '"><span class="label label-danger label-sm">' . trans('auth.index_inactive_link') . '</span></a>';
            })
            ->addColumn('action', function ($dataDb) {
                return '<a href="' . route('category.edit', $dataDb->id) . '" id="tooltip" title="Edit"><span class="label label-warning label-sm"><i class="fa fa-edit"></i></span></a>
                        <a href="#" data-message="' . trans('global.delete_confirmation', ['name' => $dataDb->material_code]) . '" data-href="' . route('category.destroy', $dataDb->id) . '" id="tooltip" data-method="DELETE" data-title="Delete" data-title-modal="' . trans('auth.delete_confirmation_heading') . '" data-toggle="modal" data-target="#delete"><span class="label label-danger label-sm"><i class="fa fa-trash-o"></i></span></a>';     
            })
            ->rawColumns(['status','action'])
            ->make(true);
        }
    }

    
    public function status($id)
    {
        $result = Category::find($id);
        $result->is_active = ($result->is_active == 1) ? 0 : 1;
        $result->update();
        if( $result ) {
            Flash::success(__('global.status_updated'));
            return redirect()->route('category.index');
        }
        Flash::error(__('global.something'));
        return redirect()->route('category.index');
    }

    public function getDropdown(Request $request)
    {
        $query = $request->input('q');
        return Category::where('category_name', 'like', '%' .  $query. '%')
                        ->where('is_active', 1)
                        ->limit(25)
                        ->get()
                        ->map(function($row) {
                            return  ["id" => $row->id, "text" => $row->category_name ];
                        });
    }
}
