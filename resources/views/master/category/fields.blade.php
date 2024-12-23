 <div class="row">  
      <div class="col-sm-12 col-md-6 col-lg-3"> 
            <div class="form-group @if($errors->has('category_name')) has-error @endif">
               <label for="usr" class="control-label">Category Name: <span style="color: red">*</span></label> <br><br>
                {!! Form::text('category_name',null , ['class' => 'form-control danger', 'id' => 'category_name']) !!}
               @if($errors->has('category_name'))
                  <label for="category_name" class="error">{{ $errors->first('category_name') }}</label>
               @endif
            </div>
   </div>    
</div>