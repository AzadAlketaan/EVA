@extends('layouts.master')

@section('content')
<section class="main-block light-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="styled-heading" >
                      <br>
                      <br>
                        <h3 style=" color:black;padding-top:20px;">{{$order->Order}}</h3>
              
                  </div>
                </div>
            </div>
        </div>
</section>

<section class="section bg-light pt-0 bottom-slant-gray" style="padding-bottom:120px;" >
                        <div class="container">
                            <div class="row">

                   <div class="text"   style=" padding: 16px;margin-bottom:50px;" >
                        <h3> 
                                <?php
                                    date_default_timezone_set('Asia/Damascus');
                                    $date = date('j F, Y h:m:s A');
                                ?>

                                @if($date > date('j F, Y h:m:s A', strtotime($order->Time)))
                                    ( The period of order is over )
                                @endif  
                         </h3>
                        
                    </div>  


            <div class="col-md-12" data-aos="fade-up" data-aos-delay="100">
                <h1>
                <?php
                    date_default_timezone_set('Asia/Damascus');
                    $date = date('j F, Y h:m:s A');
                ?>  
                </h1>    
            </div>
    <div>
        ({!!$order->Note!!})<br>
        Order time: {!!date('d/m/Y ( h: i: s A )', strtotime($order->Time))!!}
        <br>
        for {{$restaurant->Name}} restaurant
        <br> 
    @if($reservation != Null)
        for reservation at: {{date('d/m/Y ( h: i: s A )', strtotime($reservation->Start_Time))}}
        <br>
    @endif
    @if($address != Null)
        Address: {{ $address->Address}}_{{ $address->Zone }}_{{ $address->Street}}
    @endif
<br>

    <span><span class="fa fa-calendar"></span>Created on {{$order->created_at}}</span> 
   
    </div>
    <hr>
   
    <hr>
    @if(!Auth::guest())
        @if(Gate::check('checkpermission','edit') )
            <a href="/order/{{$order->id}}/edit" class="btn btn-default">Edit</a>
        @endif
        @if(Gate::check('checkpermission','destroy') )
            {!!Form::open(['action' => ['App\Http\Controllers\OrderController@destroy', $order->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
            {!!Form::close()!!}
        @endif
    @endif
   
    </div>
        </div>
  </section>

@endsection