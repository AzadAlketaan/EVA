@extends('layouts.master')

@section('content')
    <h1>Edit Food Type</h1>
    {!! Form::open(['action' => ['App\Http\Controllers\FoodTypeController@update', $foodtype->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    <div class="form-group">
            {{Form::label('Type_Name', 'Type Name')}}
            {{Form::text('Type_Name',  $foodtype->Type_Name, ['class' => 'form-control', 'placeholder' => 'Type_Name'])}}
        </div>
        <div class="form-group">
            {{Form::label('Arabic_Name', 'Arabic_Name')}}
            {{Form::text('Arabic_Name',  $foodtype->Arabic_Name, ['class' => 'form-control', 'placeholder' => 'Arabic_Name'])}}
        </div>
        <div class="form-group">
            {{Form::label('Description', 'Description')}}
            {{Form::text('Description',  $foodtype->Description, [ 'class' => 'form-control', 'placeholder' => 'Description'])}}
        </div>
        
        <div class="form-group">
            {{Form::file('type_image')}}
        </div>
        {{Form::hidden('_method','PUT')}}
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection