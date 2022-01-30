@extends('layouts.app')

@section('content')
    <h1>Restaurants</h1>
    <a href="/restaurantadmin/create" class="btn btn-default pull-right">New Restaurant</a>
    <br>
    <br>
    @if(count($restaurant) > 0)
        @foreach($restaurant as $restaurants)
            <div class="well">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <img style="width:70%" src="/storage/restaurant_image/{{$restaurants->restaurant_image}}">
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <h3><a href="/restaurantadmin/{{$restaurants->id}}">{{$restaurants->Name}} ({{$restaurants->Arabic_Name}})</a></h3>
                        <small>Written on {{$restaurants->created_at}} </small>
                    </div>
                </div>
            </div>
        @endforeach
        {{$restaurant->links()}}
    @else
        <p>No Restaurants found</p>
    @endif
@endsection