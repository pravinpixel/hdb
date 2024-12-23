
@extends('layouts.default')
@section('content')

@include('flash::message')
@include('flash')

            <div class="row">
                <div class="col-sm-12 col-md-6">         
                    <h2 class="text-dark">Manager Dashboard</h2>
                </div>
            </div>
            {{-- <div class="container"> --}}
            <div class="row">
                <div class="col-md-3 col-xl-3">
                    <div class="card bg-c-blue order-card">
                        <div class="card-block">
                            <h6 class="m-b-20"> Total Items </h6>
                            <h2 class="text-right"><i class="fa fa-cart-plus f-left"></i><span> {{ $data['total_item'] ?? 0 }} </span></h2>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 col-xl-3">
                    <div class="card bg-c-green order-card">
                        <div class="card-block">
                            <h6 class="m-b-20">Total Items Approved</h6>
                            <h2 class="text-right"><i class="fa fa-rocket f-left"></i><span> {{ $data['total_approved'] ?? 0  }} </span></h2>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 col-xl-3">
                    <div class="card bg-c-yellow order-card">
                        <div class="card-block">
                            <h6 class="m-b-20">Total Items Pending </h6>
                            <h2 class="text-right"><i class="fa fa-refresh f-left"></i><span>{{ $data['total_pending'] ?? 0 }}</span></h2>
                           
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 col-xl-3">
                    <div class="card bg-c-pink order-card">
                        <div class="card-block">
                            <h6 class="m-b-20">Total Items Rejected</h6>
                            <h2 class="text-right"><i class="fa fa-credit-card f-left"></i><span>{{ $data['total_rejected'] ?? 0  }}</span></h2>
                        </div>
                    </div>
                </div>
            </div>
        {{-- </div> --}}
            <div class="row">
                <div class="col-sm-12 col-md-6">         
                    <h3 class="text-inverse">Reminder <a class="refresh-remainder" id="tooltip" title="reload table"> <span class="fa fa-refresh">  </span> </a></h3>
                </div>
            </div>
            
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12"> 
                  <div class="card">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="form-group">
                                        <label for="type">Item ID / Item Name:</label>
                                        {!! Form::text('search_item_name', null, ['class' => 'form-control', 'id' => 'search_item_name']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label style="width:100%;">&nbsp;</label>
                                            <button class="btn btn-success" id="search-item"> Search </button>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label style="width:100%;">&nbsp;</label>
                                            <button class="btn btn-info" id="reset-item"> Reset </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12"> 
                                @include('manager.remainder-table')
                            </div>   
                        </div> 
                    </div>   
                </div>    
            </div>
            
@endsection

@push('page_css')
	<link rel="stylesheet" href="{{ asset('dark/assets/plugins/jquery-datatables-editable/datatables.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/pagec/employee.css') }}">
    <link href="{{ asset('dark/assets/plugins/select2/dist/css/select2.css')}}" rel="stylesheet" type="text/css">
@endpush

@push('page_script')
<script type="text/javascript" src="{{ asset('assets/datatables/js/jquery.dataTables.js') }}" ></script>
<script type="text/javascript" src="{{ asset('assets/datatables/js/dataTables.bootstrap.js') }}" ></script>
<script type="text/javascript" src="{{ asset('dark/assets/plugins/select2/dist/js/select2.min.js')}}"> </script>
<script>
 $(function () {
    $("#category").select2({
      ajax: {
         url : '{!! route('category.get-dropdown') !!}',
         data: function (params) {
            return { q: params.term }
         },
         processResults: function (data) {
            $('#subcategory').val('').trigger('change');
            return { results: data };
         }
      }
    });


    var table = $('#manager-remainder-table').DataTable({

        aaSorting     : [[0, 'desc']],
        responsive: true,
        processing: true,
        pageLength: 50,    
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        serverSide: true,
        searching: false, paging: true,info: true,
        bSort: false,
        ajax          : {
            url     : '{!! route('manager.remainder-datatable') !!}',
            dataType: 'json',
            data:   function(d){
                d.search_item_name = $("#search_item_name").val();
            }
        },
        columns       : [
            {data: 'id', name: 'id', visible: false},
            {data: 'item_id', name: 'item.item_id'},
            {data: 'item_name', name: 'item.item_name'},
            {data: 'date_of_return', name: 'item.date_of_return'},
            {data: 'status', name: 'status'},
            {
                data         : 'action', name: 'action', orderable: false, searchable: false,
                fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
                    //  console.log( nTd );
                    $("a", nTd).tooltip({container: 'body'});
                }
            } 
        ],
    });

    $("#remove-form").submit(function(e) {
        e.preventDefault();
        var url = $("#remove-form").attr('action');
         $("#delete").modal('hide');
        $.ajax({
            url: url,  
            type: 'PUT',
            datatype: 'JSON',
            success : function(res) {
               if(res.status) {
                    $('#emplyee-dashboard-table').DataTable().clear().draw();
                    $("#success-message").html(res.msg);
                    $("#success-modal").modal('show');
                    return true;
               }
               $("#error-message").html(res.msg);
               $("#error-modal").modal('show');
               return false;
            },
            error : function(e) {
                $("#error-message").html("Something went wrong try again");
                $("#error-modal").modal('show');
                console.log(`approve-request: ${e}`);
            }
        }); 
    });

    $("#search-item").click(function(){
       $('#manager-remainder-table').DataTable().clear().draw();
    });
    $(".refresh-remainder").click(function() {
        $('#manager-remainder-table').DataTable().clear().draw();
    });
    $("#reset-item").click(function(){
        $('#search_item_name').val('');
        $('#subcategory').val('').trigger('change');
        $('#category').val('').trigger('change');
        $('#genre').val('').trigger('change');
        $('#type').val('').trigger('change');
        $('#manager-remainder-table').DataTable().clear().draw();
    });
            
});
</script>
@endpush

     
