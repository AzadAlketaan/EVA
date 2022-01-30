@extends('layouts.master')

@section('content')
    <h1>Edit Address</h1>
    {!! Form::open(['action' => ['App\Http\Controllers\AddressController@update', $address->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    <div class="form-group">
            {{Form::label('address', 'Address')}}
            {{Form::text('address', $address->Address, ['class' => 'form-control', 'placeholder' => 'Address'])}}
        </div>
        <div class="form-group">
            {{Form::label('zone', 'Zone')}}
            {{Form::text('zone', $address->Zone, [ 'class' => 'form-control', 'placeholder' => 'Zone'])}}
        </div>

        <div class="form-group">
            {{Form::label('street', 'Street')}}
            {{Form::text('street', $address->Street, [ 'class' => 'form-control', 'placeholder' => 'Street'])}}
        </div>

        <div class="form-group">
            {{Form::label('description', 'Description')}}
            {{Form::text('description', $address->Description, [ 'class' => 'form-control', 'placeholder' => 'Description'])}}
        </div>

        <div class="form-group">
            {{Form::label('note', 'Note')}}
            {{Form::text('note', $address->Note, [ 'class' => 'form-control', 'placeholder' => 'Note'])}}
        </div>

        <div class="form-group">
            {{Form::file('address_image')}}
        </div>
        {{Form::hidden('_method','PUT')}}
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection