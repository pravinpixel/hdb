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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
 
  </head>
  <body>
    <div class="load-bg">
      <div class="loader"></div>
    </div>
    <div class="header-fixed">
    <div class="container-fluid">
   
    <div class="container home-style">
      <div class="header-image">
      <div class="container">
      <div class="row">
    <div class="col">
    <img src="{{asset('dark/assets/images/home/houseimg.png')}}" class="image-size" />
    </div>
    <div class="col">
      <div class="header-new">
    <h6 class="powered">Powered by</h6>
    

     <img src="{{asset('dark/assets/images/home/pack.png')}}" class="image-size-pack" />
     <img src="{{asset('dark/assets/images/home/line.png')}}" class="image-size-line" />
        <img src="{{asset('dark/assets/images/home/track.png')}}" class="image-size-track" />
</div>
    </div>
    </div>
  </div>
  </div>
</div>
      </div>
    </div>
      <div class="banner-img-check">
        <div class='home-sections'>
        <div class="container home-style">
          <div class="padd-text-h1">
            <h1 class="h2-check-text" id="display-heading">Welcome to HDB Library</h1>
          </div>
        <div class="banner-content">
          <div class="flex-cardsone">
            <div class="card-new" id="check-in"> 
              <div class="card-body">
                 <div class="img-vect">
                  <image src="{{asset('dark/assets/images/home/imgup.png')}}" class="vect-img" /> 
                </div>
                <div class="img-content" id="check-out">
                  <h5 class="card-title">Check-Out (Borrow)</h5>
                </div> 
              </div> 
            </div>
            <div class="card-new" id="check-out">
              <div class="card-body">
                <div class="img-vect">
                <image src="{{asset('dark/assets/images/home/imgd.png')}}" class="vect-img" /> 
                </div>
                <div class="img-content">
                  <h5 class="card-title">Check-In (Return)</h5>
                </div>
              </div>
            </div>
          </div>
        </div>

          <section class="sec-2">
            <div class="card-2">
              <div class="card-body-check-2">
                <div>
                  <h3 class="text-h3">How to check-out / check-in Library's resources:</h3>
                  <ul class="ul-text">
                    <li class="li-text">
                      <span class="steps"> Step 1:</span>
                      Click check-out/check-in to begin.
                    </li>
                    <li class="li-text">
                      <span class="steps"> Step 2:</span>
                      Key in your Staff ID number
                    </li>
                    <li class="li-text">
                      <span class="steps"> Step 3:</span>
                      Scan the books you would like to check-out / check-in one by one on the RFID pad
                    </li>
                    <li class="li-text">
                      <span class="steps"> Step 4:</span>
                      Check that all the books have been successfully scanned by the system and click confirm to complete the process
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </section>

          <div class="btn-parent">
           <div class="button-icon" style="cursor: pointer;" onclick="window.open('{{ env('ADMIN_LOGIN') }}', '_blank')">
              <div class="img-center">
                <img src="{{asset('dark/assets/images/home/user.png')}}" class="img-user" />
                <h4 class="login-h4"> Admin </br> login</h4>
              </div>
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
       function deleteCheckout(checkoutId) {
        ajaxStart();
         var type = $("input[name='type']").val(); 
         var staff_id = $("input[name='staff_id']").val();
          $.ajax({
                url: '{{ url('item-delete') }}', 
                type: 'POST', 
                dataType: 'json', 
                data: { 
                  type: type,
                  staff_id:staff_id,
                  checkoutId:checkoutId,
                  _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                $('#item_data').html(''); 
                $('#item_data').html(response.data); 
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
      }
     var selectedCheckouts = [];
      function unsetCheckout(checkoutId) {
          ajaxStart();
          selectedCheckouts.push(checkoutId);
          console.log(selectedCheckouts);

          var type = $("input[name='type']").val(); 
          var staff_id = $("input[name='staff_id']").val();
          
          $.ajax({
              url: '{{ url('item-unset') }}', 
              type: 'POST', 
              dataType: 'json', 
              data: { 
                  type: type,
                  staff_id: staff_id,
                  checkoutId: selectedCheckouts,
                  _token: '{{ csrf_token() }}'
              },
              success: function(response) {
                  $('.banner-content').html('');
                  $('.banner-content').html(response.data);
                  if (Array.isArray(response.checkoutId)) {
                      response.checkoutId.forEach(function(id) {
                          selectedCheckouts.push(id);
                      });
                  }
              console.log('Updated selectedCheckouts:', selectedCheckouts);
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
      }
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
               $('#display-heading').hide();
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
         $('#staffErr').append('The staff ID field is required.');
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
         $('#itemErr').append('The Book ID field is required.');
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
              $("input[name='item_ref']").val('');
                 $('#itemErr').html('');
                 $('#item_data').html(''); 
                 $('#item_data').html(response.data); 
              }else{
              $('#itemErr').html('');
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
      $(document).on('click', '#taken', function() {
        ajaxStart();
         $('#itemErr').html('');
         var type = $("input[name='type']").val(); 
         var staff_id = $("input[name='staff_id']").val();
         var check_in = $("input[name='check_in']").val();
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
              if(response.status==true){
              window.location.href = response.redirect_to;
              }else{
              $('#itemErr').html('');
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
       $(document).on('click', '#return', function() {
        ajaxStart();
         var type = $("input[name='type']").val(); 
         var staff_id = $("input[name='staff_id']").val();
         var check_in = $("input[name='check_in']").val();
        $.ajax({
              url: '{{ url('check-out') }}', 
              type: 'POST', 
              dataType: 'json', 
              data: { 
                type: type,
                staff_id:staff_id,
                check_out:check_in,
                _token: '{{ csrf_token() }}'
              },
              success: function(response) {
              window.location.href = response.redirect_to;
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
       $(document).on('click', '#clear_function', function() {
        ajaxStart();
         var type = $("input[name='type']").val(); 
         var staff_id = $("input[name='staff_id']").val();
         var check_in = $("input[name='check_in']").val();
        $.ajax({
              url: '{{ url('check-out-clear') }}', 
              type: 'POST', 
              dataType: 'json', 
              data: { 
                type: type,
                staff_id:staff_id,
                check_out:check_in,
                _token: '{{ csrf_token() }}'
              },
              success: function(response) {
              window.location.href = response.redirect_to;
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
  <script>
        // Disable left and right arrow keys
        document.addEventListener('keydown', function(event) {
            if (event.key === "ArrowLeft" || event.key === "ArrowRight") {
                event.preventDefault();
            }
            // Disable F12 and Ctrl+Shift+I for developer tools
            if (event.key === "F12" || (event.ctrlKey && event.shiftKey && event.key === "I")) {
                event.preventDefault();
            }
            if (event.ctrlKey && event.shiftKey && event.key === "C") {
                event.preventDefault();
            }
            if (event.ctrlKey && event.key === "u") {
                event.preventDefault();
            }
        });

        // Disable right-click (context menu)
        document.addEventListener('contextmenu', function(event) {
            event.preventDefault();
        });

        // Additional precautionary method to disable "Inspect Element" via key combo
        document.addEventListener('keydown', function(event) {
            // Disable Ctrl+Shift+I and F12 to prevent DevTools shortcuts
            if (event.key === 'F12' || (event.ctrlKey && event.shiftKey && event.key === 'I')) {
                event.preventDefault();
            }
            if (event.ctrlKey && event.shiftKey && event.key === "C") {
                event.preventDefault();
            }
            if (event.ctrlKey && event.key === "u") {
                event.preventDefault();
            }
        });

        // Alert the user if they attempt to open DevTools via a console log (as a final check)
        (function() {
            var devtools = /./;
            devtools.toString = function () {
                alert("Developer Tools are disabled!");
            };
        })();
    </script>
  </body>
</html>
