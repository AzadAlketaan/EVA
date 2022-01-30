@extends('layouts.master')

@section('content')
<section class="main-block light-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="styled-heading" >
                      <br>
                      <br>
                        <h3>My Evaluations</h3>
                        <a href="/evaluation/create" class="btn btn-default pull-right">New Evaluation</a>
    <br>
                  </div>
                </div>
            </div>
        </div>
</section>
    
    
    <br>

    <section class="section bg-light pt-0 bottom-slant-gray">
                <div class="container">
                     <div class="row">
    @if(count($evaluation) > 0)
        @foreach($evaluation as $evaluations)
           
                        <div class="text"   style=" padding:20px;" >
                            Average of Evaluations on this restaurant:
                             <h3><a href="/evaluation/{{$evaluations->id}}">
                         </div>  

                      
                       
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
                        <span><span class="fa fa-calendar"></span>Written on {{$evaluations->created_at}}</span> 
                      
                        <br>
                        @foreach($restaurant as $restaurants)
                            @if($evaluations->restaurant_id == $restaurants->id )
                            <span><span class="fa fa-calendar"></span>for {{$restaurants->Name}} Restaurant</span> 
                            @endif 
                        @endforeach
                    </div>
                </div>
            </section>
        @endforeach

        <div class="row" style='margin-bottom:100px;'>
                                       <div class="col-md-12" style="padding-left:40%; padding-top:40px;">     
                                       {{$evaluation->links()}}
                                       </div>
          </div>

      
    @else
        <p>No Evaluations found</p>
    @endif
@endsection