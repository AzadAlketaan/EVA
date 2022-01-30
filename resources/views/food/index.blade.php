@extends('layouts.master')

@section('content')
<section class="main-block light-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="styled-heading" >
                      <br>
                      <br>
                        <h3>Foods</h3>
                    <p class="mb-0">Enjoy the taste of choice</p>  
                  </div>
                </div>
            </div>
        </div>
</section>

          <section class="section bg-light pt-0 bottom-slant-gray">
                        <div class="container">
                            <div class="row">
   
                            @if(count($food) > 0)
                              @foreach($food as $foods)

                              <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                                <div class="blog d-block" style="width:100%;">
                                  <img style="width:80%;  height:300px !important; padding: 15px;" href="single.html" src="/storage/food_image/{{$foods->food_image}}">
                                 </div>

                                  <div class="text"   style=" padding:20px;" >
                                    <h3><a href="/food/{{$foods->id}}">{{$foods->Name}} ({{$foods->Arabic_Name}})</a></h3>
                                        <p class="sched-time">
                                       <span><span class="fa fa-calendar"></span>Written on {{$foods->created_at}}</span> 
                                        </p>
                                    </div>  
                                                
                                                    @foreach($foodtype as $foodtypes)
                                                        @if($foods->foodtype_id == $foodtypes->id )
                                                        <span><span class="fa fa-calendar" style="padding:15px;"></span>The Type of food: {{$foodtypes->Type_Name}}</span> 
                                                        @endif 
                                                    @endforeach

                              </div>

                                    @endforeach 
                </div>
               </section>

                                    <div class="row" style='margin-bottom:100px;'>
                                       <div class="col-md-12" style="padding-left:40%; padding-top:20px; margin-bottom:45px;">     
                                       {{$food->links()}}
                                       </div>
                                     </div>
                                   
                                @else
                                    <p>No Foods found</p>
                                @endif

             @endsection