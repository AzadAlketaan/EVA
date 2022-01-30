@extends('layouts.master')

@section('content')
<section class="main-block light-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="styled-heading">
                      <br>
                      <br>
                        <h3>{{$address->Address}}</h3>
                  </div>
                </div>
            </div>
        </div>
</section>

<section class="section bg-light pt-0 bottom-slant-gray">
                <div class="container">
                     <div class="row" style='margin-bottom:100px;'>

                     <div class="col-md-12" data-aos="fade-up" data-aos-delay="100">
                            <div class="blog d-block" style="width:100%;">
                                <img style="width:100%;  height:300px !important; padding: 15px;" href="single.html"  src="/storage/address_image/{{$address->address_image}}">
                            </div>


                  <div class="col-md-12" data-aos="fade-up" data-aos-delay="100">
                     
                        <br>
                        <br>
                        <div style="text-align: center;">
                            {!!$address->Zone!!}
                        </div>
                        <hr>
                        <span style="text-align:center;"><span class="fa fa-calendar"></span>Written on {{$address->created_at}}</span> 
                        <hr>
 </div>
 
   
    @if(!Auth::guest())
    @if($address->user_id != Null)
        @if(Gate::check('checkpermission','edit') )            
            <a href="/address/{{$address->id}}/edit" class="btn btn-default">Edit</a>
        @endif
        @if(Gate::check('checkpermission','destroy') )
            {!!Form::open(['action' => ['App\Http\Controllers\AddressController@destroy', $address->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
            {!!Form::close()!!}
        @endif
    @endif
    @endif
    </div>
        </div>
           </section>


@endsection