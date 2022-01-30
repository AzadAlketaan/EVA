@extends('layouts.app')

@section('content')

    
    <h1>Assign Restaurant to User:</h1>

<table class="table table-sm">
    <thead>
        <tr>
            <th>Users</th>
        </tr>
    </thead>
    <tbody>     
         
        @foreach($user as $users)        
        <tr>
        <td> 
            {{$users->First_Name}} {{$users->Last_Name}}

            @if(!in_array($users->id, $assignedusers))
                <a href="/assignuserrestaurant/{{$users->id}}"  class="btn btn-default pull-right">Assign</a>
            @else
            {!!Form::open(['action' => ['App\Http\Controllers\UserRestaurantController@destroy', $users->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Remove', ['class' => 'btn btn-danger'])}}
            {!!Form::close()!!}
            @endif
        </td>
        </tr>
        @endforeach
        
    </tbody>
</table>
    
@endsection