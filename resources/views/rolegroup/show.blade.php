@extends('layouts.app')

@section('content')
    <a href="/rolegroup" class="btn btn-default">Go Back</a>
    <h1>{{$rolegroup->Name}}</h1>
   
    <br><br>
    <div>
        {!!$rolegroup->Name!!}
    </div>
    <hr>
    <small>Written on {{$rolegroup->created_at}} </small>
    <hr>
    @if(!Auth::guest())
        @if(Gate::check('checkpermission','edit') )
            <a href="/rolegroup/{{$rolegroup->id}}/edit" class="btn btn-default">Edit</a>
        @endif
        @if(Gate::check('checkpermission','destroy') )
            {!!Form::open(['action' => ['App\Http\Controllers\RoleGroupController@destroy', $rolegroup->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
            {!!Form::close()!!}
        @endif           
 
    @endif

    <table class="table table-sm">
    <thead>
        <tr>
            <th>Permissiones:</th>            
        </tr>
    </thead>
    <tbody>
    @foreach($permission_name as $permission_names)
          <tr>
              
              <td> {{$permission_names}}  </td> 
             
          </tr>
         @endforeach
    </tbody>
</table>

@endsection