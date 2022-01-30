@extends('layouts.master')

@section('content')
<section class="main-block light-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="styled-heading" >
                      <br>
                      <br>
                        <h3 style=" color:black;padding-top:20px;"> {{$restaurant->Name}} ( {{$restaurant->Arabic_Name}} )</h3>
                      <h4 style=" color:#4199c5;padding-top:15px;"> {!!$restaurant->Status!!}</h4>
                  </div>
                </div>
            </div>
        </div>
</section>

<section class="section bg-light pt-0 bottom-slant-gray" style="" >
                        <div class="container">
                            <div class="row">
 
     <div class="col-md-12" data-aos="fade-up" data-aos-delay="100">

    @php
        $average_evaluation = \App\Http\Controllers\EvaluationController::average_evaluation($restaurant);
    @endphp
    @if($average_evaluation == 'Undefined')
        <h3>{!!$restaurant->Recommended_Evaluation!!}</h3>
        <br>
    @else
    <br>
        <h3> Evaluation:
             {{$average_evaluation}}</h3>
    @endif                
    <br>

                   <div class="blog d-block" style="width:100%;">
                      <img style="width:100%;  height:300px !important; padding: 15px;" href="single.html" src="/storage/restaurant_image/{{$restaurant->restaurant_image}}">
                   </div>

    <br><br>
    
    <div style="text-align: center;">
    Open At: {{$restaurant->Time_Open}} , Close At: {{$restaurant->Time_Close}}
    </div>

    
    <div style="text-align: center;">
         Phone: {!!$restaurant->Phone_Number1!!}
    @if($restaurant->Delivery_Service == 1)
    <br>
         Delivery Service: Available
    <br> 
        @else
            Delivery Service: Not Available
        @endif
    </div>


    <div style="text-align: center;">
          @if($restaurant->Reservation_Service == 1)
            ReservationService: Available
            <br> 
          @else
            Reservation Service: Not Available
            <br> 
          @endif
    </div>
   
    <div style="text-align: center;">
    @if($restaurant->Description != Null)                  
            Description: {{$restaurant->Description}}
              @endif 
    </div>

    <div style="text-align: center;">
    Restaurant Address:
       @foreach($address as $addresss)
                @if($addresss->restaurant_id == $restaurant->id )
                {{$addresss->Address}} {{$addresss->Zone}} {{$addresss->Street}}
                @endif 
            @endforeach  
    </div> 
    <hr>


    @foreach($userrestaurant as $userrestaurants)
        @foreach($user as $users)
            @if($users->id == $userrestaurants->user_id)
            <div style="text-align: center;">
            The Owners of the restaurant: {{$users->First_Name}}  {{$users->Last_Name}}
            </div> 
            @endif
        @endforeach
    @endforeach      

    <div style="text-align: center;">
    Created on {{$restaurant->created_at}}
    </div> 

    <div style="text-align: center;">
    The Type of restaurant: {{$restauranttype->Type_Name}}
    </div> 

    <hr>

    @if(!Auth::guest())
        @if(Gate::check('IsOwner') and Gate::check('IsMyRestaurant' , $restaurant->id ))
            @if(Gate::check('checkpermission','edit') )

            <button type="submit" class="btn btn-default pull-right" style="margin-right: 10px; padding: 6px; background: #3e434b;">
                        <a style="color: white;" href="/restaurant/{{$restaurant->id}}/edit" >Edit</a> 
            </button>    
            @endif

            <button type="submit" class="btn btn-default pull-right" style="margin-left: 160px; padding: 6px; background: #3e434b;">
                        <a style="color: white;" href="/reservation/create" >Add Reservation</a> 
            </button>  


            <button type="submit" class="btn btn-default pull-right" style="margin-left: 160px; padding: 6px; background: #3e434b;">
                        <a style="color: white;" href="/evaluation/create" >Add Evaluation</a> 
            </button>  

            <button type="submit" class="btn btn-default pull-right" style="margin-left: 160px; padding: 6px; background: #3e434b;">
                        <a style="color: white;" href="/order/create" >Add Order</a> 
            </button>  

            <button type="submit" class="btn btn-default pull-right" style="margin-left: 160px; padding: 6px; background: #3e434b;">
                        <a style="color: white;" href="/drinkrestaurant" >Assign Drinks</a> 
            </button>  

            <button type="submit" class="btn btn-default pull-right" style="margin-left: 160px; padding: 6px; background: #3e434b;">
                        <a style="color: white;" href="/foodrestaurant" >Assign foods</a> 
            </button>         

            @if(Gate::check('checkpermission' , 'destroy'))
            {!!Form::open(['action' => ['App\Http\Controllers\RestaurantController@destroy', $restaurant->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
            {!!Form::close()!!}
            @endif
        
        @endif
    @endif

    <div style="text-align: center;">
    <h3>Foods && Drinks in the Restaurant:</h3>
    </div> 

<table class="table table-sm" style="margin-bottom:100px;">
    <thead>
        <tr>
            <th>Foods && Drinks</th>
        </tr>
    </thead>
    <tbody>     
         
        @foreach($foodrestaurant as $foodrestaurants)        
        <tr>
     
            @foreach($food as $foods) 
                @if($foods->id == $foodrestaurants->Food_ID )   
                
                <td>
                     {{$foods->Name}}                    
                </td>

            <td style="text-align:right">                                         
              <button type="submit" class="btn btn-default pull-right" style="margin-left: 160px; padding: 6px; background: #3e434b;">
                <a style="color: white;" href="/food/{{$foods->id}}" >Show</a> 
              </button>  
            </td>                    
                @endif
                @endforeach       
        </tr>
        @endforeach


        @foreach($drinkrestaurant as $drinkrestaurants)
        <tr>
        
             @foreach($drink as $drinks) 
             @if($drinks->id == $drinkrestaurants->Drink_ID )   
                <td>
                {{$drinks->Name}}                
                </td>
               
                <td style="text-align:right">
                 <button type="submit" class="btn btn-default pull-right" style="margin-left: 160px; padding: 6px; background: #3e434b;">
                        <a style="color: white;" href="/drink/{{$drinks->id}}" >Show</a> 
                  </button>    
                  </td>
            @endif
        @endforeach
    
    
        </tr>
        @endforeach
        
    </tbody>
</table>


           </div>
        </div>
  </section>

@endsection