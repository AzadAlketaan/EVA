@extends('layouts.master')

@section('content')
<section class="main-block light-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="styled-heading" >
                      <br>
                      <br>
                        <h3>Average of Evaluations for {{$restaurant->Name}} ({{$restaurant->restauranttype->Type_Name}}):</h3>
                      
                  </div>
                </div>
            </div>
        </div>
</section>
    <h1> <br>
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
    <small>Written on {{$evaluation->created_at}} </small>
    <br>
    <small>for {{$restaurant->Name}} restaurant</small>
    <hr>
    @if(!Auth::guest()) 
        @if(Gate::check('checkpermission','edit') )
            <a href="/evaluation/{{$evaluation->id}}/edit" class="btn btn-default">Edit</a>
        @endif
        @if(Gate::check('checkpermission','destroy') )
            {!!Form::open(['action' => ['App\Http\Controllers\EvaluationController@destroy', $evaluation->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
            {!!Form::close()!!}
        @endif
    @endif
@endsection