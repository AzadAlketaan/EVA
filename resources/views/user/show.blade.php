@extends('layouts.app')

@section('content')
<a href="/user" class="btn btn-default">Go Back</a>
<h1>{{ $user->First_Name }} {!! $user->Last_Name !!}</h1>
<img style="width:15%" src="/storage/profile_image/{{ $user->profile_image }}">
<img style="width:15%" src="/storage/cover_image/{{ $user->cover_image }}">
<br><br>
<div>
    {!! $user->Email !!}
</div>
<hr>

<small>Created At {{ $user->created_at }}</small><br>
----------------------------------------------------
<br>
The Roles for this user:
<br>
@foreach ($rolegroup_name as $rolegroup_names)
<small> {{ $rolegroup_names }}</small>
<br>
@endforeach
<hr>
@if (!Auth::guest())
@if (Gate::check('checkpermission', 'edit'))
<a href="/user/{{ $user->id }}/edit" class="btn btn-default">Edit</a>
@endif

<a href="/assignroles/{{ $user->id }}" class="btn btn-default">Assign Roles</a>

@if (Gate::check('checkpermission', 'destroy'))
{!! Form::open(['action' => ['App\Http\Controllers\UserController@destroy', $user->id], 'method' => 'POST', 'class' => 'pull-right']) !!}
{{ Form::hidden('_method', 'DELETE') }}
{{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
{!! Form::close() !!}
@endif
@endif
@endsection