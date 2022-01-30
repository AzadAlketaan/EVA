@extends('layouts.master')

@section('content')   
  

@if(!Auth::guest() )
  @if(Gate::check('IsOwner') )

  <!----------------------->
  

  <section class="main-block light-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="styled-heading" >
                      <br>
                      <br>
                        <h3>My Restaurants</h3>
                        <a href="/restaurant/create" class="btn btn-default pull-right">New Restaurant</a>
                      <br>
                  </div>
                </div>
            </div>
        </div>
</section>


<br>
  <section class="section bg-light pt-0 bottom-slant-gray">
                        <div class="container">
                            <div class="row">
                        @if(count($userrestaurant) > 0)    
                            @foreach($userrestaurant as $userrestaurants)
                            
                            <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                                <div class="blog d-block" style="width:100%;">
                                  <img style="width:80%;  height:300px !important; padding: 15px;" href="single.html" src="/storage/restaurant_image/{{$userrestaurants->restaurant->restaurant_image}}">
                                 </div>

                                 <div class="text"   style=" padding:20px;" >
                                 <h3><a href="/restaurant/{{$userrestaurants->restaurant->id}}">{{$userrestaurants->restaurant->Name}}</a></h3>
                                        <p class="sched-time">
                                       <span><span class="fa fa-calendar"></span>Written on {{$userrestaurants->restaurant->created_at}}</span> 
                                        </p>
                                    </div>  
                                  
                                      <div style=" padding: 20px;" >
                                            @foreach($restauranttype as $restauranttypes)
                                                @if($userrestaurants->restaurant->restaurant_type_id == $restauranttypes->id )
                                                <span><span class="fa fa-calendar"></span>The Type of restaurant:<br> {{$restauranttypes->Type_Name}}</span>
                                                @endif 
                                            @endforeach
                                          
                                            
                    <span class="text-bold">
                        @php
                        $average_evaluation = \App\Http\Controllers\EvaluationController::average_evaluation($userrestaurants->restaurant);
                        @endphp
                        @if($average_evaluation == '')
                        <span><span class="fa fa-calendar"></span>No evaluation yet</span>
                         
                        @else
                            Evaluation: <br> {{$average_evaluation}}
                        @endif
                    </span>
                    <br> 
                    
                    <span><span class="fa fa-calendar"></span>Restaurant Address:</span>
                     @foreach($address as $addresss)
                            @if($addresss->restaurant_id == $userrestaurants->restaurant->id )
                            <span><span class="fa fa-calendar"></span>{{$addresss->Address}} {{$addresss->Zone}} {{$addresss->Street}}</span>
                            @endif 
                    @endforeach
                    <br>            
                    @if(!Auth::guest() )
                        @php
                            $evaluation = \App\Evaluation::where('restaurant_id' , '=' , $userrestaurants->restaurant->id)->get();
                        @endphp                        
                        @if($evaluation == '[]')
                        <span><span class="fa fa-calendar"></span>It has not been evaluated by any user</span>
                        @else
                        <span><span class="fa fa-calendar"></span>Evaluated by:<br></span>
                            @foreach($evaluation as $evaluations)       
                            <span><span class="fa fa-calendar"></span>{{$evaluations->user->First_Name}},</span>                              
                            @endforeach
                        @endif                        
                    @endif
                    </div> 
                    </div> 
                </div>
           
        @endforeach
    
   
        @else 
            <p>You don't have any Restaurants yet</p>
        @endif
    @endif 
