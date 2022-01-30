@extends('layouts.app')

@section('content')
    <h1>New Reservation</h1>
    {!! Form::open(['action' => 'App\Http\Controllers\ReservationAdminController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('Start Time', 'Start Time')}}
            <input type="datetime-local" id="Start_Time" name="Start_Time">
        </div> 
        <div class="form-group">
            {{Form::label('End Time', 'End Time')}}
            <input type="datetime-local" id="End_Time" name="End_Time">
        </div>
        <div class="form-group">
            {{Form::label('Number_of_People', 'Number_of_People')}}
            {{Form::text('Number_of_People', '', ['class' => 'form-control', 'placeholder' => 'Number_of_People'])}}
        </div>
        <div class="form-group">
            {{Form::label('Table Number', 'Table Number')}}
            {{Form::text('Table_Number', '', ['class' => 'form-control', 'placeholder' => 'Table_Number'])}}
        </div>

        <label for="user_id">Choose user:</label>
        <select name="user_id" id="user_id">
            @foreach($user as $users)
                <option value='{{ $users->id }}' >{{ $users->First_Name }} {{$users->Last_Name}}</option>
            @endforeach
        </select>
        <br>

        <label for="restaurant_id">Choose restaurant:</label>
        <select name="restaurant_id" id="restaurant_id">
            @foreach($restaurant as $restaurants)
                <option value='{{ $restaurants->id }}' >{{ $restaurants->Name }} ( {{$restaurants->restauranttype->Type_Name}})</option>
            @endforeach
        </select>
        <br>
                       
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection