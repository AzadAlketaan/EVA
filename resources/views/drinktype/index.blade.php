@extends('layouts.master')

@section('content')
    <h1>Drink Type</h1>
    @if(count($drinktype) > 0)
        @foreach($drinktype as $drinktypes)
            <div class="well">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <img style="width:70%" src="/storage/type_image/{{$drinktypes->type_image}}">
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <h3><a href="/drinktype/{{$drinktypes->id}}">{{$drinktypes->Type_Name}}</a></h3>
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