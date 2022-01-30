@extends('layouts.app')

@section('content')
<h1>Create RoleGroup</h1>
{!! Form::open(['action' => 'App\Http\Controllers\RoleGroupController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
<div class="form-group">
    {{Form::label('Name', 'Name')}}
    {{Form::text('Name', '', ['class' => 'form-control', 'placeholder' => 'Name'])}}
</div>

<fieldset>
    <label>Permissiones:</label><br>
    @foreach($permission as $permissions)
    <input type="checkbox" name="rolegrouppermissionarray[]" value="{{$permissions->id}}"> {{$permissions->Name}}<br />
    @endforeach
</fieldset>

{{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
{!! Form::close() !!}
@endsection