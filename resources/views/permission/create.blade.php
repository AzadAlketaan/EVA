@extends('layouts.app')

@section('content')
    <h1>New Permission</h1>
    {!! Form::open(['action' => 'App\Http\Controllers\PermissionController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('Name', 'Name')}}
            {{Form::text('Name', '', ['class' => 'form-control', 'placeholder' => 'Name'])}}
        </div> 

<fieldset>
  <legend>Assign tp Role Groups:</legend>

  <div>
        @foreach($rolegroup as $rolegroups)
            <input type="checkbox" name="rolegrouprolearray[]" id="check" value="{{$rolegroups->id}}" >  {{$rolegroups->Name}}<br/>
        @endforeach
  </div>
</fieldset>

        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}

@endsection

