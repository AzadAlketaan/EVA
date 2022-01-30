@extends('layouts.master')

@section('content')
    <h1>{{$drinktype->Type_Name}}</h1>
    <img style="width:25%" src="/storage/type_image/{{$drinktype->type_image}}">
    <br><br>
    <div>
        {!!$drinktype->Arabic_Name!!}
    </div>
    <hr>
    <small>Written on {{$drinktype->created_at}}</small>
    <hr>
    @if(!Auth::guest())
        @if(Gate::check('checkpermission','edit') )
            <a href="/drinktype/{{$drinktype->id}}/edit" class="btn btn-default">Edit</a>
        @endif
        @if(Gate::check('checkpermission','destroy') )
            {!!Form::open(['action' => ['App\Http\Controllers\DrinkTypeController@destroy', $drinktype->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
            {!!Form::close()!!}
        @endif
    @endif

<h3>Drinks under this type:</h3>
<table class="table table-sm">
    <thead>
        <tr>
            <th>Drinks</th>            
        </tr>
    </thead>
    <tbody>  
    @foreach($drink as $drinks)   
        <tr> 
        <td>        
            {{$drinks->Name}} 
            <a href="/drink/{{$drinks->id}}" class="btn btn-default pull-right">Show</a>
        </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection