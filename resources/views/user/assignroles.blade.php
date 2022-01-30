@extends('layouts.app')

@section('content')
    <h1>Assign Roles to {{ $user->First_Name }} {{ $user->Last_Name }}</h1>

    {!! Form::open(['action' => ['App\Http\Controllers\UserController@submitassignroles', $user->id], 'method' => 'POST', 'enctype' =>'multipart/form-data']) !!}
   
    <fieldset>
        <label>Roles:</label><br>
        @foreach ($rolegroup as $rolegroups)
            @if (in_array($rolegroups->id, $rolegroup_name))
                <input type="checkbox" name="userrolegrouparray[]" value="{{ $rolegroups->id }}" checked>
                {{ $rolegroups->Name }}<br />
            @else
                <input type="checkbox" name="userrolegrouparray[]" value="{{ $rolegroups->id }}"> {{ $rolegroups->Name }}<br />
            @endif
        @endforeach
    </fieldset>
    
    {{ Form::hidden('_method', 'PUT') }}
    {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
    {!! Form::close() !!}



@endsection
