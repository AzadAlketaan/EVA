@extends('layouts.master')

@section('content')

 <!-- SLIDER -->
 <section class="slider d-flex align-items-center" style=" opacity:0.9;">
    
        <div class="container">
                  <!--    <div class="blog d-block">
                         <img style="width:13%;  height:150px !important;margin-top:-150px !important;" href="single.html" src="images/logo.png">
                      </div>
                -->
            <div class="row d-flex justify-content-center">
                <div class="col-md-12">

                     
                    <div class="slider-title_box">

                                   <!-- Search Form -->
                        <div class="form-search-wrap" data-aos="fade-up" data-aos-delay="200">
                            <form action="/search" method="POST" role="search">
                            <div class="slider-content_wrap" style="padding:10px;" >
                            <h1 style="color:#383b3f;font-weight: bold;">Welcome To Eva Web Site!</h1>
                                    <h5 style="color:#383b3f;">Make your experience better</h5>
                                    </div>
                            {{ csrf_field() }}           

                                <div class="row align-items-center">

                                    <div class="col-lg-12 mb-4 mb-xl-0 col-xl-6">
                                        <div class="wrap-icon">
                                        @if($searchrestaurant != '')
                                            <input type="text" class="form-control" name="search" id = 'search' value="{{$searchrestaurant}}" >
                                        @else
                                            <input type="text" class="form-control" name="search" id = 'search' value="" placeholder="Search for a specific restaurant">
                                        @endif                    
                                    </div>
                                                    
                                </div>

                                <div class="col-lg-12 mb-4 mb-xl-0 col-xl-3">
                                        <div class="select-wrap">
                                            <select class="custom-select{{ $errors->has('restauranttype_id') ? ' is-invalid' : '' }}" id="restauranttype_id" name="restauranttype_id" >
                       
                                                @if($search_restauranttype != '')      
                                                    <option value="{{$searchrestauranttype}}" selected>{{$search_restauranttype}}</option>                                        
                                                    @foreach($restauranttype as $restauranttypes)
                                                        @if($restauranttypes->id != $searchrestauranttype )
                                                            <option value="{{ $restauranttypes->id }}">{{ $restauranttypes->Type_Name }} ({{ $restauranttypes->Arabic_Name }})</option>
                                                        @endif
                                                    @endforeach
                                                @else
                                                
                                                    <option value="" selected>Search by type of restaurant</option>
                                                    @foreach($restauranttype as $restauranttypes)
                                                        <option value="{{ $restauranttypes->id }}">{{ $restauranttypes->Type_Name }} ({{ $restauranttypes->Arabic_Name }})</option>
                                                    @endforeach
                                                @endif

                                            </select>
                                            @if($errors->has('restauranttype_id'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('restauranttype_id') }}
                                            </div>
                                            @endif
                                        </div>
                                </div>
                
                                <div class="col-lg-12 mb-4 mb-xl-0 col-xl-3">
                                        <div class="select-wrap">
                                            <select class="custom-select{{ $errors->has('zone_id') ? ' is-invalid' : '' }}" id="zone_id" name="zone_id" >
                                                @if($search_zone != '')                
                                                    <option value="{{$searchzone}}" selected>{{$search_zone}}</option>
                                                    @foreach($address as $addresss)
                                                        @if($addresss->restaurant_id == '0' )
                                                            @if("$addresss->Address $addresss->Zone $addresss->Street" != $search_zone )
                                                                <option value="{{ $addresss->Address }}/{{ $addresss->Zone }}|{{ $addresss->Street }}*">{{ $addresss->Address }} {{ $addresss->Zone }} {{ $addresss->Street }}</option>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                @else
                                                    <option value="" selected>Search in an area</option>
                                                    @foreach($address as $addresss)
                                                        @if($addresss->restaurant_id == '0' )
                                                            <option value="{{ $addresss->Address }}/{{ $addresss->Zone }}|{{ $addresss->Street }}*">{{ $addresss->Address }} {{ $addresss->Zone }} {{ $addresss->Street }}</option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>
                                            @if($errors->has('zone_id'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('zone_id') }}
                                            </div>
                                            @endif
                                        </div>
                                </div>
                
                    
                    </div>

