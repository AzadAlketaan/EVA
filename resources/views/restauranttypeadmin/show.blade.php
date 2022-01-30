@extends('layouts.app')

@section('content')
    <h1>{{$restauranttype->Type_Name}}</h1>
    <img style="width:25%" src="/storage/type_image/{{$restauranttype->type_image}}">
    <br><br>
    <div>
        {!!$restauranttype->Arabic_Name!!}
    </div>
    <hr>
    <small>Written on {{$restauranttype->created_at}}</small>
    <hr>
    @if(Gate::check('checkpermission','edit'))
            <a href="/restauranttypeadmin/{{$restauranttype->id}}/edit" class="btn btn-default">Edit</a>
    @endif
    @if(Gate::check('checkpermission','destroy'))
            {!!Form::open(['action' => ['App\Http\Controllers\RestaurantTypeAdminController@destroy', $restauranttype->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
            {!!Form::close()!!}
    @endif
@endsection 