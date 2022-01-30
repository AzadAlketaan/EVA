@extends('layouts.app')

@section('content')
    <a href="/addressadmin/create" class="btn btn-default pull-right">New Address</a>
    <br>
    <br>    
    @if(count($public_address) > 0)
    <h1>Public Addresses</h1>
        @foreach($public_address as $public_addresss)
            <div class="well"> 
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <img style="width:70%" src="/storage/address_image/{{$public_addresss->address_image}}">
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <h3><a href="/addressadmin/{{$public_addresss->id}}">{{$public_addresss->Address}} {{$public_addresss->Zone}} {{$public_addresss->Street}}</a></h3>
                        @if($public_addresss->user_id != Null)
                            <small>Written on {{$public_addresss->created_at}} <br> by  {{$public_addresss->user->First_Name}} {{$public_addresss->user->Last_Name}}</small>
                        @else
                            <small>Written on {{$public_addresss->created_at}} <br> by System</small>
                        @endif
                    </div> 
                </div> 
            </div> 
                
        @endforeach
    @else
        <p>No Addresses found</p>
    @endif
    @if(count($restaurant_address) > 0)
    <h1>Restaurant Addresses</h1>
        @foreach($restaurant_address as $restaurant_addresss)
            <div class="well"> 
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <img style="width:70%" src="/storage/address_image/{{$restaurant_addresss->address_image}}">
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <h3><a href="/addressadmin/{{$restaurant_addresss->id}}">{{$restaurant_addresss->Address}} {{$restaurant_addresss->Zone}} {{$restaurant_addresss->Street}}</a></h3>
                        @if($restaurant_addresss->user_id != Null)
                            <small>Written on {{$restaurant_addresss->created_at}} <br> by  {{$restaurant_addresss->user->First_Name}} {{$restaurant_addresss->user->Last_Name}}</small>                     
                        @endif
                            <br>
                        @if($restaurant_addresss->restaurant_id != Null)
                            <small>For  {{$restaurant_addresss->restaurant->Name}} ({{$restaurant_addresss->restaurant->Arabic_Name}}) Restaurant</small>                     
                        @endif
                    </div>
                </div> 
            </div>
            
        @endforeach
    @else
        <p>No Addresses found</p>
    @endif
    @if(count($user_address) > 0)
        <h1>User Addresses</h1>
        @foreach($user_address as $user_addresss)
            <div class="well"> 
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <img style="width:70%" src="/storage/address_image/{{$user_addresss->address_image}}">
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <h3><a href="/addressadmin/{{$user_addresss->id}}">{{$user_addresss->Address}} {{$user_addresss->Zone}} {{$user_addresss->Street}}</a></h3>
                        @if($user_addresss->user_id != Null)
                            <small>Written on {{$user_addresss->created_at}} <br> by  {{$user_addresss->user->First_Name}} {{$user_addresss->user->Last_Name}}</small>
                        @else
                            <small>Written on {{$user_addresss->created_at}} <br> by System</small>
                        @endif
                    </div>
                </div> 
            </div>
        
    @endforeach
    @else
        <p>No Addresses found</p>
    @endif
    
@endsection