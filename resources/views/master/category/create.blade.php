@extends('layouts.default')
@section('content')
   @include('flash::message')
   @include('flash')
    <div class="row">
      <div class="col-sm-12 col-md-6">         
         <h2 class="text-dark"> Create </h2>
      </div>
      <div class="col-sm-12 col-md-6">         
         <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
               @if(Sentinel::inRole('admin'))
               <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
               @elseif(Sentinel::inRole('manager')) 
               <li class="breadcrumb-item"><a href="{{route('manager.dashboard')}}">Dashboard</a></li>
               @endif
               <li class="breadcrumb-item "><a href="{{ route('category.index') }}">Categories</a></li>
               <li class="breadcrumb-item active" aria-current="page">Create</li>
            </ol>
         </nav>
      </div>
   </div>
   <div class="card">
      <div class="form">
         {!! Form::open(['route' => 'category.store', 'method' => 'post',  'class' => ' pad-10', 'id' => 'categoryForm']) !!}
            @include('master.category.fields')
            <input type="submit" class="btn btn-success" value="@lang('global.save')">
         {!! Form::close() !!}
      </div>
   </div>
@stop


@push('page_script')
<script src="{{ asset('assets/pages/category.js') }}"></script>
@endpush