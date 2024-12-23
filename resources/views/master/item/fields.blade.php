 <div class="row">  
    <div class="col-lg-6">
        <div class="form-group">
            <label for="item">Item Ref:</label>
            {!! Form::text('item_ref', $item_ref , ['class' => 'form-control', 'readonly' => 'readonly']) !!}
        </div>
        <div class="form-group">
            <label for="item">Item ID: <span style="color: red">*</span></label>
            {!! Form::text('item_id', null , ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            <label for="item">Item Name: <span style="color: red">*</span></label>
            {!! Form::text('item_name', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            <label for="category">Select Category: <span style="color: red">*</span></label>
           {!! Form::select('category', ['' => '--select category--'], null, ['class' => 'form-control', 'id' => 'category']) !!}
        </div>

        <div class="form-group">
            <label for="subcategory">Select Subcategory:<span style="color: red">*</span></label>
             {!! Form::select('subcategory', ['' => '--select subcategory--'], null, ['class' => 'form-control', 'id' => 'subcategory']) !!}
        </div>
         
        <div class="form-group">
            <label for="item_type">Item Type:<span style="color: red">*</span></label>
             {!! Form::select('item_type', ['' => '--select book type--'], null, ['class' => 'form-control', 'id' => 'item_type']) !!}
        </div>
        <div class="form-group">
            <label for="item_type">Is Need Approval:</label>
             {!! Form::checkbox('is_need_approval', null, false, ['class' => '', 'id' => 'is_need_approval'])  !!}
    
        </div>
        
    </div>


    <div class="col-lg-6">
    
        <div class="form-group">
            <label for="genre">Select Genre:<span style="color: red">*</span></label>
             {!! Form::select('genre', ['' => '--select genre--'], null, ['class' => 'form-control', 'id' => 'genre']) !!}
        </div>

        <div class="form-group">
            <label for="no_of_page">No of pages:<span style="color: red">*</span></label>
            {!! Form::text('no_of_page', null, ['class' => 'form-control', 'id' => 'no_of_page','onkeypress' => 'javascript:return isNumber(event)']) !!}
        </div>

        <div class="form-group">
            <label for="cover_image"> Cover Image:</label>
            {!! Form::file('cover_image',['class' => 'form-control', 'id'=>'cover_image', 'accept'=> "image/*"]) !!}
        </div>

        <div class="form-group">
            <label for="loan_days">Loan Days:<span style="color: red">*</span></label>
            {!! Form::text('loan_days', null, ['class' => 'form-control', 'id' => 'loan_days', 'onkeypress' => 'javascript:return isNumber(event)']) !!}
        </div>
         <div class="form-group">
            <label for="item">Item Description:<span style="color: red">*</span></label>
            {!! Form::textarea('item_description', null, ['class' => 'form-control', 'id' => 'item_description']) !!}
        </div>
    </div>
</div>