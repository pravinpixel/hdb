<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateGenreRequest;
use App\Http\Requests\UpdateGenreRequest;
use App\Models\Genre;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Yajra\DataTables\Facades\DataTables;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master.genre.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('master.genre.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateGenreRequest $request)
    {
          $genre = new Genre();
          $genre->genre_name = $request->genre_name;
          if($genre->save()) {
               Flash::success(__('global.inserted'));
               return redirect()->route('genre.index');
          }
          Flash::error(__('global.something'));
          return redirect()->route('genre.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         return view('master.genre.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
          $result = Genre::find($id);
          if( !empty( $result ) ) {
               return view('master.genre.edit', compact('result'));
          } 
          Flash::error(__('global.something'));
          return redirect()->route('genre.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGenreRequest $request, $id)
    {
          $genre = Genre::find($id);
          $genre->genre_name = $request->genre_name;
          if($genre->save()) {
               Flash::success(__('global.updated'));
               return redirect()->route('genre.index');
          }
          Flash::error(__('global.something'));
          return redirect()->route('genre.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
          $genre = Genre::find($id);

          if (empty($genre)) {
               Flash::error( __('global.not_found'));

               return redirect()->route('genre.index');
          }
          if( $genre->item()->exists() ) {
               Flash::error( __('global.can_not_delete'));
               return redirect()->route('genre.index');
          }
          $genre->delete();
          Flash::success( __('global.deleted'));
          return redirect()->route('genre.index');
    }

    public function datatable(Request $request) 
    {
      if ($request->ajax() == true) {
          $dataDb =  Genre::with('item');
          return DataTables::eloquent($dataDb)
          ->editColumn('created_at', function($dataDb){
               return Carbon::parse($dataDb->created_at)->format('d-m-Y');
          })
          ->editColumn('updated_at', function($dataDb){
               return Carbon::parse($dataDb->updated_at)->format('d-m-Y');
          })
          ->addColumn('status', function ($dataDb) {
               
               if ($dataDb->is_active == 1) {
                    $message = $dataDb->item()->exists() ? trans('global.deactivate_subheading_master', ['name' => $dataDb->genre_name]) : trans('global.deactivate_subheading', ['name' => $dataDb->genre_name]);
                    return '<a href="#" data-message="' . $message . '" data-href="' . route('genre.status', $dataDb->id) . '" id="tooltip" data-method="PUT" data-title="' . trans('global.activate_subheading') . '" data-title-modal="' . trans('global.activate_subheading') . '" data-toggle="modal" data-target="#delete" title="' . trans('global.deactivate') . '"><span class="label label-success label-sm">' . trans('auth.index_active_link') . '</span></a>';
               }
               return '<a href="#" data-message="' . trans('global.activate_subheading', ['name' => $dataDb->genre_name]) . '" data-href="' . route('genre.status', $dataDb->id) . '" id="tooltip" data-method="PUT" data-title="' . trans('global.activate_subheading') . '" data-title-modal="' . trans('global.activate_subheading') . '" data-toggle="modal" data-target="#delete" title="' . trans('global.activate') . '"><span class="label label-danger label-sm">' . trans('auth.index_inactive_link') . '</span></a>';
          })
          ->addColumn('action', function ($dataDb) {
               return '<a href="' . route('genre.edit', $dataDb->id) . '" id="tooltip" title="Edit"><span class="label label-warning label-sm"><i class="fa fa-edit"></i></span></a>
                         <a href="#" data-message="' . trans('global.delete_confirmation', ['name' => $dataDb->material_code]) . '" data-href="' . route('genre.destroy', $dataDb->id) . '" id="tooltip" data-method="DELETE" data-title="Delete" data-title-modal="' . trans('auth.delete_confirmation_heading') . '" data-toggle="modal" data-target="#delete"><span class="label label-danger label-sm"><i class="fa fa-trash-o"></i></span></a>';     
          })
          ->rawColumns(['status','action'])
          ->make(true);
          }
     }

     public function status($id)
    {
        $result = Genre::find($id);
        $result->is_active = ($result->is_active == 1) ? 0 : 1;
        $result->update();
        if( $result ) {
            Flash::success(__('global.status_updated'));
            return redirect()->route('genre.index');
        }
        Flash::error(__('global.something'));
        return redirect()->route('genre.index');
    }

    public function getDropdown(Request $request)
    {
        $query = $request->input('q');
        return Genre::where('genre_name', 'like', '%' .  $query. '%')
                        ->where('is_active', 1)
                        ->limit(25)
                        ->get()
                        ->map(function($row) {
                            return  ["id" => $row->id, "text" => $row->genre_name ];
                        });
    }
}
