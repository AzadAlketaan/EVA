@extends('layouts.app')

@section('content')
    <h1>New Restaurant</h1>
    {!! Form::open(['action' => 'App\Http\Controllers\RestaurantAdminController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    <div class="form-group">
            {{Form::label('Name', 'Name')}}
            {{Form::text('Name', '', ['class' => 'form-control', 'placeholder' => 'Name'])}}
        </div>
        <div class="form-group">
            {{Form::label('Arabic_Name', 'Arabic_Name')}}
            {{Form::text('Arabic_Name', '', ['class' => 'form-control', 'placeholder' => 'Arabic_Name'])}}
        </div>
        <div class="form-group">
            {{Form::label('Phone_Number1', 'Phone_Number1')}}
            {{Form::text('Phone_Number1', '', ['class' => 'form-control', 'placeholder' => 'Phone_Number1'])}}
        </div>
        <div class="form-group">
            {{Form::label('Phone_Number2', 'Phone_Number2')}}
            {{Form::text('Phone_Number2', '', ['class' => 'form-control', 'placeholder' => 'Phone_Number2'])}}
        </div>
        <div class="form-group">
            {{Form::label('Phone_Number3', 'Phone_Number3')}}
            {{Form::text('Phone_Number3', '', ['class' => 'form-control', 'placeholder' => 'Phone_Number3'])}}
        </div>
        <div class="form-group">
            {{Form::label('Status', 'Status')}}
            {{Form::text('Status', '', ['class' => 'form-control', 'placeholder' => 'Status'])}}
        </div>
        <div class="form-group">
            {{Form::label('Time_Open', 'Time_Open')}}
            <input type="time" id="Time_Open" name="Time_Open">
        </div>
        <div class="form-group">
            {{Form::label('Time Close', 'Time Close')}}
            <input type="time" id="Time_Close" name="Time_Close">
        </div>
        <div class="form-group">
            {{Form::label('Delivery_Service', 'Delivery_Service')}}
            <select name="Delivery_Service" id="Delivery_Service">
                <option value='{{1}}' >Yes</option>
                <option value='{{0}}' >No</option>
            </select>        
        </div> 

        <div class="form-group">
            {{Form::label('Reservation_Service', 'Reservation_Service')}}
            <select name="Reservation_Service" id="Reservation_Service">
                <option value='{{1}}' >Yes</option>
                <option value='{{0}}' >No</option>
            </select>
        </div>

        <div class="form-group">
            {{Form::label('Note', 'Note')}}
            {{Form::text('Note', '', ['class' => 'form-control', 'placeholder' => 'Note'])}}
        </div>
        
        <div class="form-group">
            {{Form::label('Description', 'Description')}}
            {{Form::text('Description', '', ['class' => 'form-control', 'placeholder' => 'Description'])}}
        </div>

         
        <label for="restaurant_type_id">Choose type of restaurant:</label>
        <select name="restaurant_type_id" id="restaurant_type_id">
            @foreach($restauranttype as $restauranttypes)
                <option value='{{ $restauranttypes->id }}' >{{ $restauranttypes->Type_Name }}</option>
            @endforeach
        </select>
        <br>
        <br>
        <div class="form-group">
            {{Form::file('restaurant_image')}}
        </div>
        <br>
        <label>Restaurant address:</label>
        <div class="form-group">
            {{Form::label('address', 'City')}}
            {{Form::text('address', '', ['class' => 'form-control', 'placeholder' => 'City'])}}
        </div>
        <div class="form-group">
            {{Form::label('zone', 'Zone')}}
            {{Form::text('zone', '', [ 'class' => 'form-control', 'placeholder' => 'Zone'])}}
        </div>

        <div class="form-group">
            {{Form::label('street', 'Street')}}
            {{Form::text('street', '', [ 'class' => 'form-control', 'placeholder' => 'Street'])}}
        </div>

        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection