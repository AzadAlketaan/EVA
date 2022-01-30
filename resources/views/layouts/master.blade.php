<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Colorlib">
    <meta name="description" content="#">
    <meta name="keywords" content="#">
     
    <!-- Favicons -->
     <link rel="shortcut icon" href="#">
    <!-- Page Title -->
    <title>EVA</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500,700,900" rel="stylesheet">
    <!-- Simple line Icon -->
    <link rel="stylesheet" href="{{ asset('css/simple-line-icons.css') }}">
    <!-- Themify Icon -->
    <link rel="stylesheet" href="{{ asset('css/themify-icons.css') }}">
    <!-- Hover Effects -->
    <link rel="stylesheet" href="{{ asset('css/set1.css') }}">
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

   
    <link rel="stylesheet" href=" {{ asset('fonts/icomoon/style.css') }}">

    <link rel="stylesheet" href=" {{ asset('css/magnific-popup.css') }}">
    <link rel="stylesheet" href=" {{ asset('css/jquery-ui.css') }}">
    <link rel="stylesheet" href=" {{ asset('css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href=" {{ asset('css/owl.theme.default.min.css') }}">

    <link rel="stylesheet" href=" {{ asset('css/bootstrap-datepicker.css') }}">

    <link rel="stylesheet" href=" {{ asset('fonts/flaticon/font/flaticon.css') }}">

    <link rel="stylesheet" href=" {{ asset('css/aos.css') }}">
    <link rel="stylesheet" href=" {{ asset('css/rangeslider.css') }}">

 
</head>

<body>
    <!--============================= HEADER =============================-->
    <div class="nav-menu" >
        <div class="bg transition" >
            <div class="container-fluid fixed" >
                <div class="row" >
                    <div class="col-md-12" >

                        <nav  class="navbar navbar-expand-lg navbar-light">
                          <a class="navbar-brand" href="{{ url('/') }}">
                            {{ config('app.name', 'EVA') }} </a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="icon-menu"></span>
              </button>

              <div class="collapse navbar-collapse justify-content-end" id="app-navbar-collapse">
        
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                &nbsp;
            </ul>

            <ul class="nav navbar-nav">             
            
              <li class="nav-item active">
                    <a class="nav-link" href="/about">About</a>
               </li>
              
               <li class="nav-item active">
                    <a class="nav-link" href="/restauranttype">Restaurants Types</a>
               </li>

               <li class="nav-item active">
                    <a class="nav-link" href="/restaurant">Restaurants</a>
               </li>

               <li class="nav-item active">
                    <a class="nav-link" href="/drink">Drinks</a>
               </li>

               <li class="nav-item active">
                    <a class="nav-link" href="/food">Foods</a>
               </li>
                            
            
              @if (!Auth::guest())

              <li class="nav-item active">
                    <a class="nav-link" href="/reservation">My Reservations</a>
               </li>

               <li class="nav-item active">
                    <a class="nav-link" href="/order">My Orders</a>
               </li>

               <li class="nav-item active">
                    <a class="nav-link" href="/address">My Addresses</a>
               </li>

               <li class="nav-item active">
                    <a class="nav-link" href="/evaluation">My Evaluations</a>
               </li>

                @if(Gate::check('IsAdmin'))
                <li class="nav-item active">
                    <a class="nav-link"href="/cpanal">Cpanal</a>
               </li>
                
                @endif 
              @endif         
                   
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('login') }}">Sign in</a>
               </li>

               <li class="nav-item active">
                    <a class="nav-link" href="{{ route('register') }}">Sign up</a>
               </li>

                                
                @else
                
                    <li class="dropdown" class="dropdown-menu pull-left" role="menu" style="padding:10px; color:#4199c5;">
                        <a href="#" class="dropdown-toggle" style="color: #f8f9fa;padding-right: 35px;" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu" style="padding:10px; background-color: #f8f9fa; color:#4199c5;">
                            <li style="color:#4199c5;">
                                <a href="/profile">Profile</a></li>

                            @if(Gate::check('IsOwner') )
                            <li class="nav-item active" style="color:#4199c5;">
                              <a class="nav-link" href="/drinktype">Drink Types</a>
                            </li>

                            <li class="nav-item active" style="color:#4199c5;">
                                    <a class="nav-link" href="/foodtype">Food Types</a>
                            </li>
                                                              
                            @endif
                            <li>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                              document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>


                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="master">
       
            @include('inc.messages')
            @yield('content')
    
    </div>

    
    <!--//END ADD LISTING -->
    <!--============================= FOOTER =============================-->
    <footer class="main-block dark-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="copyright">
                       <p>Copyright &copy; All rights reserved | Azad Alketaan <i class="ti-heart" aria-hidden="true"></i> </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--//END FOOTER -->




    <!-- jQuery, Bootstrap JS. -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

  <script src="{{ asset('js/jquery-migrate-3.0.1.min.js') }}"></script>
  <script src="{{ asset('js/jquery-ui.js') }}"></script>

  

  <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
  <script src="{{ asset('js/jquery.stellar.min.js') }}"></script>
  <script src="{{ asset('js/jquery.countdown.min.js') }}"></script>
  <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
  <script src="{{ asset('js/aos.js') }}"></script>
  <script src="{{ asset('js/rangeslider.min.js') }}"></script>

  <script src="{{ asset('js/main.js') }}"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  
   
  <script>
        $(window).scroll(function() {
            // 100 = The point you would like to fade the nav in.

 
                $('.fixed').removeClass('is-sticky');

        
        });
    </script>

  <!--  <script>
        $(window).scroll(function() {
            // 100 = The point you would like to fade the nav in.

           if ($(window).scrollTop() > 100) {

                $('.fixed').addClass('is-sticky');

            } else {
 
                $('.fixed').removeClass('is-sticky');

            };
        });
    </script>
   -->

<script>
        $(".map-icon").click(function() {
            $(".map-fix").toggle();
        });
    </script>
   
<script>
   $(document).ready(function(){
    // Check Radio-box

    $price = document.getElementById("Price");
    $Cleanliness = document.getElementById("Cleanliness");
    $Speed_of_Order_Arrival = document.getElementById("Speed_of_Order_Arrival");
    $Food_Quality = document.getElementById("Food_Quality");
    $Location_of_The_Place = document.getElementById("Location_of_The_Place");
    $Treatment_of_Employees = document.getElementById("Treatment_of_Employees");
    $(".rating input:radio").attr("checked", false);

    $('.rating input').click(function () {
        $(".rating span").removeClass('checked');
        $(this).parent().addClass('checked');
    });

    $('input:radio').change(
      function(){
        var userRating = this.value;
        alert(userRating);
    }); 
});
</script>
</body>

</html>