<!-- cheack box-->
<fieldset>
<div class="col-lg-12 ">
        <br>
                <label><h3>Choose filters and search again:</h3></label><br>             
                
                @foreach($filters as $filters)
                    @foreach($filterarr as $filterarrs)                        
                                @switch($filters) 
                                    @case('Speed_of_Order_Arrival')
                                        <?php  $filternmae = 'Speed' ?>
                                    @break
                                    @case('Food_Quality')
                                        <?php  $filternmae = 'Quality of foods and drinks' ?>
                                    @break
                                    @case('Location_of_The_Place')
                                        <?php  $filternmae = 'Location' ?>
                                    @break
                                    @case('Treatment_of_Employees')
                                        <?php  $filternmae = 'Treatment' ?>
                                    @break

                                    @default
                                        <?php  $filternmae = $filters ?>
                                @endswitch    
                        <?php  $i = 0?>
                        
                        @if($filterarrs != NULL)                          
                            @if(in_array($filters , $filterarr[$i]))                                     
                                <input type="checkbox" name="filterarray[]"  value="{{$filters}}" checked>    {{$filternmae}}               
                            @else 
                                <input type="checkbox" name="filterarray[]" value="{{$filters}}">    {{$filternmae}}               
                            @endif 
                        @else
                            <input type="checkbox" name="filterarray[]" value="{{$filters}}"> {{$filternmae}}               
                        @endif 
                        <?php $i++; ?>
                    @endforeach
                @endforeach
               </div>

            </fieldset> 
              <!-- End cheack box-->

              <div class="col-lg-12" style="padding:10px;">
                    
                    <button  onclick="getLocation()" name="locationbtn" id="locationbtn" value = "1" class="btn btn-default"style="background: #3e434b;color: white;">Find Nearest Restaurants</button>
                    <button type="submit" class="btn btn-default"style="background: #3e434b;color: white;">
                        <span class="glyphicon glyphicon-search">search</span>
                    </button>
              </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--//END Search Form --> 
        

         
    
        

       
<!-------------------------------------------------------------------------------->

<div class="container">

<!-- search by restaurant name only or with restaurant name and type  -->
    @if($searchrestaurant != '' and $addressrestaurant == '') 
        @if(count($restaurant) > 0 )
            @if($search_restauranttype != '')
            <br>
            <br>
                <h2 style="color:#333;font-weight: 400;text-align: center;">The Search results for  <b> "{{ $searchrestaurant }}" </b> restaurant and  <b> "{{ $search_restauranttype }}" </b> type are :</h2>     
            @else
            <br>
            <br>
                <h2 style="color:#333;font-weight: 400;text-align: center;">The Search results for  <b> "{{ $searchrestaurant }}" </b> restaurant are :</h2> 
            @endif

        <br>

        <section class="section bg-light pt-0 bottom-slant-gray">
                        <div class="container">
                            <div class="row"style="margin-bottom:100px;">
            @foreach($restaurant as $restaurants)

                             <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                                <div class="blog d-block" style="width:100%;">
                                  <img style="width:80%;  height:300px !important; padding: 15px;" href="single.html" src="/storage/restaurant_image/{{$restaurants->restaurant_image}}">
                                 </div>

                                 <div class="text"   style=" padding:20px;" >
                                 <h3><a href="/restaurant/{{$restaurants->id}}">{{$restaurants->Name}}</a></h3>
                                        <p class="sched-time">
                                        </p>
                                    </div>  
                  
                         <div style=" padding: 20px;" >
                            @foreach($address as $addresss)
                                    @if($restaurants->id == $addresss->restaurant_id  )
                                        <span><span class="fa fa-calendar"></span>ِAddress: {{$addresss->Address}} / {{$addresss->Zone}} / {{$addresss->Street}} ( {{$addresss->Description}} )</span> <br>
                                    @endif
                                @endforeach
                        
                        @foreach($restauranttype as $restauranttypes)
                            @if($restaurants->restaurant_type_id == $restauranttypes->id )
                            <span><span class="fa fa-calendar"></span>The Type of restaurant:   {{$restauranttypes->Type_Name}} <br> </span> 
                            @endif 
                        @endforeach
                      
                   


                    <span class="text-bold">
                        @php
                        $average_evaluation = \App\Http\Controllers\EvaluationController::average_evaluation($restaurants);
                        @endphp
                        @if($average_evaluation == '')
                        <span><span class="fa fa-calendar"></span>No evaluation yet</span>
                        @else
                            Evaluation:   {{$average_evaluation}}
                        @endif
                    </span>
                    <br> 
                    @if(!Auth::guest() )
                        @php
                            $evaluation = \App\Models\Evaluation::where('restaurant_id' , '=' , $restaurants->id)->get();
                        @endphp                        
                        @if($evaluation == '[]')
                        <span><span class="fa fa-calendar"></span>It has not been rated by any user</span>
                        @else
                        <span><span class="fa fa-calendar"></span>Evaluated by: <br> </span>                      
                            @foreach($evaluation as $evaluations)  
                            <span><span class="fa fa-calendar"></span>{{$evaluations->user->First_Name}}, </span>                  
                            @endforeach
                        @endif                       
                    @endif     

                    </div>      
           </div>
                    

        @endforeach
       
                 

        @elseif(isset($message))
        <br>
        <h2>{{ $message }}</h2>
        @endif  
        </div>
        </div>
    </section>
                <br>         
    
                <br>

