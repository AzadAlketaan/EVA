@extends('layouts.app')

@section('content')
<a href="/permission" class="btn btn-default">Go Back</a>
<h1>{{$permission->Name}}</h1>
<br><br>
<div>
    The Permissione belong to below Role Groupes:<br>
    @foreach($rolegroup_name as $rolegroup_names)
    {{$rolegroup_names}}<br>
    @endforeach
</div>
<hr>
<small>Written on {{$permission->created_at}} </small>
<hr>
@if(!Auth::guest())
@if(Gate::check('checkpermission','edit') )
<a href="/permission/{{$permission->id}}/edit" class="btn btn-default">Edit</a>
@endif
@if(Gate::check('checkpermission','destroy') )
{!!Form::open(['action' => ['App\Http\Controllers\PermissionController@destroy', $permission->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
{{Form::hidden('_method', 'DELETE')}}
{{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
{!!Form::close()!!}
@endif

@endif
@endsection