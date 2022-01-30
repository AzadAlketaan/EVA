@extends('layouts.app')

@section('content')
    <h1>Foods</h1>
    <a href="/foodadmin/create" class="btn btn-default pull-right">New Food</a>
    <br>
    <br>
    @if(count($food) > 0)
        @foreach($food as $foods)
            <div class="well">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <img style="width:70%" src="/storage/food_image/{{$foods->food_image}}">
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <h3><a href="/foodadmin/{{$foods->id}}">{{$foods->Name}} ({{$foods->Arabic_Name}})</a></h3>
                        <small>Written on {{$foods->created_at}} </small>
                    </div>
                </div>
            </div>
        @endforeach
        {{$food->links()}}
    @else
        <p>No Foods found</p>
    @endif
@endsection