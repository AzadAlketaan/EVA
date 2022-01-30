@extends('layouts.app')

@section('content')
    <h1>Edit Drink</h1>
    {!! Form::open(['action' => ['App\Http\Controllers\DrinkAdminController@update', $drink->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    <div class="form-group">
            {{Form::label('Name', 'Name')}}
            {{Form::text('Name',  $drink->Name, ['class' => 'form-control', 'placeholder' => 'Name'])}}
        </div>
        <div class="form-group">
            {{Form::label('Arabic_Name', 'Arabic_Name')}}
            {{Form::text('Arabic_Name',  $drink->Arabic_Name, ['class' => 'form-control', 'placeholder' => 'Arabic_Name'])}}
        </div>
        <div class="form-group">
            {{Form::label('Price', 'Price')}}
            {{Form::text('Price',  $drink->Price, ['class' => 'form-control', 'placeholder' => 'Price'])}}
        </div>
        <div class="form-group">
            {{Form::label('Description', 'Description')}}
            {{Form::text('Description',  $drink->Description, ['class' => 'form-control', 'placeholder' => 'Description'])}}
        </div>

        <div class="form-group">
            {{Form::label('drinktype_id', 'Type of food:')}}
            <select name="drinktype_id" id="drinktype_id">        
                @foreach($drinktype as $drinktypes)
                    @if($drinktypes->id == $drink->drinktype_id)
                        <option value='{{$drinktypes->id}}'> {{$drinktypes->Type_Name}} ({{$drinktypes->Arabic_Name}})</option>
                    @endif
                @endforeach
                @foreach($drinktype as $drinktypes)
                    @if($drinktypes->id != $drink->drinktype_id)
                        <option value='{{$drinktypes->id}}'> {{$drinktypes->Type_Name}} ({{$drinktypes->Arabic_Name}})</option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="form-group">
            {{Form::file('drink_image')}}
        </div>
        {{Form::hidden('_method','PUT')}}
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection