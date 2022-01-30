@extends('layouts.app')

@section('content')
    <h1>Evaluations</h1>
    <a href="/evaluationadmin/create" class="btn btn-default pull-right">New Evaluation</a>
    <br>
    <br>
    @if(count($evaluation) > 0)
        @foreach($evaluation as $evaluations)
            <div class="well">
                <div class="row">
                    <div class="col-md-8 col-sm-8">
                        Average of Evaluations on this restaurant:
                        <h3><a href="/evaluationadmin/{{$evaluations->id}}">
                        <?php
                        $average = collect([$evaluations->Price, $evaluations->Cleanliness,$evaluations->Speed_of_Order_Arrival,$evaluations->Food_Quality,$evaluations->Location_of_The_Place,$evaluations->Treatment_of_Employees])->avg();
                        $average = round($average);
                        ?>

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
                        </a></h3>
                        <small>Written on {{$evaluations->created_at}} <br> by {{$evaluations->user->First_Name}} {{$evaluations->user->Last_Name}} </small>
                        <br>
                        @foreach($restaurant as $restaurants)
                            @if($evaluations->restaurant_id == $restaurants->id )
                                <small>for {{$restaurants->Name}} Restaurant  </small>
                            @endif 
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
        {{$evaluation->links()}}
    @else
        <p>No Evaluations found</p>
    @endif
@endsection