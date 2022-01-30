@extends('layouts.app')

@section('content')
    <h1>Edit Address</h1>
    {!! Form::open(['action' => ['App\Http\Controllers\AddressAdminController@update', $address->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
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
            {{Form::label('Location', 'Location')}}
            {{Form::text('Location', $address->Location, [ 'class' => 'form-control', 'placeholder' => 'Location'])}}
        </div>

        <div class="form-group">
            {{Form::label('note', 'Note')}}
            {{Form::text('note', $address->Note, [ 'class' => 'form-control', 'placeholder' => 'Note'])}}
        </div>

        @if($address->user_id == NULL and $address->restaurant_id == NULL)
            <input type="checkbox" name="" id="publicaddress" value="publicaddress" checked> Public Address<br/>
        @else
            <input type="checkbox" name="" id="publicaddress" value="publicaddress" > Public Address<br/>
        @endif         
        When selecting a public address, the address will not be assigned to the restaurant or the user
         <br>
         <br>
        <div class="form-group">
            {{Form::label('user_id', 'User')}}
            <select name="user_id" id="user_id">
            @if($address->user_id == NULL)
                <option value='' >select user</option>
                  @foreach($user as $users)
                    <option value='{{$users->id}}'> {{$users->First_Name}} {{$users->Last_Name}}</option>
                @endforeach
            @else
                @foreach($user as $users)
                    @if($address->user_id == $users->id)
                        <option value='{{$users->id}}'> {{$users->First_Name}} {{$users->Last_Name}}</option>
                    @endif
                @endforeach
                @foreach($user as $users)
                    @if($address->user_id != $users->id)
                        <option value='{{$users->id}}'> {{$users->First_Name}} {{$users->Last_Name}}</option>
                    @endif
                @endforeach
            @endif                
            </select>
        </div>
        <div class="form-group">
            {{Form::label('restaurant_id', 'Restaurant')}}
            <select name="restaurant_id" id="restaurant_id">
            @if($address->restaurant_id == NULL)
                <option value='' >select restaurant</option>
                @foreach($restaurant as $restaurants)
                    <option value='{{$restaurants->id}}'> {{$restaurants->Name}} ({{$restaurants->Arabic_Name}})</option>
                @endforeach
            @else
                @foreach($restaurant as $restaurants)
                    @if($address->restaurant_id == $restaurants->id)
                    <option value='{{$restaurants->id}}'> {{$restaurants->Name}} ({{$restaurants->Arabic_Name}})</option>
                    @endif
                @endforeach
                @foreach($restaurant as $restaurants)
                    @if($address->restaurant_id != $restaurants->id)
                        <option value='{{$restaurants->id}}'> {{$restaurants->Name}} ({{$restaurants->Arabic_Name}})</option>
                    @endif
                @endforeach
            @endif               
            </select>
        </div>


        <div class="form-group">
            {{Form::file('address_image')}}
        </div>
        {{Form::hidden('_method','PUT')}}
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection

@push('scripts')

<script type="text/javascript" src="{{ URL::asset('js/addresspublic.js') }}"></script>

@endpush
