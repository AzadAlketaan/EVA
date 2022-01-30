@extends('layouts.app')

@section('content')
    <h1> Average of Evaluations for {{$restaurant->Name}} ({{$restaurant->restauranttype->Type_Name}}):<br>
    @switch($average)
                            @case(1)
                                <span> Very Bad</span>
                            @break

                            @case(2)
                                <span>Bad</span>
                            @break

                            @case(3)
                                <span>Good</span>
                            @break

                            @case(4)
                                <span>Very Good</span>
                            @break

                            @case(5)
                                <span>Excellent</span>
                            @break

                            @default
                                <span>Undefined</span>
                        @endswitch
    </h1>
    <br><br>
    <div>
    Price:
     {!!$evaluation->Price!!}<br>
    Cleanliness:
        {!!$evaluation->Cleanliness!!}<br> 
    Speed_of_Order_Arrival:
        {!!$evaluation->Speed_of_Order_Arrival!!}<br>
    Food_Quality:
        {!!$evaluation->Food_Quality!!}<br>
    Location_of_The_Place:
        {!!$evaluation->Location_of_The_Place!!}<br>
    Treatment_of_Employees:
        {!!$evaluation->Treatment_of_Employees!!}<br>
    </div>
    <hr>
    <small>Written on {{$evaluation->created_at}} <br> by {{$evaluation->user->First_Name}} {{$evaluation->user->Last_Name}} </small>
    <br>
    <small>for {{$restaurant->Name}} restaurant</small>
    <hr>
    @if(!Auth::guest()) 
        @if(Gate::check('checkpermission','edit') )
            <a href="/evaluationadmin/{{$evaluation->id}}/edit" class="btn btn-default">Edit</a>
        @endif
        @if(Gate::check('checkpermission','destroy') )
            {!!Form::open(['action' => ['App\Http\Controllers\EvaluationAdminController@destroy', $evaluation->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
            {!!Form::close()!!}
        @endif
    @endif
@endsection