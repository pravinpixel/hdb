<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <title>{{ env('APP_NAME') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="icon" type="image/x-icon" href="{{ asset('dark/assets/images/favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="{{ asset('dark/assets/css/core.css')}}" rel="stylesheet" type="text/css">
	 <link href="{{ asset('dark/assets/css/icons.css')}}" rel="stylesheet" type="text/css">
	 <link href="{{ asset('dark/assets/css/components.css')}}" rel="stylesheet" type="text/css">
	 <link href="{{ asset('dark/assets/css/common.css')}}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Cabin:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="{{ asset('dark/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('dark/assets/css/style.css')}}" rel="stylesheet"/>
 
  </head>
  <body>
    <div class="load-bg">
      <div class="loader"></div>
    </div>
    <div class="container-fluid">
      <div class="header-image">
        <img src="{{asset('dark/assets/images/home/houseimg.png')}}" class="image-size" />
      </div>

      <div class="banner-img-check">
        <div class="container home-style">
          <div class="padd-text-h1">
            <h1 class="h2-check-text">Welcome to HBD Library</h1>
          </div>
        <div class="banner-content">
          <div class="flex-cardsone">
            <div class="card-new" id="check-in"> 
              <div class="card-body">
                <div class="img-vect">
                  <image src="{{asset('dark/assets/images/home/iconone.png')}}" class="vect-img" /> 
                </div>
                <div class="img-content" id="check-out">
                  <h5 class="card-title">Check in</h5>
                  <image src="{{asset('dark/assets/images/home/arrow.png')}}" class="arrow-img" />  
                </div>
              </div>
            </div>
            <div class="card-new" id="check-out">
              <div class="card-body">
                <div class="img-vect">
                  <image src="{{asset('dark/assets/images/home/icontwo.png')}}" class="vect-img" />
                </div>
                <div class="img-content">
                  <h5 class="card-title">Check out</h5>
                  <image src="{{asset('dark/assets/images/home/arrow.png')}}" class="arrow-img" />
                </div>
              </div>
            </div>
          </div>
        </div>

          <section class="sec-2">
            <div class="card-2">
              <div class="card-body-check-2">
                <div>
                  <h3 class="text-h3">How to check-in/check-out Library's resources:</h3>
                  <ul class="ul-text">
                    <li class="li-text">
                      <span class="steps"> Step -1:</span>
                      Click 'check-out/check-in' to begin.
                    </li>
                    <li class="li-text">
                      <span class="steps"> Step -2:</span>
                      Key in your Staff ID number
                    </li>
                    <li class="li-text">
                      <span class="steps"> Step -3:</span>
                      Scan the books you would like to check-in/check-out one by one on the RFID pad
                    </li>
                    <li class="li-text">
                      <span class="steps"> Step -4:</span>
                      Check that all the books have been successfully scanned by the system and click check-out/check-in
                      to complete the check-in/check-out process
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </section>

          <div class="btn-parent">
            <div class="button-icon" style="cursor: pointer;" onclick="window.location.href='{{ env('ADMIN_LOGIN') }}'">
              <div class="img-center">
                <img src="{{asset('dark/assets/images/home/user.png')}}" class="img-user" />
                <h4 class="login-h4">login</h4>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="{{ asset('dark/assets/js/bootstrap.min.js')}}"></script>

    <script type="text/javascript">
      function ajaxStart(){ 
          $("body").css('pointer-events' ,'none');
          $(".loader").css('display','block');
          $(".load-bg").css('display','block');
      }
      function ajaxStop(){
          $("body").css('pointer-events' ,'auto');
          $(".loader").css('display','none');
          $(".load-bg").css('display','none');
      }
      $(window).load(function() {
              ajaxStart();
              ajaxStop();
      });
    $(document).ready(function() {
      $('.card-new').on('click', function() {
        ajaxStart();
        var type=$(this).attr('id');
        $.ajax({
              url: '{{ url('get-staff') }}', 
              type: 'GET', 
              dataType: 'json', 
              data: { 
                type: type
              },
              success: function(response) {
               $('.flex-cardsone').remove();
               $('.banner-content').html(response.data); 
              },
              error: function(xhr, status, error) {
                     ajaxStop();
                console.error('Error:', error);
              },
              beforeSend: function() {
                     ajaxStart();
              },
              complete: function() { 
                     ajaxStop();
              }
        });
      });
      $(document).on('click', '#verify-staff', function() {
        ajaxStart();
         $('#staffErr').html('');
         var type = $("input[name='type']").val(); 
         var staff_id = $("input[name='staff_id']").val();
         if(staff_id==""){
         $('#staffErr').append('Staff id field is required');
         ajaxStop();
         return; 
         } 
        $.ajax({
              url: '{{ url('verify-staff') }}', 
              type: 'POST', 
              dataType: 'json', 
              data: { 
                type: type,
                staff_id:staff_id,
                _token: '{{ csrf_token() }}'
              },
              success: function(response) {
              if(response.status==true){
               $('.flex-cardsone').remove();
               $('.card-staff-check').remove();
               $('.banner-content').html(response.data); 
              }else{
              $('#staffErr').append(response.err);
                ajaxStop();
                return; 
              }
              },
              error: function(xhr, status, error) {
                     ajaxStop();
                console.error('Error:', error);
              },
              beforeSend: function() {
                     ajaxStart();
              },
              complete: function() { 
                     ajaxStop();
              }
        });
      });
      $(document).on('input paste', '#scan-data', function() {
        ajaxStart();
         $('#itemErr').html('');
         var type = $("input[name='type']").val(); 
         var staff_id = $("input[name='staff_id']").val();
         var item_ref = $("input[name='item_ref']").val();
         if(item_ref==""){
         $('#itemErr').append('Item id field is required');
         ajaxStop();
         return; 
         } 
        $.ajax({
              url: '{{ url('check-item') }}', 
              type: 'POST', 
              dataType: 'json', 
              data: { 
                type: type,
                staff_id:staff_id,
                item_ref:item_ref,
                _token: '{{ csrf_token() }}'
              },
              success: function(response) {
              if(response.status==true){
                $('#itemErr').html('');
                 $('#item_data').html(''); 
                $('#item_data').html(response.data); 
              }else{
              $('#itemErr').append(response.err);
                ajaxStop();
                return; 
              }
              },
              error: function(xhr, status, error) {
                     ajaxStop();
                console.error('Error:', error);
              },
              beforeSend: function() {
                     ajaxStart();
              },
              complete: function() { 
                     ajaxStop();
              }
        });
      });
      $('#check-in').on('click', function() {
        ajaxStart();
         var type = $("input[name='type']").val(); 
         var staff_id = $("input[name='staff_id']").val();
         var check_in = $("input[name='check_in[]']").val();
        
        $.ajax({
              url: '{{ url('check-in') }}', 
              type: 'POST', 
              dataType: 'json', 
              data: { 
                type: type,
                staff_id:staff_id,
                check_in:check_in,
                _token: '{{ csrf_token() }}'
              },
              success: function(response) {
             
              },
              error: function(xhr, status, error) {
                     ajaxStop();
                console.error('Error:', error);
              },
              beforeSend: function() {
                     ajaxStart();
              },
              complete: function() { 
                     ajaxStop();
              }
        });
      });
    });
    </script>
  </body>
</html>
