@extends('layouts.app')

@section('content')
<h1>{{$restaurant->Name}} ( {{$restaurant->Arabic_Name}} )</h1> 
    <h3>{!!$restaurant->Status!!}</h3>
    @php
        $average_evaluation = \App\Http\Controllers\EvaluationController::average_evaluation($restaurant);
    @endphp
    @if($average_evaluation == 'Undefined')
        <h3>{!!$restaurant->Recommended_Evaluation!!}</h3>
    @else
        <h3> Evaluation: {{$average_evaluation}}</h3>
    @endif                
    
    <br>
    <img style="width:25%" src="/storage/restaurant_image/{{$restaurant->restaurant_image}}">
    <br><br>
    <h4>Open At: {{$restaurant->Time_Open}} , Close At: {{$restaurant->Time_Close}}</h4>
    <div>                
        <h4>Phone: {!!$restaurant->Phone_Number1!!}</h4>
        @if($restaurant->Delivery_Service == 1)
            <h4>Delivery Service: Available</h4>
        @else
            <h4>Delivery Service: Not Available</h4>
        @endif
        @if($restaurant->Reservation_Service == 1)
            <h4>ReservationService: Available</h4>
        @else
            <h4>Reservation Service: Not Available</h4>
        @endif
        @if($restaurant->Description != Null)                  
            <h4>Description:<br> {{$restaurant->Description}} </h4>  
        @endif      
    </div>
    <hr>
    @foreach($userrestaurant as $userrestaurants)
        @foreach($user as $users)
            @if($users->id == $userrestaurants->user_id)
                <small>The Owners of the restaurant: {{$users->First_Name}}  {{$users->Last_Name}} </small>
            @endif
        @endforeach
    @endforeach    
    <br>
    <small>Created on {{$restaurant->created_at}} </small>
    <br>
    <small>The Type of restaurant: {{$restauranttype->Type_Name}}</small>
    <hr>
            @if(Gate::check('checkpermission','edit') )
                <a href="/restaurantadmin/{{$restaurant->id}}/edit" class="btn btn-default">Edit</a>
            @endif
            @if(Gate::check('checkpermissionname','reservationadmincreate'))
                <a href="/reservationadmin/create" target="_blank" class="btn btn-default">Add Reservation</a>
            @endif
            @if(Gate::check('checkpermissionname','evaluationadmincreate'))
                <a href="/evaluationadmin/create" target="_blank" class="btn btn-default">Add Evaluation</a>
            @endif
            @if(Gate::check('checkpermissionname','orderadmincreate'))
                <a href="/orderadmin/create" target="_blank" class="btn btn-default">Add Order</a>
            @endif
            @if(Gate::check('checkpermissionname','foodrestaurantadminindex'))
                <a href="/foodrestaurantadmin" target="_blank" class="btn btn-default">Assign foods</a>
            @endif
            @if(Gate::check('checkpermissionname','drinkrestaurantadminindex'))
                <a href="/drinkrestaurantadmin" target="_blank" class="btn btn-default">Assign Drinks</a>
            @endif
            @if(Gate::check('checkpermissionname','userrestaurantadminindex'))
                <a href="/userrestaurant" target="_blank" class="btn btn-default">Assign To User</a>
            @endif
            

            @if(Gate::check('checkpermission' , 'destroy'))
            {!!Form::open(['action' => ['App\Http\Controllers\RestaurantAdminController@destroy', $restaurant->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
            {!!Form::close()!!}
            @endif
        

            <h3>Foods && Drinks in the Restaurant:</h3>
<table class="table table-sm">
    <thead>
        <tr>
            <th>Foods && Drinks</th>
        </tr>
    </thead>
    <tbody>     
         
        @foreach($foodrestaurant as $foodrestaurants)        
        <tr>
        <td>
            @foreach($food as $foods) 
                @if($foods->id == $foodrestaurants->Food_ID )   
                     {{$foods->Name}} 
                        <a href="/food/{{$foods->id}}" class="btn btn-default pull-right">Show</a>
                @endif
            @endforeach       
        </td>
        </tr>
        @endforeach

        @foreach($drinkrestaurant as $drinkrestaurants)
        <tr>
        <td>
        
        @foreach($drink as $drinks) 
             @if($drinks->id == $drinkrestaurants->Drink_ID )   
                 {{$drinks->Name}} 
                    <a href="/drink/{{$drinks->id}}" class="btn btn-default pull-right">Show</a>
            @endif
        @endforeach
    
        </td> 
        </tr>
        @endforeach
        
    </tbody>
</table>
@endsection