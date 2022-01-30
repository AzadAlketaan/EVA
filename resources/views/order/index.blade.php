@extends('layouts.master')

@section('content')
<section class="main-block light-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="styled-heading" >
                      <br>
                      <br>
                        <h3>My Orders</h3>
                        <a href="/order/create" class="btn btn-default pull-right">New Order</a>
                       <br>
                  </div>
                </div>
            </div>
        </div>
</section>
   
   
<section class="section bg-light pt-0 bottom-slant-gray">
                <div class="container">
                     <div class="row">
                 
    <br>
    @if(count($order) > 0)
        @foreach($order as $orders)

          
        <div class="col-md-12" style="text-align: center;margin-bottom:40px;" data-aos="fade-up" data-aos-delay="100">

                              
    
                        <div class="text"  style="text-align: center; padding: 16px;" >
                           <h3><a href="/order/{{$orders->id}}">{{$orders->Order}} ( {{$orders->Note}} )</a>       
                        </div>  

                       
                        <?php
                            date_default_timezone_set('Asia/Damascus');
                            $date = date('j F, Y h:m:s A');
                        ?>
                      <div style=" padding: 20px;" >


                        @if($date > date('j F, Y h:m:s A', strtotime($orders->Time)))
                            ( The period of order is over )
                        @endif                        
                    </h3>
                    <span><span class="fa fa-calendar"></span>Written on {{$orders->created_at}}</span>
                        <br>
                        @foreach($restaurant as $restaurants)
                            @if($orders->restaurant_id == $restaurants->id )
                            <span><span class="fa fa-calendar"></span>for {{$restaurants->Name}} Restaurant</span>
                            @endif 
                        @endforeach
                        <br>
                        @foreach($reservation as $reservations)
                            @if($orders->reservation_id == $reservations->id )
                            <span><span class="fa fa-calendar"></span>for reservation at: {{$reservations->Start_Time}}</span>
                            @endif 
                        @endforeach 
                        <br>
                        @foreach($address as $addresss)
                            @if($orders->address_id == $addresss->id )
                            <span><span class="fa fa-calendar"></span>Address: {{ $addresss->Address}}_{{ $addresss->Zone }}_{{ $addresss->Street}}</span>
                            @endif 
                        @endforeach
                
        @endforeach
   </div>

                       <div class="row" style='margin-bottom:100px;'>
                                       <div class="col-md-12" style="padding-left:40%; padding-top:30px;">     
                                       {{$order->links()}}
                                       </div>
                        </div>
       
    @else
        <p>No Orders found</p>
    @endif
    </div>
    </div>
               </section>
@endsection