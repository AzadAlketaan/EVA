@extends('layouts.app')

@section('content')
    <a href="/reservationadmin" class="btn btn-default">Go Back</a>
    <h1>{{date('j F, Y', strtotime($reservation->Start_Time))}}
    <?php
        date_default_timezone_set('Asia/Damascus');
        $date = date('j F, Y h:m:s A');
    ?>

    @if($date > date('j F, Y h:m:s A', strtotime($reservation->Start_Time)))
        ( The period of reservation is over )
    @endif     
    </h1>
    <br><br>
    <div>
    @if($reservation->End_Time != Null)
        {{date('j F, Y', strtotime($reservation->End_Time))}}
    @else
        Undefined yet
    @endif
    </div>
    <hr>
    <small>Written on {{$reservation->created_at}} </small>
    <br>
    Reservation done by {{$reservation->user->First_Name}}  {{$reservation->user->Last_Name}}
    <br>
    <small>for {{$restaurant->Name}} restaurant</small>
    <hr>
    @if(!Auth::guest())
        @if(Gate::check('checkpermission','edit') )
            <a href="/reservationadmin/{{$reservation->id}}/edit" class="btn btn-default">Edit</a>
        @endif
        <a href="/orderadmin/create" class="btn btn-default">Add order to reservation</a>
        @if( Gate::check('checkpermission' , 'destroy'))
            {!!Form::open(['action' => ['App\Http\Controllers\ReservationAdminController@destroy', $reservation->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
            {!!Form::close()!!}
        @endif
      
    @endif
@endsection