@extends('layouts.app')

@section('content')
<h1>Orders</h1>
    <a href="/orderadmin/create" class="btn btn-default pull-right">New Order</a>
    <br>
    <br>
    @if(count($order) > 0)
        @foreach($order as $orders)
            <div class="well">
                <div class="row">
                    <div class="col-md-8 col-sm-8">
                    <h3><a href="/orderadmin/{{$orders->id}}">{{$orders->Order}} ( {{$orders->Note}} )</a>
                        <?php
                            date_default_timezone_set('Asia/Damascus');
                            $date = date('j F, Y h:m:s A');
                        ?>
 
                        @if($date > date('j F, Y h:m:s A', strtotime($orders->Time)))
                            ( The period of order is over )
                        @endif                        
                    </h3>
                        <small>Written on {{$orders->created_at}}</small>
                        <br>
                        @foreach($user as $users)
                            @if($orders->user_id == $users->id )
                                <small>the order for: {{$users->First_Name}} {{$users->Last_Name}}  </small>
                            @endif 
                        @endforeach
                        <br>
                        @foreach($restaurant as $restaurants)
                            @if($orders->restaurant_id == $restaurants->id )
                                <small>for {{$restaurants->Name}} Restaurant  </small>
                            @endif 
                        @endforeach
                        <br>
                        @foreach($reservation as $reservations)
                            @if($orders->reservation_id == $reservations->id )
                                <small>for reservation at: {{$reservations->Start_Time}}   </small>
                            @endif 
                        @endforeach 
                        <br>
                        @foreach($address as $addresss)
                            @if($orders->address_id == $addresss->id )
                                <small>Address: {{ $addresss->Address}}_{{ $addresss->Zone }}_{{ $addresss->Street}} </small>
                            @endif 
                        @endforeach
                    </div>
                </div>
            </div> 
        @endforeach
        {{$order->links()}}
    @else
        <p>No Orders found</p>
    @endif
@endsection