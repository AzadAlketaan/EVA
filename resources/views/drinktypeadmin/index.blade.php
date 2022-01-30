@extends('layouts.app')

@section('content')
    <h1>Drink Types</h1>
    @if(Gate::check('checkpermission','create'))
        <a href="/drinktypeadmin/create" class="btn btn-default pull-right">New Drink Type</a>
        <br>
        <br>
    @endif
    @if(count($drinktype) > 0)
        @foreach($drinktype as $drinktypes)
            <div class="well">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <img style="width:70%" src="/storage/type_image/{{$drinktypes->type_image}}">
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <h3><a href="/drinktypeadmin/{{$drinktypes->id}}">{{$drinktypes->Type_Name}}</a></h3>
                        <small>Written on {{$drinktypes->created_at}} </small>
                    </div>
                </div>
            </div>
        @endforeach
        {{$drinktype->links()}}
    @else
        <p>No Drink Type found</p>
    @endif
@endsection