<!-- End of search by restaurant name only -->

<!-- search by address only -->
    @elseif( $searchrestaurant == '' and $addressrestaurant != '') 
    <h1> sajvashv </h1>
        @if(count($addressrestaurant) > 0 )
            @if($search_restauranttype != '')
            <br>
            <br>
                <h2  style="color:#333;font-weight: 400;    text-align: center;">The Search results for  <b> "{{ $search_zone }}" </b> area and  <b> "{{ $search_restauranttype }}" </b> type are :</h2>     
            @else
            <br>
            <br>
            <h2  style="color:#333;font-weight: 400;    text-align: center;">The Search results for <b> "{{ $search_zone }}" </b> area are :</h2>
            @endif
        
        <br>
        <section class="section bg-light pt-0 bottom-slant-gray">
                        <div class="container">
                            <div class="row"style="margin-bottom:100px;">
        @foreach($addressrestaurant as $addressrestaurants)      
            @php
                $address_restaurant = \App\Models\Address::where('id' , '=' , $addressrestaurants->id)->get();
            @endphp          
            @foreach($address_restaurant as $address_restaurants)
            <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                                <div class="blog d-block" style="width:100%;">
                                  <img style="width:80%;  height:300px !important; padding: 15px;" href="single.html" src="/storage/restaurant_image/{{$address_restaurants->restaurant['restaurant_image']}}">
                                 </div>
                       
                                 <div class="text"   style=" padding:20px;" >
                                 <h3><a href="/restaurant/{{$address_restaurants->restaurant['id']}}">{{$address_restaurants->restaurant['Name']}}</a></h3>
        
                                    </div>  
                                
                                    <div style=" padding: 20px;" >
                                    
                        <span><span class="fa fa-calendar"></span>ِAddress: {{$address_restaurants->Address}} / {{$address_restaurants->Zone}} / {{$address_restaurants->Street}} ( {{$address_restaurants->Description}} )</span> <br>
                        @foreach($restauranttype as $restauranttypes)
                            @if($address_restaurants->restaurant['restaurant_type_id'] == $restauranttypes->id )
                            <span><span class="fa fa-calendar"></span>The Type of restaurant: {{$restauranttypes->Type_Name}}</span> 
                            @endif 
                        @endforeach  
                                 <br>
                    <span class="text-bold">
                        @php
                        $average_evaluation = \App\Http\Controllers\EvaluationController::average_evaluation($address_restaurants->restaurant);
                        @endphp
                        @if($average_evaluation == '')
                        <span><span class="fa fa-calendar"></span>No evaluation yet</span> 
                         
                        @else
                            Evaluation: {{$average_evaluation}}
                        @endif
                    </span>
                    <br> 
                    @if(!Auth::guest() )
                        @php
                            $evaluation = \App\Models\Evaluation::where('restaurant_id' , '=' , $address_restaurants->restaurant['id'])->get();
                        @endphp                        
                        @if($evaluation == '[]')
                        <span><span class="fa fa-calendar"></span>It has not been evaluated by any user</span> 
                            
                        @else
                        <span><span class="fa fa-calendar"></span></span> 
                            Evaluated by:                         
                            @foreach($evaluation as $evaluations)          
                            <span><span class="fa fa-calendar"></span>{{$evaluations->user->First_Name}},</span>                          
                            @endforeach
                        @endif                        
                    @endif   
                    </div>           
                        </div>
                  
            @endforeach
        @endforeach    
                   
              

        @elseif(isset($message))
            <br>
        <h2>{{ $message }}</h2>
        @endif 
        </div>
    </div>
               </section>


