@extends('layouts.master')

@section('content')
    <h1>Edit Food</h1>
    {!! Form::open(['action' => ['App\Http\Controllers\FoodController@update', $food->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    <div class="form-group">
            {{Form::label('Name', 'Name')}}
            {{Form::text('Name', $food->Name, ['class' => 'form-control', 'placeholder' => 'Name'])}}
        </div>
        <div class="form-group">
            {{Form::label('Arabic_Name', 'Arabic_Name')}}
            {{Form::text('Arabic_Name', $food->Arabic_Name, ['class' => 'form-control', 'placeholder' => 'Arabic_Name'])}}
        </div>  
        <div class="form-group">
            {{Form::label('Price', 'Price')}}
            {{Form::text('Price', $food->Price, ['class' => 'form-control', 'placeholder' => 'Price'])}}
        </div>
        <div class="form-group">
            {{Form::label('Description', 'Description')}}
            {{Form::text('Description', $food->Description, ['class' => 'form-control', 'placeholder' => 'Description'])}}
        </div>

        <label for="foodtype_id">Choose type of food:</label>
        <select name="foodtype_id" id="foodtype_id">
        @foreach($foodtype as $foodtypes)
            @if($foodtypes->id ==$food->foodtype_id)  
                <option value='{{ $food->foodtype_id }}' >{{ $foodtypes->Type_Name }}</option>
            @endif
        @endforeach
        @foreach($foodtype as $foodtypes)
            @if($foodtypes->id != $food->foodtype_id)  
                <option value='{{ $foodtypes->id }}' >{{ $foodtypes->Type_Name }}</option>
            @endif
        @endforeach
        </select>

        <div class="form-group">
            {{Form::file('food_image')}}
        </div>
        {{Form::hidden('_method','PUT')}}
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection