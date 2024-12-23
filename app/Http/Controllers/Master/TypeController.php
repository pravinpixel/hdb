<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTypeRequest;
use App\Http\Requests\UpdateTypeRequest;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Yajra\DataTables\Facades\DataTables;

class TypeController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master.type.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master.type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTypeRequest $request)
    {
        $type = new Type();
        $type->type_name = $request->type_name;
        if($type->save()) {
            Flash::success(__('global.inserted'));
            return redirect()->route('type.index');
        }
        Flash::error(__('global.something'));
        return redirect()->route('type.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('master.type.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result = Type::find($id);
        if( !empty( $result ) ) {
            return view('master.type.edit', compact('result'));
        } 
        Flash::error(__('global.something'));
        return redirect()->route('type.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTypeRequest $request, $id)
    {
        $type = Type::find($id);
        $type->type_name = $request->type_name;
        if($type->save()) {
            Flash::success(__('global.updated'));
            return redirect()->route('type.index');
        }
        Flash::error(__('global.something'));
        return redirect()->route('type.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $type = Type::with('item')->find($id);

        if (empty($type)) {
           Flash::error( __('global.not_found'));

            return redirect()->route('type.index');
        }
        if( $type->item()->exists() ) {
            Flash::error( __('global.can_not_delete'));
            return redirect()->route('type.index');
        }

        $type->delete();
        Flash::success( __('global.deleted'));
        return redirect()->route('type.index');
    }

    public function datatable(Request $request) {
        if ($request->ajax() == true) {
            $dataDb =  Type::with('item');
            return DataTables::eloquent($dataDb)
            ->editColumn('created_at', function($dataDb){
                return Carbon::parse($dataDb->created_at)->format('d-m-Y');
            })
            ->editColumn('updated_at', function($dataDb){
                return Carbon::parse($dataDb->updated_at)->format('d-m-Y');
            })
            ->addColumn('status', function ($dataDb) {
               
                if ($dataDb->is_active == 1) {
                    $message = $dataDb->item()->exists() ? trans('global.deactivate_subheading_master', ['name' => $dataDb->type_name]) : trans('global.deactivate_subheading', ['name' => $dataDb->type_name]);
                    return '<a href="#" data-message="' . $message. '" data-href="' . route('type.status', $dataDb->id) . '" id="tooltip" data-method="PUT" data-title="' . trans('global.activate_subheading') . '" data-title-modal="' . trans('global.activate_subheading') . '" data-toggle="modal" data-target="#delete" title="' . trans('global.deactivate') . '"><span class="label label-success label-sm">' . trans('auth.index_active_link') . '</span></a>';
                }
                return '<a href="#" data-message="' . trans('global.activate_subheading', ['name' => $dataDb->type_name]) . '" data-href="' . route('type.status', $dataDb->id) . '" id="tooltip" data-method="PUT" data-title="' . trans('global.activate_subheading') . '" data-title-modal="' . trans('global.activate_subheading') . '" data-toggle="modal" data-target="#delete" title="' . trans('global.activate') . '"><span class="label label-danger label-sm">' . trans('auth.index_inactive_link') . '</span></a>';
            })
            ->addColumn('action', function ($dataDb) {
                return '<a href="' . route('type.edit', $dataDb->id) . '" id="tooltip" title="Edit"><span class="label label-warning label-sm"><i class="fa fa-edit"></i></span></a>
                        <a href="#" data-message="' . trans('global.delete_confirmation', ['name' => $dataDb->material_code]) . '" data-href="' . route('type.destroy', $dataDb->id) . '" id="tooltip" data-method="DELETE" data-title="Delete" data-title-modal="' . trans('auth.delete_confirmation_heading') . '" data-toggle="modal" data-target="#delete"><span class="label label-danger label-sm"><i class="fa fa-trash-o"></i></span></a>';     
            })
            ->rawColumns(['status','action'])
            ->make(true);
        }
    }

    
    public function status($id)
    {
        $result = Type::find($id);
        $result->is_active = ($result->is_active == 1) ? 0 : 1;
        $result->update();
        if( $result ) {
            Flash::success(__('global.status_updated'));
            return redirect()->route('type.index');
        }
        Flash::error(__('global.something'));
        return redirect()->route('type.index');
    }

    public function getDropdown(Request $request)
    {
        $query = $request->input('q');
        return Type::where('type_name', 'like', '%' .  $query. '%')
                        ->where('is_active', 1)
                        ->limit(25)
                        ->get()
                        ->map(function($row) {
                            return  ["id" => $row->id, "text" => $row->type_name ];
                        });
    }
}
