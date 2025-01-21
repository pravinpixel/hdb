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
  <div class="header-fixed">
  <div class="container-fluid">
   
   <div class="container home-style">
     <div class="header-image">
     <div class="container">
     <div class="row">
     <div class="col-md-6 col-sm-12">
   <img src="{{asset('dark/assets/images/home/houseimg.png')}}" class="image-size" />
   </div>
   <div class="col-md-6 col-sm-12">
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
            <!-- <h1 class="h2-check-text">Welcome to HDB Library</h1> -->
          </div>

       <div class="card-staff-check">
            <div class="card-body-3-final">
              <div class="thumbs-up">
                 <img src="{{asset('dark/assets/images/home/like.png')}}" alt="like" class="like-img"/>
              </div>
              <div class="padd-style-final-h2">
                <h1 class="h2-text">
                The books have been successfully checked in
                </h1>
              </div>
  
              <div class="btn-center-final">
              <button type="button" class="btn btn-color-new" onclick="window.location.href='{{ env('APP_URL') }}';">Back to Home</button>
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
                      Click check-out/check-in to begin
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
            <div class="button-icon" style="cursor: pointer;" onclick="window.location.href='{{ env('ADMIN_LOGIN') }}'">
              <div class="img-center">
                <img src="{{asset('dark/assets/images/home/user.png')}}" class="img-user" />
                <h4 class="login-h4">Admin  </br>  login</h4>
              </div>
            </div>
          </div>
        </div>
      </div>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="{{ asset('dark/assets/js/bootstrap.min.js')}}"></script>
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
        (function () {
    // Add a new state to the history
    history.pushState(null, null, location.href);

    // Listen for the popstate event
    window.onpopstate = function (event) {
        // Push the same state back to prevent navigation
        history.pushState(null, null, location.href);
    };

    // Disable keyboard shortcuts for back navigation (Alt+Left Arrow or Backspace)
    window.addEventListener("keydown", function (e) {
        // Check for Backspace (keyCode 8), Alt+Left Arrow (AltKey + keyCode 37)
        if (
            (e.key === "Backspace" && e.target.tagName !== "INPUT" && e.target.tagName !== "TEXTAREA") ||
            (e.altKey && e.key === "ArrowLeft")
        ) {
            e.preventDefault();
        }
    });
})();

    </script>
  </body>
</html>
