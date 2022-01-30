@extends('layouts.app')

@section('content')
    <h1>{{$address->Address}}</h1>
    <img style="width:25%" src="/storage/address_image/{{$address->address_image}}">
    <br><br>
    <div>
        {!!$address->Zone!!}
    </div>
    <hr>
    @if($address->user_id != Null)
        <small>Written on {{$address->created_at}} <br> by  {{$address->user->First_Name}} {{$address->user->Last_Name}}</small>
    @else
        <small>Written on {{$address->created_at}} <br> by System</small>
    @endif
    <hr>
    @if(!Auth::guest())
        @if(Gate::check('checkpermission','edit') )
            <a href="/addressadmin/{{$address->id}}/edit" class="btn btn-default">Edit</a>
        @endif 
        @if(Gate::check('checkpermission','destroy') )
            {!!Form::open(['action' => ['App\Http\Controllers\AddressAdminController@destroy', $address->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
            {!!Form::close()!!}
        @endif
    @endif
@endsection