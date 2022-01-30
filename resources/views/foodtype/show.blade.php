@extends('layouts.master')

@section('content')
    <a href="/foodtype" class="btn btn-default">Go Back</a>
    <h1>{{$foodtype->Type_Name}}</h1>
    <img style="width:25%" src="/storage/type_image/{{$foodtype->type_image}}">
    <br><br>
    <div>
        {!!$foodtype->Arabic_Name!!}
    </div>
    <hr>
    <small>Written on {{$foodtype->created_at}}</small>
    <hr>
    @if(!Auth::guest())
        @if(Gate::check('checkpermission','edit') )
            <a href="/foodtype/{{$foodtype->id}}/edit" class="btn btn-default">Edit</a>
        @endif
        @if(Gate::check('checkpermission','destroy') )
            {!!Form::open(['action' => ['App\Http\Controllers\FoodTypeController@destroy', $foodtype->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
            {!!Form::close()!!}
        @endif
    @endif

<h3>Foods under this type:</h3>
<table class="table table-sm">
    <thead>
        <tr>
            <th>Foods</th>            
        </tr>
    </thead>
    <tbody>  
    @foreach($food as $foods)   
        <tr> 
        <td>        
            {{$foods->Name}} 
            <a href="/food/{{$foods->id}}" class="btn btn-default pull-right">Show</a>
        </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection