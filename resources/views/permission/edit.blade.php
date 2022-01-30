@extends('layouts.app')

@section('content')
    <h1>Edit Permission</h1>
    {!! Form::open(['action' => ['App\Http\Controllers\PermissionController@update', $permission->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('Name', 'Name')}}
            {{Form::text('Name', $permission->Name, ['class' => 'form-control', 'placeholder' => 'Name'])}}
        </div>

    <fieldset>
      <label>Permissiones:</label><br>

    @if($array_size == 'notempty')
        @foreach($rolegroup as $rolegroups)
            @if(in_array($rolegroups->Name, $rolegroup_name))
                <input type="checkbox" name="rolegrouprolearray[]"  id="check" value="{{$rolegroups->id}}" checked>  {{$rolegroups->Name}}<br/>
            @else
                <input type="checkbox" name="rolegrouprolearray[]" id="check" value="{{$rolegroups->id}}" >  {{$rolegroups->Name}}<br/>
            @endif
        @endforeach
    @endif
    </fieldset>

        {{Form::hidden('_method','PUT')}}
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection


