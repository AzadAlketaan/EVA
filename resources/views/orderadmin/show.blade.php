@extends('layouts.app')

@section('content')
    <a href="/orderadmin" class="btn btn-default">Go Back</a>
    <h1>{{$order->Order}}
    <?php
        date_default_timezone_set('Asia/Damascus');
        $date = date('j F, Y h:m:s A');
    ?>

    @if($date > date('j F, Y h:m:s A', strtotime($order->Time)))
        ( The period of order is over )
    @endif                        

    </h1>
    <br><br>
    <div>
        ({!!$order->Note!!})<br>
        Order time: {!!date('d/m/Y ( h: i: s A )', strtotime($order->Time))!!}
    </div>
    <hr>
    <small>Written on {{$order->created_at}}</small>
    <br>
    <small>for {{$restaurant->Name}} restaurant</small>
    <br> 
    @if($reservation != Null)
        <small>for reservation at: {{date('d/m/Y ( h: i: s A )', strtotime($reservation->Start_Time))}}</small>
        <br>
    @endif
    @if($address != Null)
        <small>Address: {{ $address->Address}}_{{ $address->Zone }}_{{ $address->Street}}</small>
    @endif
    <hr>
    @if(!Auth::guest())
        @if(Gate::check('checkpermission','edit') )
            <a href="/orderadmin/{{$order->id}}/edit" class="btn btn-default">Edit</a>
        @endif
        @if(Gate::check('checkpermission','destroy') )
            {!!Form::open(['action' => ['App\Http\Controllers\OrderAdminController@destroy', $order->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
            {!!Form::close()!!}
        @endif
    @endif
@endsection