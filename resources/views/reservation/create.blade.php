@extends('layouts.master')

@section('content')

<section class="main-block light-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="styled-heading">
                      <br>
                      <br>
                        <h3>New Reservation</h3>
                  </div>
                </div>
            </div>
        </div>
</section>

    
<section class="section bg-light pt-0 bottom-slant-gray">
                <div class="container">
                     <div class="row"  style="margin-bottom:100px;">


             {!! Form::open(['action' => 'App\Http\Controllers\ReservationController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
              <div class="col-md-12">
                  <label class="text-black control-label" style="margin-bottom: 0; padding-top: 10px;">Start Time</label> 
                  <input type="datetime-local" id="Start_Time" class="form-control" name="Start_Time" value="" required autofocus>
              </div>


              <div class="col-md-12 ">
                  <label class="text-black control-label" style="margin-bottom: 0; padding-top: 10px;" >End Time</label> 
                  <input type="datetime-local" id="End_Time" class="form-control" name="End_Time" value="" required autofocus>
              </div>

      
              <div class="col-md-12">
                  <label class="text-black control-label"style="margin-bottom: 0; padding-top: 10px;" >Number_of_People</label> 
                  <input type="text" id="Number_of_People" class="form-control" name="Number_of_People" value="" required autofocus>
              </div>

              <div class="col-md-12">
                  <label class="text-black control-label"style="margin-bottom: 0; padding-top: 10px;" >Table Number</label> 
                  <input type="text" id="Table Number" class="form-control" name="Table Number" value="" required autofocus>
              </div>
        
 
              <div class="col-md-12 ">
                  <label class="text-black control-label" style="margin-bottom:10px; padding-top: 20px;" for="restaurant_id">Choose restaurant:</label> 
                  <select name="restaurant_id" id="restaurant_id">
                        @foreach($restaurant as $restaurants)
                        <option value='{{ $restaurants->id }}' >{{ $restaurants->Name }} ( {{$restaurants->restauranttype->Type_Name}})</option>
                        @endforeach
                  </select>
        <br>
                       
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}

   
            </div>
        </div>
    </section>
@endsection