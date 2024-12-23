<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cabin:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
   <link href="{{ asset('dark/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('dark/assets/css/style.css')}}" rel="stylesheet"/>
          <script src="{{ asset('dark/assets/js/bootstrap.min.js')}}"></script>
    <title>Hello, world!</title>
  </head>
  <body>
    <div class="header-image">
      <img src="{{ asset('dark/assets/images/home/houseimg.png')}}" class="image-size"/>
   </div>
        <div class="container-xxl">
          
             <div class="body-image">
                <div class="padd-text-h2">
                 <h1 class="h2-text">Welcome to HBD Library</h1>
                </div>
                 
                     <div class="container-xxl">
                        <div class="flex-cardsone">
                        <div class="card-new">
                          <div class="card-body">
                            <div class="img-vect">
                            <image src="{{ asset('dark/assets/images/home/iconone.png')}}" class="vect-img"/> 
                          </div>
                            <div class="img-content">
                             
                            <h5 class="card-title">Check in</h5>
                            <image src="{{ asset('dark/assets/images/home/arrow.png')}}" class="arrow-img"/> 
                          </div>
                        
                          </div>
                        </div>
                  
                   
                        <div class="card-new">
                          <div class="card-body">
                            <div class="img-vect">
                              <image src="{{ asset('dark/assets/images/home/icontwo.png')}}" class="vect-img"/> 
                              
                            </div>
                            <div class="img-content">
                             
                              <h5 class="card-title">Check out</h5>
                              <image src="{{ asset('dark/assets/images/home/arrow.png')}}" class="arrow-img"/> 
                            </div>
                          </div>
                        </div>
                      </div>
                      </div>
           <section class="sec-2">
            <div class="margin-index">
                            <div class="card-3">
                                <div class="card-body-2">
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
                                        Check that all the books have been successfully scanned by the system and click check-out/check-in to complete the check-in/check- out process
                                      </li>
                                    </ul>
                                  </div>
                                </div>
                       
                  </div>
                </div>
                </section>
                
             </div> 
          </div>

  </body>
</html>