</div>
  </section>
   
    <!------------------------->

    <section class="main-block light-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="styled-heading" >
                      <br>
                      <br>
                        <h3>Restaurants</h3>
                    <p class="mb-0">Enjoy the taste of choice</p>  
                    </div>
                </div>
            </div>
        </div>
    </section>

         <section class="section bg-light pt-0 bottom-slant-gray">
                <div class="container">
                     <div class="row">
                            @if(count($restaurant) > 0)
                
                            @foreach($restaurant as $restaurants)
                        
                            @if(!in_array($restaurants->id, $myrestaurants))

                <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                            <div class="blog d-block" style="width:100%;">
                               <img style="width:80%;  height:300px !important; padding: 15px;" href="single.html" src="/storage/restaurant_image/{{$restaurants->restaurant_image}}">
                            </div>

                      
                            <div class="text"   style=" padding:20px;" >
                                  <h3><a href="/restaurant/{{$restaurants->id}}">{{$restaurants->Name}}</a></h3>
                                   <p class="sched-time">
                                  <span><span class="fa fa-calendar"></span>Written on {{$restaurants->created_at}}</span> 
                                    </p>
                            </div>  

                            <div style=" padding: 20px;" >
                                @foreach($restauranttype as $restauranttypes)
                                    @if($restaurants->restaurant_type_id == $restauranttypes->id )
                                    <span><span class="fa fa-calendar" ></span>The Type of restaurant:<br> {{$restauranttypes->Type_Name}} <br> </span> 
                                    @endif 
                                @endforeach
                       

                                <span class="text-bold">
                                @php
                                $average_evaluation = \App\Http\Controllers\EvaluationController::average_evaluation($restaurants);
                                @endphp
                                @if($average_evaluation == '')
                        <span><span class="fa fa-calendar"></span>No evaluation yet</span>
                                @else
                                    Evaluation: <br>  {{$average_evaluation}}
                                @endif
                       </span>
                        <br> 
                                
                                 @foreach($address as $addresss)
                                   @if($addresss->restaurant_id == $restaurants->id )
                                      <span><span class="fa fa-calendar" ></span>Restaurant Address:<br> {{$addresss->Address}} {{$addresss->Zone}} {{$addresss->Street}}</span> 
                                   @endif 
                                @endforeach
                           
                               
                    @if(!Auth::guest() )
                        @php
                            $evaluation = \App\Evaluation::where('restaurant_id' , '=' , $restaurants->id)->get();
                        @endphp                        
                        @if($evaluation == '[]')

                            <span><span class="fa fa-calendar"></span>It has not been evaluated by any user</span> 
                        @else
                            <span><span class="fa fa-calendar"></span>Evaluated by:</span> 

                            @foreach($evaluation as $evaluations) 
                               <span><span class="fa fa-calendar"></span>{{$evaluations->user->First_Name}},</span>                    
                            @endforeach
                        @endif                        
                    @endif
               </div>    
                                </div>  
            @endif 
          
        @endforeach
                    </div>

     
                                   <div class="row" style='margin-bottom:100px;'>
                                       <div class="col-md-12" style="padding-left:40%; padding-top:30px;">     
                                       {{$restaurant->links()}}
                                       </div>
                                     </div>
     
   
        
    @else
    <p>No Restaurants found</p>

    @endif
    </div>
               </section>

 @else
    
<!-----------Restaurants-------------->
<section class="main-block light-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="styled-heading">
                      <br>
                      <br>
                        <h3>Our Restaurants</h3>
                    <p class="mb-0">Enjoy the taste of choice</p>  
                  </div>
                </div>
            </div>

            </div>
 </section>

         <section class="section bg-light pt-0 bottom-slant-gray">
                        <div class="container">
                            <div class="row">
                     @if(count($restaurant) > 0)
                     @foreach($restaurant as $restaurants)

                     <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                                <div class="blog d-block" style="width:100%;">
                                  <img style="width:80%;  height:300px !important; padding: 15px;" href="single.html"  src="/storage/restaurant_image/{{$restaurants->restaurant_image}}">
                                 </div>

                                 <div class="text"   style=" padding:20px;" >
                                 <h3><a href="/restaurant/{{$restaurants->id}}">{{$restaurants->Name}}</a></h3>
                                        <p class="sched-time">
                                       <span><span class="fa fa-calendar"></span>Written on {{$restaurants->created_at}}</span> 
                                        </p>
                                    </div>  
               
                
                 
                        <div style=" padding: 20px;" >
                        @foreach($restauranttype as $restauranttypes)
                            @if($restaurants->restaurant_type_id == $restauranttypes->id )
                            <span><span class="fa fa-calendar"></span>The Type of restaurant: <br>{{$restauranttypes->Type_Name}} <br> </span> 
                            @endif 
                        @endforeach
                
                    <span class="text-bold">
                        @php
                        $average_evaluation = \App\Http\Controllers\EvaluationController::average_evaluation($restaurants);
                        @endphp
                        @if($average_evaluation == '')
                        <span><span class="fa fa-calendar"></span>No evaluation yet<br></span> 
                        @else
                            Evaluation:<br>{{$average_evaluation}}
                        @endif
                    </span>  
                    <br> 
                 
                    @foreach($address as $addresss)
                            @if($addresss->restaurant_id == $restaurants->id )
                            <span><span class="fa fa-calendar"></span>Restaurant Address:<br> {{$addresss->Address}} {{$addresss->Zone}} {{$addresss->Street}}</span> 
                            @endif 
                        @endforeach

                                 
                      </div>
                    </div>      
                

        @endforeach
        </div>
           
    @else
        <p>No Restaurants found</p>
    @endif
    <div class="row"style="margin-bottom:100px;">
                <div class="col-md-6" style="padding-left: 40%; padding-top:20px;">     
                   {{$restaurant->links()}}
                </div>
            </div>

     </div>
            </section>
             
@endif
     
    
@endsection



