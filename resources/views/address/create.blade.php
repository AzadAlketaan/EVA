@extends('layouts.master')

@section('content')
<section class="main-block light-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="styled-heading">
                      <br>
                      <br>
                        <h3>New Address</h3>
                  </div>
                </div>
            </div>
        </div>
</section>
   
<section class="section bg-light pt-0 bottom-slant-gray">
                <div class="container">
                     <div class="row"  style="margin-bottom:100px;">
    {!! Form::open(['action' => 'App\Http\Controllers\AddressController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
       

              <div class="col-md-12 ">
                  <label class="text-black control-label" style="margin-bottom: 0; padding-top: 10px;" >address_City</label> 
                  <input type="text" id="address" class="form-control" name="City" value="" required autofocus>
              </div>

              <div class="col-md-12 ">
                  <label class="text-black control-label" style="margin-bottom: 0; padding-top: 10px;" >zone</label> 
                  <input type="text" id="zone" class="form-control" name="zone" value="" required autofocus>
              </div>

      
        <div class="col-md-12 ">
                  <label class="text-black control-label" style="margin-bottom: 0; padding-top: 10px;" >street</label> 
                  <input type="text" id="street" class="form-control" name="street" value="" required autofocus>
              </div>


     

        <div class="col-md-12 ">
                  <label class="text-black control-label" style="margin-bottom: 0; padding-top: 10px;" >description</label> 
                  <input type="text" id="description" class="form-control" name="description" value="" required autofocus>
              </div>

      
              <div class="col-md-12 ">
                  <label class="text-black control-label" style="margin-bottom: 0; padding-top: 10px;" >note</label> 
                  <input type="text" id="note" class="form-control" name="note" value="" required autofocus>
              </div>

    <br>
    <br>

        <div class="form-group" style="padding-left:20px;">
            {{Form::file('address_image')}}
        </div>
        <br>
        
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection