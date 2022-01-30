@extends('layouts.app')

@section('content')
    <h1>New Food</h1>
    {!! Form::open(['action' => 'App\Http\Controllers\FoodAdminController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('Name', 'Name')}}
            {{Form::text('Name', '', ['class' => 'form-control', 'placeholder' => 'Name'])}}
        </div>
        <div class="form-group">
            {{Form::label('Arabic_Name', 'Arabic_Name')}}
            {{Form::text('Arabic_Name', '', ['class' => 'form-control', 'placeholder' => 'Arabic_Name'])}}
        </div>  
        <div class="form-group">
            {{Form::label('Price', 'Price')}}
            {{Form::text('Price', '', ['class' => 'form-control', 'placeholder' => 'Price'])}}
        </div>
        <div class="form-group">
            {{Form::label('Description', 'Description')}}
            {{Form::text('Description', '', ['class' => 'form-control', 'placeholder' => 'Description'])}}
        </div>
       
        <div class="form-group">
            {{Form::label('foodtype_id', 'Type of food:')}}
            <select name="foodtype_id" id="foodtype_id">
                <option value=''>select type</option>
                @foreach($foodtype as $foodtypes)
                    <option value='{{$foodtypes->id}}'> {{$foodtypes->Type_Name}} ({{$foodtypes->Arabic_Name}})</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            {{Form::file('food_image')}}
        </div>
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection