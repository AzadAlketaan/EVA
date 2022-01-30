@extends('layouts.app')

@section('content')
    <a href="/foodtypeadmin" class="btn btn-default">Go Back</a>
    <h1>{{$foodtype->Type_Name}}</h1>
    <img style="width:25%" src="/storage/type_image/{{$foodtype->type_image}}">
    <br><br>
    <div>
        {!!$foodtype->Arabic_Name!!}
    </div>
    <hr>
    <small>Written on {{$foodtype->created_at}}</small>
    <hr>
        @if(Gate::check('checkpermission','edit') )
            <a href="/foodtypeadmin/{{$foodtype->id}}/edit" class="btn btn-default">Edit</a>
        @endif
        @if(Gate::check('checkpermission','destroy') )
            {!!Form::open(['action' => ['App\Http\Controllers\FoodTypeAdminController@destroy', $foodtype->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
            {!!Form::close()!!}
        @endif
@endsection