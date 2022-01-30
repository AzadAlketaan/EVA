@extends('layouts.master')

@section('content')

<section class="main-block light-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="styled-heading">
                      <br>
                      <br>
                        <h3>My Reservations</h3>
                    <p class="mb-0">Enjoy the taste of choice</p>  
                    <br>
                    <a href="/reservation/create" class="btn btn-default pull-right">New Reservation</a>
                  </div>
                </div>
            </div>
          
        </div>
</section>


<section class="section bg-light pt-0 bottom-slant-gray">
                <div class="container">
                     <div class="row">    
    <br>
    <br>
    @if(count($reservation) > 0)
        @foreach($reservation as $reservations)

        <div class="col-md-12" data-aos="fade-up" data-aos-delay="100">
         
                    <div class="text"   style="text-align: center; padding: 16px;margin-bottom:0px;" >
                        <h3 ><a href="/reservation/{{$reservations->id}}">{{date('j F, Y h:m:s A', strtotime($reservations->Start_Time))}}</a></h3>
                           <p class="sched-time">
                              <span><span class="fa fa-calendar"></span>Written on {{$reservations->created_at}}</span> 
                           </p>
                     
                           
                        <?php
                        date_default_timezone_set('Asia/Damascus');
                        $date = date('j F, Y h:m:s A');
                        ?>

                        @if($date > date('j F, Y h:m:s A', strtotime($reservations->Start_Time)))
                            ( The period of reservation is over )
                        @endif
                        <br>
                        </h3>
                        <span><span  class="fa fa-calendar"></span>Written on {{$reservations->created_at}}</span> 
                        <br>
                        Reservation done by {{$reservations->user->First_Name}}  {{$reservations->user->Last_Name}}
                        <br>
                        @foreach($restaurant as $restaurants)
                            @if($reservations->restaurant_id == $restaurants->id )
                                for {{$restaurants->Name}} Restaurant 
                            @endif 
                        @endforeach         
                        <br>
                        @if(!Auth::guest())
                            @if(Gate::check('checkpermission','edit') )
                                <a href="/reservation/{{$reservations->id}}/edit" class="btn btn-default">Edit</a>
                            @endif
                                <a href="/order/create" class="btn btn-default">Add order to reservation</a>
                            @if( Gate::check('checkpermission' , 'destroy'))
                                {!!Form::open(['action' => ['App\Http\Controllers\ReservationController@destroy', $reservations->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                                {{Form::hidden('_method', 'DELETE')}}
                                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                                {!!Form::close()!!}
                            @endif      
                        @endif           
                        @endforeach
                    </div>
           
                </div> 
                </section>

              
        
        <div class="row" style="margin-bottom:100px;">
                                      <div class="col-md-6" >     
                                      {{$reservation->links()}}
                                      </div>
                                  </div>
    @else
        <p>No reservations found</p>
    @endif
 
@endsection 