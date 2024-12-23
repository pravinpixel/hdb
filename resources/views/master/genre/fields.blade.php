 <div class="row">  
      <div class="col-sm-12 col-md-6 col-lg-3"> 
            <div class="form-group @if($errors->has('genre_name')) has-error @endif">
               <label for="usr" class="control-label">Genre Name: <span style="color: red">*</span></label> <br><br>
                {!! Form::text('genre_name',null , ['class' => 'form-control danger', 'id' => 'genre_name']) !!}
               @if($errors->has('genre_name'))
                  <label for="genre_name" class="error">{{ $errors->first('genre_name') }}</label>
               @endif
            </div>
   </div>    
</div>