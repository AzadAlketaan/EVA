@extends('layouts.master')

@section('content')
    <h1>Edit Drink Type</h1>
    {!! Form::open(['action' => ['App\Http\Controllers\DrinkTypeController@update', $drinktype->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    <div class="form-group">
            {{Form::label('Type_Name', 'Type Name')}}
            {{Form::text('Type_Name',  $drinktype->Type_Name, ['class' => 'form-control', 'placeholder' => 'Type_Name'])}}
        </div>
        <div class="form-group">
            {{Form::label('Arabic_Name', 'Arabic_Name')}}
            {{Form::text('Arabic_Name',  $drinktype->Arabic_Name, [ 'class' => 'form-control', 'placeholder' => 'Arabic_Name'])}}
        </div>
        <div class="form-group">
            {{Form::label('Description', 'Description')}}
            {{Form::text('Description',  $drinktype->Description, ['class' => 'form-control', 'placeholder' => 'Description'])}}
        </div>
        
        <div class="form-group">
            {{Form::file('type_image')}}
        </div>
        {{Form::hidden('_method','PUT')}}
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection