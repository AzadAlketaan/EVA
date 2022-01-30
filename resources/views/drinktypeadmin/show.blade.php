@extends('layouts.app')

@section('content')
    <h1>{{$drinktype->Type_Name}}</h1>
    <img style="width:25%" src="/storage/type_image/{{$drinktype->type_image}}">
    <br><br>
    <div>
        {!!$drinktype->Arabic_Name!!}
    </div>
    <hr>
    <small>Written on {{$drinktype->created_at}}</small>
    <hr>
        @if(Gate::check('checkpermission','edit') )
            <a href="/drinktypeadmin/{{$drinktype->id}}/edit" class="btn btn-default">Edit</a>
        @endif
        @if(Gate::check('checkpermission','destroy') )
            {!!Form::open(['action' => ['App\Http\Controllers\DrinkTypeAdminController@destroy', $drinktype->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
            {!!Form::close()!!}
        @endif
@endsection