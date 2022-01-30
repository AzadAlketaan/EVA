@extends('layouts.master')

@section('content')
    <h1>New Evaluation</h1>
    {!! Form::open(['action' => 'App\Http\Controllers\EvaluationController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <label for="restaurant_id">Choose restaurant:</label>
        <br>
        <select name="restaurant_id" id="restaurant_id">
            @foreach($restaurant as $restaurants)
                <option value='{{ $restaurants->id }}' >{{ $restaurants->Name }} ( {{$restaurants->restauranttype->Type_Name}})</option>
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
            {{Form::text('Description', '', ['class' => 'form-control', 'placeholder' => 'Description'])}}
        </div>
        <div class="form-group">
            {{Form::label('Note', 'Note')}}
            {{Form::text('Note', '', ['class' => 'form-control', 'placeholder' => 'Note'])}}
        </div>

         
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection