@extends('layouts.master')

@section('content')

<section class="main-block light-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="styled-heading" >
                      <br>
                      <br>
                        <h3>{{$restauranttype->Type_Name}}</h3>
                      
                  </div>
                </div>
            </div>
        </div>
</section>

   

    <section class="section bg-light pt-0 bottom-slant-gray">
                        <div class="container">
                            <div class="row">

                <div class="col-md-12"  data-aos="fade-up" data-aos-delay="100">
                   <div class="blog d-block" style="width:100%;">
                      <img style="width:100%;  height:300px !important; padding: 15px;" href="single.html" src="/storage/type_image/{{$restauranttype->type_image}}">
                   </div>

    <br><br>
    <div style="text-align: center;">
        {!!$restauranttype->Arabic_Name!!}
    </div>
    <hr>
    <span><span  class="fa fa-calendar"  ></span>Written on {{$restauranttype->created_at}}</span> 

    <hr>
    @if(!Auth::guest())
        @if(Gate::check('checkpermission','edit') )
            <a href="/restauranttype/{{$restauranttype->id}}/edit" class="btn btn-default">Edit</a>
        @endif
        @if(Gate::check('checkpermission','destroy') )
            {!!Form::open(['action' => ['App\Http\Controllers\RestaurantTypeController@destroy', $restauranttype->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
            {!!Form::close()!!}
            <br>
        @endif
    @endif



<h3>Restaurants:</h3>
<div style="padding-bottom:100px;">
<table class="table table-sm">
    <thead>
        <tr>
            <th>Name : </th>            
        </tr>
    </thead>
    <tbody>  
    @foreach($restaurant as $restaurants)      
        <tr> 
            <td>      

            <span style="padding-top:30px !important ; "><span  class="fa fa-calendar"></span> {{$restaurants->Name}} ( {{$restaurants->Arabic_Name}} )</span> 
               
            </td>

            <td style="text-align:right"> 

                    <button type="submit" class="btn btn-default pull-right" style="margin-left: 160px; padding: 6px; background: #3e434b;">
                        <a style="color: white;" href="/restaurant/{{$restaurants->id}}" >Show</a> 
                        </button>    
                        </td>                          
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
        </div>
</div>
</div>
  </section>

@endsection