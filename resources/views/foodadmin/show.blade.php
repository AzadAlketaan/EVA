@extends('layouts.app')

@section('content')
    <h1>{{$food->Name}}</h1>
    <img style="width:25%" src="/storage/food_image/{{$food->food_image}}">
    <br><br>
    <div>
        {!!$food->Arabic_Name!!}
    </div>
    <hr>
    <small>Written on {{$food->created_at}}</small>
    <hr>
    @if(!Auth::guest())
        @if(Gate::check('checkpermission','edit') )
            <a href="/foodadmin/{{$food->id}}/edit" class="btn btn-default">Edit</a>
        @endif
        @if(Gate::check('checkpermission','destroy') )
            {!!Form::open(['action' => ['App\Http\Controllers\FoodAdminController@destroy', $food->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
            {!!Form::close()!!}
        @endif
    @endif
@endsection