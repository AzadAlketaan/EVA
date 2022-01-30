@extends('layouts.app')

@section('content')
    <h1>Foods</h1>
    @if(count($food) > 0)
        @foreach($food as $foods)
            <div class="well">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <img style="width:70%" src="/storage/food_image/{{$foods->food_image}}">
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <h3><a href="/foodadmin/{{$foods->id}}" target="_blank">{{$foods->Name}}</a></h3>
                        <small>Written on {{$foods->created_at}} </small>
                        @if(!in_array($foods->id, $assignedfoods))
                            <a href="/assignfoodrestaurantadmin/{{$foods->id}}"  class="btn btn-default">Assign</a>
                        @else
                            
                            {!!Form::open(['action' => ['App\Http\Controllers\FoodRestaurantAdminController@destroy', $foods->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                                {{Form::hidden('_method', 'DELETE')}}
                                {{Form::submit('Remove', ['class' => 'btn btn-danger'])}}
                            {!!Form::close()!!}

                            {{ Form::open(['onsubmit' => 'return false' ,'class' => 'pull-right']) }}
                                {{Form::submit('Assigned', ['class' => 'btn btn'])}}
                            {!!Form::close()!!}    

                        @endif
                    </div>
                </div>
            </div>
        @endforeach
        {{$food->links()}}
    @else
        <p>No foods found</p>
    @endif
@endsection