<!-- End of search by address only -->   
 

<!-- search by restaurant name and address  or  restaurant name and address and restaurant type-->
               
    @elseif( $searchrestaurant != '' and $addressrestaurant != '')
        @if(count($addressrestaurant) > 0 )
            @if($search_restauranttype != '')
            <br>
            <br>
                <h2 style="color:#333;font-weight: 400;    text-align: center;">The Search results for  <b> "{{ $searchrestaurant }}" </b> restaurant in  <b>"{{ $search_zone }}" </b>area and  <b> "{{ $search_restauranttype }}" </b> type are :</h2>     
            @else
            <br>
            <br>
                <h2 style="color:#333;font-weight: 400;    text-align: center;">The Search results for <b> "{{ $searchrestaurant }}" </b> restaurant in  <b>"{{ $search_zone }}" </b>area are :</h2>
            @endif
            
        <br>
        <section class="section bg-light pt-0 bottom-slant-gray">
                        <div class="container">
                            <div class="row" style="margin-bottom:100px;">
                        @foreach($addressrestaurant as $addressrestaurants)
                            @php
                                $address_restaurant = \App\Models\Address::where('id' , '=' , $addressrestaurants->id)->get();
                            @endphp
                                @foreach($address_restaurant as $address_restaurants)
            
                                <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                                <div class="blog d-block" style="width:100%;">
                                  <img style="width:80%;  height:300px !important; padding: 15px;" href="single.html" src="/storage/restaurant_image/{{$address_restaurants->restaurant->restaurant_image}}">
                                 </div>

                                 <div class="text"   style=" padding:20px;" >
                                 <h3><a href="/restaurant/{{$address_restaurants->restaurant->id}}">{{$address_restaurants->restaurant->Name}}</a></h3>                    
                                    </div>                                     
                        
                        <span><span class="fa fa-calendar"></span>ِAddress: {{$address_restaurants->Address}} / {{$address_restaurants->Zone}} / {{$address_restaurants->Street}} ( {{$address_restaurants->Description}} )</span> <br>                                               
                        @foreach($restauranttype as $restauranttypes)
                            @if($address_restaurants->restaurant->restaurant_type_id == $restauranttypes->id )
                            <span><span class="fa fa-calendar"></span>The Type of restaurant: {{$restauranttypes->Type_Name}}</span> 
            
                            @endif 
                        @endforeach                    
                 <br>
                    <span class="text-bold">
                        @php
                        $average_evaluation = \App\Http\Controllers\EvaluationController::average_evaluation($address_restaurants->restaurant);
                        @endphp
                        @if($average_evaluation == '')
                        <span><span class="fa fa-calendar"></span>No evaluation yet</span> 
        
                        @else
                            Evaluation:  {{$average_evaluation}}
                        @endif
                    </span>
                    <br> 

                    @if(!Auth::guest() )
                        @php
                            $evaluation = \App\Models\Evaluation::where('restaurant_id' , '=' , $address_restaurants->restaurant->id)->get();
                        @endphp                        
                        @if($evaluation == '[]')
                        <span><span class="fa fa-calendar"></span>It has not been rated by any user</span> 
          
                        @else
                        <span><span class="fa fa-calendar"></span>Evaluated by:<br> </span> 
                                           
                            @foreach($evaluation as $evaluations) 
                            <span><span class="fa fa-calendar"></span>{{$evaluations->user->First_Name}},</span>                    
                             
                            @endforeach
                        @endif                        
                    @endif      
                 
           
                @endforeach         
            
            </div>            
            @endforeach
                  </div>

        @elseif(isset($message))
        <br>
        <h2>{{ $message }}</h2>
        @endif    
                </div>
             </div>
         </section>
  <!-- End of search by restaurant name and address -->
 
