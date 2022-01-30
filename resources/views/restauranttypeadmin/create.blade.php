@extends('layouts.app')

@section('content')
    <h1>New Restaurant Type</h1>
    {!! Form::open(['action' => 'App\Http\Controllers\RestaurantTypeAdminController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('Type_Name', 'Type Name')}}
            {{Form::text('Type_Name', '', ['class' => 'form-control', 'placeholder' => 'Type_Name'])}}
        </div>
        <div class="form-group">
            {{Form::label('Arabic_Name', 'Arabic_Name')}}
            {{Form::text('Arabic_Name', '', ['class' => 'form-control', 'placeholder' => 'Arabic_Name'])}}
        </div>
        <div class="form-group">
            {{Form::label('Description', 'Description')}}
            {{Form::text('Description', '', [ 'class' => 'form-control', 'placeholder' => 'Description'])}}
        </div>
        
        <div class="form-group">
            {{Form::file('type_image')}}
        </div>
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection 