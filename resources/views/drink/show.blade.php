@extends('layouts.master')

@section('content')

<section class="main-block light-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="styled-heading" >
                      <br>
                      <br>
                        <h3>{{$drink->Name}}</h3>
                      
                  </div>
                </div>
            </div>
        </div>
</section>

<section class="section bg-light pt-0 bottom-slant-gray">
                        <div class="container">
                            <div class="row">

               <div class="col-md-12" data-aos="fade-up" data-aos-delay="100">
                   <div class="blog d-block" style="width:100%;">
                      <img style="width:100%;  height:300px !important; padding: 15px;" href="single.html" src="/storage/drink_image/{{$drink->drink_image}}">
                   </div>
  
   
                   <br><br>
    <div style="text-align: center;">
        {!!$drink->Name!!}
    </div>
    <hr>

    <div style="text-align: center;">
    Written on {{$drink->created_at}}
    </div>

    <div style="text-align: center;">
    The Type of drink: {{$drinktype->Type_Name}}
    </div> 


    <hr>

   <div style="text-align: center;">
    <h3>Drink available in this Restaurants:</h3>
<div style="padding-bottom:100px; ">
<table class="table table-sm" >
    <thead>
        <tr>
            <th style="text-align: center;">Restaurant </th>            
        </tr>
    </thead>
    <tbody>  
 
    @foreach($drinkrestaurant as $drinkrestaurants)  
        <tr> 
        <td>
        
            @foreach($restaurant as $restaurants) 
                @if($restaurants->id == $drinkrestaurants->Restaurant_ID )   
                     {{$restaurants->Name}} ({{$restaurants->Arabic_Name}})                    
                @endif
            @endforeach
     
        </td>
        </tr>
        @endforeach
    </tbody>
</table>
          </div>
      </div>
   </div>
</section>
@endsection