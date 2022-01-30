@extends('layouts.app')

@section('content')
    <h1>Reservations</h1>
    <a href="/reservationadmin/create" class="btn btn-default pull-right">New Reservation</a>
    <br>
    <br>
    @if(count($reservation) > 0)
        @foreach($reservation as $reservations)
            <div class="well">
                <div class="row">
                    
                    <div class="col-md-8 col-sm-8">
                        <h3><a href="/reservationadmin/{{$reservations->id}}">{{date('j F, Y h:m:s A', strtotime($reservations->Start_Time))}}</a>
                         
                        <?php
                        date_default_timezone_set('Asia/Damascus');
                        $date = date('j F, Y h:m:s A');
                        ?>
        
                        @if($date > date('j F, Y h:m:s A', strtotime($reservations->Start_Time)))
                            ( The period of reservation is over )
                        @endif
                        </h3>
                        <small>Written on {{$reservations->created_at}} </small>
                        <br>
                        Reservation done by {{$reservations->user->First_Name}}  {{$reservations->user->Last_Name}}
                        <br>
                        @foreach($restaurant as $restaurants)
                            @if($reservations->restaurant_id == $restaurants->id )
                                for {{$restaurants->Name}} Restaurant 
                            @endif 
                        @endforeach                    
                    </div>
                </div>
            </div>
        @endforeach
        {{$reservation->links()}}
    @else
        <p>No reservations found</p>
    @endif
@endsection 