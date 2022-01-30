@extends('layouts.app')

@section('content')
    <h1>Food Type</h1>
    @if(Gate::check('checkpermission','create'))
        <a href="/foodtypeadmin/create" class="btn btn-default pull-right">New Food Type</a>
        <br>
        <br>
    @endif
    @if(count($foodtype) > 0)
        @foreach($foodtype as $foodtypes)
            <div class="well">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <img style="width:70%" src="/storage/type_image/{{$foodtypes->type_image}}">
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <h3><a href="/foodtypeadmin/{{$foodtypes->id}}">{{$foodtypes->Type_Name}}</a></h3>
                        <small>Written on {{$foodtypes->created_at}} </small>
                    </div>
                </div>
            </div>
        @endforeach
        {{$foodtype->links()}}
    @else
        <p>No Food Type found</p>
    @endif
@endsection