<!-- search by restaurant type only -->

@elseif($searchrestaurant == '' and $addressrestaurant == '' and $search_restauranttype != '') 
        @if(count($restaurant) > 0 )
        <br>
            <br>
        <h2 style="color:#333;font-weight: 400;    text-align: center;">The Search results for  <b> "{{ $search_restauranttype }}" </b> type are :</h2>     
        <br>

        <section class="section bg-light pt-0 bottom-slant-gray">
                        <div class="container">
                            <div class="row" style="margin-bottom:100px;">
                       @foreach($restaurant as $restaurants)
          

                       <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                                <div class="blog d-block" style="width:100%;">
                                  <img style="width:80%;  height:300px !important; padding: 15px;" href="single.html" src="/storage/restaurant_image/{{$restaurants->restaurant_image}}">
                                 </div>
                       
                                 <div class="text"   style=" padding:20px;" >
                                 <h3><a href="/restaurant/{{$restaurants->id}}">{{$restaurants->Name}}</a></h3>
                                    </div>  

                                   
                                    <div style=" padding: 20px;" >
                        @foreach($address as $addresss)
                            @if($restaurants->id == $addresss->restaurant_id  )
                                <span><span class="fa fa-calendar"></span>ِAddress: {{$addresss->Address}} / {{$addresss->Zone}} / {{$addresss->Street}} ( {{$addresss->Description}} )</span> <br>
                            @endif
                        @endforeach
                        
                        @foreach($restauranttype as $restauranttypes)
                            @if($restaurants->restaurant_type_id == $restauranttypes->id )
                            <span><span class="fa fa-calendar"></span>The Type of restaurant:  {{$restauranttypes->Type_Name}} </span>
                            @endif 
                        @endforeach
                    <br>

                    <span class="text-bold">
                        @php
                        $average_evaluation = \App\Http\Controllers\EvaluationController::average_evaluation($restaurants);
                        @endphp
                        @if($average_evaluation == '')
                        <span><span class="fa fa-calendar"></span>No evaluation yet</span>
                        
                        @else
                            Evaluation: {{$average_evaluation}}
                        @endif
                    </span>
                    <br> 
                    @if(!Auth::guest() )
                        @php
                            $evaluation = \App\Models\Evaluation::where('restaurant_id' , '=' , $restaurants->id)->get();
                        @endphp                        
                        @if($evaluation == '[]')
                        <span><span class="fa fa-calendar"></span>It has not been rated by any user</span>
                        
                        @else
                        <span><span class="fa fa-calendar"></span>Evaluated by: <br> </span>
                                            
                            @foreach($evaluation as $evaluations)     
                            <span><span class="fa fa-calendar"></span>{{$evaluations->user->First_Name}},</span>               
                 
                            @endforeach
                        @endif                        
                    @endif      
                     
                          </div>
                        </div>
                        @endforeach
                    </div>
        
                      </div>
                  </div>
               </section>
        @elseif(isset($message))
        <br>
        <h2>{{ $message }}</h2>
        @endif  
                <br>         
    
                <br>
                
<!-- End of search by restaurant type only -->
    @elseif(isset($message))
    <br>
    <h2>{{ $message }}</h2>
    @endif          

    </div>
         </section>



</div>

@endsection

