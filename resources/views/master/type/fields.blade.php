 <div class="row">  
      <div class="col-sm-12 col-md-6 col-lg-3"> 
            <div class="form-group @if($errors->has('type_name')) has-error @endif">
               <label for="usr" class="control-label">Type Name: <span style="color: red">*</span></label> <br><br>
                {!! Form::text('type_name',null , ['class' => 'form-control danger', 'id' => 'type_name']) !!}
               @if($errors->has('type_name'))
                  <label for="type_name" class="error">{{ $errors->first('type_name') }}</label>
               @endif
            </div>
   </div>    
</div>