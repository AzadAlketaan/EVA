@extends('layouts.app')

@section('content')
    <h1>Edit Evaluation</h1>
    {!! Form::open(['action' => ['App\Http\Controllers\EvaluationAdminController@update', $evaluation->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <label for="user_id">Choose user:</label>
        <br>
        <select name="user_id" id="user_id">
            @foreach($user as $users)  
                @if($users->id == $evaluation->user_id)            
                    <option value='{{ $users->id }}' >{{ $users->First_Name }} {{$users->Last_Name}}</option> 
                @endif               
            @endforeach 
            @foreach($user as $users)              
                @if($users->id != $evaluation->user_id)            
                    <option value='{{ $users->id }}' >{{ $users->First_Name }} {{$users->Last_Name}}</option> 
                @endif 
            @endforeach 
        </select>
        <br>
        <label for="restaurant_id">Choose restaurant:</label>
        <br>
        <select name="restaurant_id" id="restaurant_id">
        @foreach($restaurant as $restaurants)
            @if($restaurants->id == $evaluation->restaurant_id)  
                <option value='{{ $restaurants->id }}' >{{ $restaurants->Name }} ( {{$restaurants->restauranttype->Type_Name}})</option>
            @endif
        @endforeach
        @foreach($restaurant as $restaurants)
            @if($restaurants->id != $evaluation->restaurant_id)  
                <option value='{{ $restaurants->id }}' >{{ $restaurants->Name }} ( {{$restaurants->restauranttype->Type_Name}})</option>
            @endif
        @endforeach
        </select>
        <br>
        <div class="form-group">
            {{Form::label('Price', 'Price')}}
            <br>
            <select name="Price" id="Price">
                <option value='' >Undifined</option>
                <option value='{{1}}' >Very Bad</option>
                <option value='{{2}}' >Bad</option>
                <option value='{{3}}' >Good</option>
                <option value='{{4}}' >Very Good</option>
                <option value='{{5}}' >Excellent</option>
            </select>
        </div> 
        <div class="form-group">
            {{Form::label('Cleanliness', 'Cleanliness')}}
            <br>
            <select name="Cleanliness" id="Cleanliness">
                <option value='' >Undifined</option>
                <option value='{{1}}' >Very Bad</option>
                <option value='{{2}}' >Bad</option>
                <option value='{{3}}' >Good</option>
                <option value='{{4}}' >Very Good</option>
                <option value='{{5}}' >Excellent</option>
            </select>
        </div>
        <div class="form-group">
            {{Form::label('Speed_of_Order_Arrival', 'Speed_of_Order_Arrival')}}
            <br>
            <select name="Speed_of_Order_Arrival" id="Speed_of_Order_Arrival">
                <option value='' >Undifined</option>
                <option value='{{1}}' >Very Bad</option>
                <option value='{{2}}' >Bad</option>
                <option value='{{3}}' >Good</option>
                <option value='{{4}}' >Very Good</option>
                <option value='{{5}}' >Excellent</option>
            </select>
        </div>

        <div class="form-group">
            {{Form::label('Food_Quality', 'Food_Quality')}}
            <br>
            <select name="Food_Quality" id="Food_Quality">
                <option value='' >Undifined</option>
                <option value='{{1}}' >Very Bad</option>
                <option value='{{2}}' >Bad</option>
                <option value='{{3}}' >Good</option>
                <option value='{{4}}' >Very Good</option>
                <option value='{{5}}' >Excellent</option>
            </select>
        </div>

        
        <div class="form-group">
            {{Form::label('Location_of_The_Place', 'Location_of_The_Place')}}
            <br>
            <select name="Location_of_The_Place" id="Location_of_The_Place">
                <option value='' >Undifined</option>
                <option value='{{1}}' >Very Bad</option>
                <option value='{{2}}' >Bad</option>
                <option value='{{3}}' >Good</option>
                <option value='{{4}}' >Very Good</option>
                <option value='{{5}}' >Excellent</option>
            </select>
        </div>

        <div class="form-group">
            {{Form::label('Treatment_of_Employees', 'Treatment_of_Employees')}}
            <br>
            <select name="Treatment_of_Employees" id="Treatment_of_Employees">
                <option value='' >Undifined</option>
                <option value='{{1}}' >Very Bad</option>
                <option value='{{2}}' >Bad</option>
                <option value='{{3}}' >Good</option>
                <option value='{{4}}' >Very Good</option>
                <option value='{{5}}' >Excellent</option>
            </select>
        </div>

        <div class="form-group">
            {{Form::label('Positives', 'Positives')}}
            {{Form::text('Positives', '', ['class' => 'form-control', 'placeholder' => 'Positives'])}}
        </div>
        <div class="form-group">
            {{Form::label('Negatives', 'Negatives')}}
            {{Form::text('Negatives', '', ['class' => 'form-control', 'placeholder' => 'Negatives'])}}
        </div>

        <div class="form-group">
            {{Form::label('Description', 'Description')}}
            {{Form::text('Description', $evaluation->Description, ['class' => 'form-control', 'placeholder' => 'Description'])}}
        </div>
        <div class="form-group">
            {{Form::label('Note', 'Note')}}
            {{Form::text('Note', $evaluation->Note, ['class' => 'form-control', 'placeholder' => 'Note'])}}
        </div>
        {{Form::hidden('_method','PUT')}}
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection