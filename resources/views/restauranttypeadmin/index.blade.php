@extends('layouts.app')

@section('content')
    <h1>Restaurant Types</h1>
    @if(Gate::check('checkpermission','create'))
        <a href="/restauranttypeadmin/create" class="btn btn-default pull-right">New Restaurant Type</a>
        <br>
        <br>
    @endif
    @if(count($restauranttype) > 0)
        @foreach($restauranttype as $restauranttypes)
            <div class="well">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <img style="width:70%" src="/storage/type_image/{{$restauranttypes->type_image}}">
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <h3><a href="/restauranttypeadmin/{{$restauranttypes->id}}">{{$restauranttypes->Type_Name}}</a></h3>
                        <small>Written on {{$restauranttypes->created_at}} </small>
                    </div>
                </div>
            </div>
        @endforeach
        {{$restauranttype->links()}}
    @else
        <p>No Restaurant Type found</p>
    @endif
@endsection 