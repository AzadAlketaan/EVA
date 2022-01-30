@extends('layouts.app')

@section('content')
    <h1>New Drink</h1>
    {!! Form::open(['action' => 'App\Http\Controllers\DrinkAdminController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
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
            {{Form::label('drinktype_id', 'Type of drink:')}}
            <select name="drinktype_id" id="drinktype_id">
                <option value=''>select type</option>
                @foreach($drinktype as $drinktypes)
                    <option value='{{$drinktypes->id}}'> {{$drinktypes->Type_Name}} ({{$drinktypes->Arabic_Name}})</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            {{Form::file('drink_image')}}
        </div>
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection