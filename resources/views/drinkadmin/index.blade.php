@extends('layouts.app')

@section('content')
    <h1>Drinks</h1>
    <a href="/drinkadmin/create" class="btn btn-default pull-right">New Drink</a>
    <br>
    <br>
    @if(count($drink) > 0)
        @foreach($drink as $drinks)
            <div class="well">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <img style="width:70%" src="/storage/drink_image/{{$drinks->drink_image}}">
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <h3><a href="/drinkadmin/{{$drinks->id}}">{{$drinks->Name}} ({{$drinks->Arabic_Name}})</a></h3>
                        <small>Written on {{$drinks->created_at}} </small>
                    </div>
                </div>
            </div>
        @endforeach
        {{$drink->links()}}
    @else
        <p>No Drinks found</p>
    @endif
@endsection