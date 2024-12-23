
@extends('layouts.default')
@section('content')
@include('flash::message')
@include('flash')
   <div class="row">
      <div class="col-sm-12 col-md-6">         
         <h2 class="text-dark"> Edit </h2>
      </div>
      <div class="col-sm-12 col-md-6">         
         <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
               @if(Sentinel::inRole('admin'))
               <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
               @elseif(Sentinel::inRole('manager')) 
               <li class="breadcrumb-item"><a href="{{route('manager.dashboard')}}">Dashboard</a></li>
               @endif
               <li class="breadcrumb-item "><a href="{{ route('subcategory.index') }}">Subcategories</a></li>
               <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
         </nav>
      </div>
   </div>
   <div class="card">
      <div class="form">
         {!!  Form::model($result, ['route' => ['subcategory.update', $result->id], 'method' => 'put',  'class' => ' pad-10', 'id' => 'subcategoryForm']) !!}
            @include('master.subcategory.fields')
            <input type="submit" class="btn btn-success" value="@lang('global.update')">
         {!! Form::close() !!}
      </div>
   </div>

@stop

@push('page_css')
   <link href="{{ asset('dark/assets/plugins/select2/dist/css/select2.css')}}" rel="stylesheet" type="text/css">
@endpush

@push('page_script')
<script type="text/javascript" src="{{ asset('dark/assets/plugins/select2/dist/js/select2.min.js')}}"> </script>
<script src="{{ asset('assets/pages/subcategory.js') }}"></script>
<script>

$(document).ready(function(){
   $("#category").select2({
      ajax: {
         url : '{!! route('category.get-dropdown') !!}',
         data: function (params) {
            return { q: params.term }
         },
         processResults: function (data) {
            return { results: data };
         }
      }
   });
   let category = {!! json_encode($result->category->toArray()) !!};
   let categoryOption = new Option(category.category_name, category.id, true, true);
   $('#category').append(categoryOption).trigger('change'); 
});
</script>
@endpush