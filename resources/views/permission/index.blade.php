@extends('layouts.master')

@section('content')
<h1>Permissiones</h1>
<a href="/permission/create" class="btn btn-default pull-right">New Permission</a>
<table class="table table-sm">
    <thead>
        <tr>
            <th>Permission Name</th>
            <th>RoleGroups</th>
            <th>Options</th>
        </tr>
    </thead>
    <tbody>
        @foreach($permission as $permissions)
        <tr>
            <td> {{$permissions->Name}} </td>
            <td>

                @foreach($rolegrouppermission as $rolegrouppermissions )
                @if($rolegrouppermissions->Permission_ID == $permissions->id)
                @foreach($rolegroup as $rolegroups)
                @IF($rolegroups->id == $rolegrouppermissions->RoleGroup_ID)
                | {{$rolegroups->Name}} |
                @endif
                @endforeach
                @endif
                @endforeach

            </td>

            <td>

                {!!Form::open(['action' => ['App\Http\Controllers\PermissionController@destroy', $permissions->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                {!!Form::close()!!}
                <a href="/permission/{{$permissions->id}}" class="btn btn-default">Show</a>
                <a href="/permission/{{$permissions->id}}/edit" class="btn btn-default">Edit</a>




            </td>



        </tr>
        @endforeach
    </tbody>
</table>

@endsection