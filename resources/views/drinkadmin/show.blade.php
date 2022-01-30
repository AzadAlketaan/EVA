@extends('layouts.app')

@section('content')
    <h1>{{$drink->title}}</h1>
    <img style="width:25%" src="/storage/drink_image/{{$drink->drink_image}}">
    <br><br>
    <div>
        {!!$drink->Name!!}
    </div>
    <hr>
    <small>Written on {{$drink->created_at}} </small>
    <hr>
    @if(!Auth::guest())
        @if(Gate::check('checkpermission','edit') )
            <a href="/drinkadmin/{{$drink->id}}/edit" class="btn btn-default">Edit</a>
        @endif
        @if(Gate::check('checkpermission','destroy') )
            {!!Form::open(['action' => ['App\Http\Controllers\DrinkAdminController@destroy', $drink->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
            {!!Form::close()!!}
        @endif
    @endif
@endsection