   <div class="row">  
      <div class="col-md-6"> 
            <div class="form-group @if($errors->has('subcategory_name')) has-error @endif">
               <label for="usr" class="control-label">Subcategory Name: <span style="color: red">*</span></label> <br> <br>
                {!! Form::text('subcategory_name',null , ['class' => 'form-control danger', 'id' => 'subcategory_name']) !!}
               @if($errors->has('subcategory_name'))
                  <label for="subcategory_name" class="error">{{ $errors->first('subcategory_name') }}</label>
               @endif
            </div>
      </div>    
   </div>
   <div class="row">  
       <div class="col-md-6"> 
            <div class="form-group @if($errors->has('category')) has-error @endif">
               <label for="usr" class="control-label">Category: <span style="color: red">*</span></label> <br> <br>
               {!! Form::select('category', ['' => '--select category--'], null, ['class' => 'form-control', 'id' => 'category']) !!}
               @if($errors->has('category'))
                  <label for="category" class="error">{{ $errors->first('category') }}</label>
               @endif
            </div>
      </div>  
   </div>  
