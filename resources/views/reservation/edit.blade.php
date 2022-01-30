@extends('layouts.master')

@section('content')
    <h1>Edit Reservation</h1>
    {!! Form::open(['action' => ['App\Http\Controllers\ReservationController@update', $reservation->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('Start Time', 'Start Time')}}
            <input type="datetime-local" id="Start_Time" name="Start_Time" value = "{{date('Y-m-d\TH:i', strtotime($reservation->Start_Time))}}">
        </div>
        @if($reservation->End_Time != Null)
            <div class="form-group">
                {{Form::label('End Time', 'End Time')}}
                <input type="datetime-local" id="End_Time" name="End_Time" value = "{{date('Y-m-d\TH:i', strtotime($reservation->End_Time))}}">
            </div>
        @else
            <div class="form-group">
                {{Form::label('End Time', 'End Time')}}
                <input type="datetime-local" id="End_Time" name="End_Time">
            </div>
        @endif
        <div class="form-group">
            {{Form::label('Number_of_People', 'Number_of_People')}}
            {{Form::text('Number_of_People', $reservation->Number_of_People, ['class' => 'form-control', 'placeholder' => 'Number_of_People'])}}
        </div>
        <div class="form-group">
            {{Form::label('Table_Number', 'Table_Number')}}
            {{Form::text('Table_Number', $reservation->Table_Number, ['class' => 'form-control', 'placeholder' => 'Table_Number'])}}
        </div>
        
        <label for="restaurant_id">Choose restaurant:</label>
        <select name="restaurant_id" id="restaurant_id">
        @foreach($restaurant as $restaurants)
            @if($restaurants->id ==$reservation->restaurant_id)  
                <option value='{{ $restaurants->id }}' >{{ $restaurants->Name }} ( {{$restaurants->restauranttype->Type_Name}})</option>
            @endif
        @endforeach
        @foreach($restaurant as $restaurants)
            @if($restaurants->id != $reservation->restaurant_id)  
                <option value='{{ $restaurants->id }}' >{{ $restaurants->Name }} ( {{$restaurants->restauranttype->Type_Name}})</option>
            @endif
        @endforeach
        </select>
        <br>
        {{Form::hidden('_method','PUT')}}
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection