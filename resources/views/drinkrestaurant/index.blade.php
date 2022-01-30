@extends('layouts.master')

@section('content')
    <h1>Drinks</h1>
    @if(count($drink) > 0)
        @foreach($drink as $drinks)
            <div class="well">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <img style="width:70%" src="/storage/drink_image/{{$drinks->drink_image}}">
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <h3><a href="/drink/{{$drinks->id}}" target="_blank">{{$drinks->Name}}</a></h3>
                        <small>Written on {{$drinks->created_at}} </small>
                        @if(!in_array($drinks->id, $assigneddrinks))
                            <a href="/assigndrinkrestaurant/{{$drinks->id}}"  class="btn btn-default">Assign</a>
                        @else
                            
                            {!!Form::open(['action' => ['App\Http\Controllers\DrinkRestaurantController@destroy', $drinks->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
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
        {{$drink->links()}}
    @else
        <p>No drinks found</p>
    @endif
@endsection