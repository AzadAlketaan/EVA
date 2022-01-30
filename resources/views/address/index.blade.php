@extends('layouts.master')

@section('content')   
<section class="main-block light-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="styled-heading">
                      <br>
                      <br>
                        <h3>My Addresses</h3> 
                  </div>
                </div>
            </div>
        </div>
</section>


   
    <section class="section bg-light pt-0 bottom-slant-gray">
                <div class="container">
                     <div class="row">
                        @if(count($myaddress) > 0)
                            @foreach($myaddress as $myaddresss)
           
                  <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="blog d-block" style="width:100%;">
                    <img style="width:80%;  height:300px !important; padding: 15px;" href="single.html" src="/storage/address_image/{{$myaddresss->address_image}}">
                    </div>


                    <div class="text"   style=" padding: 16px;margin-bottom:50px;" >
                    <h3><a href="/address/{{$myaddresss->id}}">{{$myaddresss->Address}}</a></h3>
                        <p class="sched-time">
                        <span><span class="fa fa-calendar"></span>Written on {{$myaddresss->created_at}}</span> 
                    </p>
                    </div>  
                    </div>  

                
                 
        @endforeach
        <div class="row" style="margin-bottom:100px;">
                                      <div class="col-md-6" >     
                                      {{$myaddress->links()}}
                                      </div>
                                  </div>
       
    @else
        <p>You do not have any addresses yet</p>
    @endif
    
    </div>
        </div>
    </section>

    @if(count($public_address) > 0)
    <section class="main-block light-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="styled-heading">
                      <br>
                      <br>
                        <h3>Public Addresses</h3>
                  </div>
                </div>
            </div>
        </div>
</section>


<section class="section bg-light pt-0 bottom-slant-gray">
                <div class="container">
                     <div class="row">
        @foreach($public_address as $public_addresss)
          
        <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="blog d-block" style="width:100%;">
                    <img style="width:80%;  height:300px !important; padding: 15px;" href="single.html" src="/storage/address_image/{{$public_addresss->address_image}}">
                    </div>

                    <div class="text"   style=" padding: 16px;margin-bottom:50px;" >
                    <h3><a href="/address/{{$public_addresss->id}}">{{$public_addresss->Address}} {{$public_addresss->Zone}} {{$public_addresss->Street}}</a></h3>
                        <p class="sched-time">
                        @if($public_addresss->user_id != Null)
                        <span><span class="fa fa-calendar"></span>Written on {{$public_addresss->created_at}} <br> by  {{$public_addresss->user->First_Name}} {{$public_addresss->user->Last_Name}}</span>
                        @else
                        <span><span class="fa fa-calendar"></span> by System</span> 
                        @endif
                    </p>
                    </div>  
                    </div>  
 
                
        @endforeach
    @else
        <p>No Addresses found</p>
    @endif
    </div>
        </div>
</section>



    @if(count($restaurant_address) > 0)

    <section class="main-block light-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="styled-heading">
                      <br>
                      <br>
                        <h3>Restaurant Addresses</h3>
                    <p class="mb-0">Enjoy the taste of choice</p>  
                  </div>
                </div>
            </div>
        </div>
</section>

<section class="section bg-light pt-0 bottom-slant-gray">
                <div class="container">
                     <div class="row" style='margin-bottom:100px;'>

        @foreach($restaurant_address as $restaurant_addresss)
           
        <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="blog d-block" style="width:100%;">
                    <img style="width:80%;  height:300px !important; padding: 15px;" href="single.html" src="/storage/address_image/{{$restaurant_addresss->address_image}}">
                    </div>

                    <div class="text"   style=" padding: 16px;margin-bottom:50px;" >
                    <h3><a href="/addressadmin/{{$restaurant_addresss->id}}">{{$restaurant_addresss->Address}} {{$restaurant_addresss->Zone}} {{$restaurant_addresss->Street}}</a></h3>
                        <p class="sched-time">
                        @if($restaurant_addresss->user_id != Null)
                        <span><span class="fa fa-calendar"></span>Written on {{$restaurant_addresss->created_at}} <br> by  {{$restaurant_addresss->user->First_Name}} {{$restaurant_addresss->user->Last_Name}}</span>          
                        @endif
                            <br>
                        @if($restaurant_addresss->restaurant_id != Null)
                        <span><span class="fa fa-calendar"></span>For  {{$restaurant_addresss->restaurant->Name}} ({{$restaurant_addresss->restaurant->Arabic_Name}}) Restaurant</span>                 
                        @endif
                      
                    </p>
                    </div>  
                    </div>  
                   
                  
        @endforeach
    @else
        <p>No Addresses found</p>
    @endif
    </div>
        </div>
</section>

@endsection