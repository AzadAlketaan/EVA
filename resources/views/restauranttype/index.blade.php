@extends('layouts.master')

@section('content')
<section class="main-block light-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="styled-heading">
                      <br>
                      <br>
                        <h3>Restaurants Types</h3>
                    <p class="mb-0">Enjoy the taste of choice</p>  
                  </div>
                </div>
            </div>
        </div>
</section>


            <section class="section bg-light pt-0 bottom-slant-gray">
                <div class="container">
                     <div class="row">
                     
                            @if(count($restauranttype) > 0)
                            @foreach($restauranttype as $restauranttypes)

                <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="blog d-block" style="width:100%;">
                    <img style="width:80%;  height:300px !important; padding: 15px;" href="single.html" src="/storage/type_image/{{$restauranttypes->type_image}}">
                    </div>

                   
                    <div class="text"   style=" padding: 16px;margin-bottom:50px;" >
                        <h3><a href="/restauranttype/{{$restauranttypes->id}}">{{$restauranttypes->Type_Name}}</a></h3>
                        <p class="sched-time">
                        <span><span class="fa fa-calendar"></span>Written on {{$restauranttypes->created_at}}</span> 
                    </p>
                    </div>  
                    </div>  
                    
                            @endforeach
                                   <div class="row" style="margin-bottom:100px;">
                                      <div class="col-md-6" >     
                                      {{$restauranttype->links()}}
                                      </div>
                                  </div>
                                   
                                @else
                                    <p>No Drink Type found</p>
                                @endif

                                   <!-- 
                                <div class="bottom-icons">
                                    <div class="closed-now">CLOSED NOW</div>
                                    <span class="ti-heart"></span>
                                    <span class="ti-bookmark"></span>
                                </div>
                                   -->
            </div>
        </div>
    </section>
    <!--//END FEATURED PLACES -->
@endsection