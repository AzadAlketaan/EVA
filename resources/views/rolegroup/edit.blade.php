@extends('layouts.app')

@section('content')
    <h1>Edit RoleGroup</h1>
    {!! Form::open(['action' => ['App\Http\Controllers\RoleGroupController@update', $rolegroup->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('Name', 'Name')}}
            {{Form::text('Name', $rolegroup->Name, ['class' => 'form-control', 'placeholder' => 'Name'])}}
        </div>

    <fieldset>
      <label>Permissiones:</label><br>
    @foreach($permission as $permissions)
        @if(in_array($permissions->id, $permission_name))
            <input type="checkbox" name="rolegrouppermissionarray[]" value="{{$permissions->id}}" checked>  {{$permissions->Name}}<br/>
        @else
            <input type="checkbox" name="rolegrouppermissionarray[]" value="{{$permissions->id}}">  {{$permissions->Name}}<br/>
        @endif
    @endforeach
    </fieldset>

        {{Form::hidden('_method','PUT')}}
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection