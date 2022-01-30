@extends('layouts.app')

@section('content')
    <h1>RoleGroups</h1>
    <a href="/rolegroup/create" class="btn btn-default pull-right">New Role</a>
<table class="table table-sm">
    <thead>
        <tr>
            <th>Adjective</th>
            
        </tr>
    </thead>
    <tbody>
    @foreach($rolegroup as $rolegroups)
          <tr>
              
              <td> {{$rolegroups->Name}}  
              {!!Form::open(['action' => ['App\Http\Controllers\RoleGroupController@destroy', $rolegroups->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                        {{Form::hidden('_method', 'DELETE')}}
                        {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
              {!!Form::close()!!}

              <a href="/rolegroup/{{$rolegroups->id}}/edit" class="btn btn-default pull-right">Edit</a>
              <a href="/rolegroup/{{$rolegroups->id}}" class="btn btn-default pull-right">Show</a>

              </td> 
             
          </tr>
         @endforeach
    </tbody>
</table>

@endsection