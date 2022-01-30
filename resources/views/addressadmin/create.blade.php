@extends('layouts.app')

@section('content')
    <h1>New Address</h1>
    {!! Form::open(['action' => 'App\Http\Controllers\AddressAdminController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('address', 'City')}}
            {{Form::text('address', '', ['class' => 'form-control', 'placeholder' => 'Address'])}}
        </div>
        <div class="form-group">
            {{Form::label('zone', 'Zone')}}
            {{Form::text('zone', '', [ 'class' => 'form-control', 'placeholder' => 'Zone'])}}
        </div>

        <div class="form-group">
            {{Form::label('street', 'street')}}
            {{Form::text('street', '', [ 'class' => 'form-control', 'placeholder' => 'street'])}}
        </div>

        <div class="form-group">
            {{Form::label('description', 'description')}}
            {{Form::text('description', '', [ 'class' => 'form-control', 'placeholder' => 'description'])}}
        </div>

        <div class="form-group">
            {{Form::label('note', 'note')}}
            {{Form::text('note', '', [ 'class' => 'form-control', 'placeholder' => 'note'])}}
        </div>

        <input type="checkbox" name="" id="publicaddress" value="0" > Public Address<br/>         
        When selecting a public address, the address will not be assigned to the restaurant or the user
         <br>
         <br>
        <div class="form-group">
            {{Form::label('user_id', 'User')}}
            <select name="user_id" id="user_id">
                <option value='' >select user</option>
                @foreach($user as $users)
                    <option value='{{$users->id}}'> {{$users->First_Name}} {{$users->Last_Name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            {{Form::label('restaurant_id', 'Restaurant')}}
            <select name="restaurant_id" id="restaurant_id">
                <option value='' >select restaurant</option>
                @foreach($restaurant as $restaurants)
                    <option value='{{$restaurants->id}}'> {{$restaurants->Name}} ({{$restaurants->Arabic_Name}})</option>
                @endforeach
            </select>
        </div>


        <div class="form-group">
            {{Form::file('address_image')}}
        </div>
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection

@push('scripts')

<script type="text/javascript" src="{{ URL::asset('js/addresspublic.js') }}"></script>

@endpush
