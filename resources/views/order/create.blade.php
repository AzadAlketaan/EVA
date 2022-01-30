@extends('layouts.master')

  

 <!-- 
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
     <style type="text/css">
   .box{
    width:500px;
    margin:0 auto;
    border:1px solid #ccc;
   }
  </style>
-->

@section('content')

<section class="main-block light-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="styled-heading">
                      <br>
                      <br>
                        <h3>New Order</h3>
                  </div>
                </div>
            </div>
        </div>
</section>

<section class="section bg-light pt-0 bottom-slant-gray">
                <div class="container">
                     <div class="row"  style="margin-bottom:100px;">

  {!! Form::open(['action' => 'App\Http\Controllers\OrderController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
  <div class="col-md-12 ">
  <br>
  <h4>Select type of order:<br></h4>
        <input type="checkbox" name="internalorder" id="internalorder[]"  value="1" > Internal orders<br>
        <input type="checkbox" name="externalorder" id="externalorder[]"  value="1" > External order (Delivery)
        </div>
    <br/>
   
              <div class="col-md-12 ">
                  <label class="text-black control-label" style="margin-bottom: 0; padding-top: 10px;" >Time of order</label> 
                  <input type="time" id="Time" class="form-control" name="Time" value="" required autofocus>
              </div>

              <div class="col-md-12 ">
                  <label class="text-black control-label" style="margin-bottom: 0; padding-top: 10px;" >Your order</label> 
                  <input type="text" id="Order" class="form-control" name="Order" value="" required autofocus>
              </div>

              <div class="col-md-12 ">
                  <label class="text-black control-label" style="margin-bottom: 0; padding-top: 10px;" >Note</label> 
                  <input type="text" id="Note" class="form-control" name="Note" value="" required autofocus>
              </div>

              <div class="col-md-12 ">
                  <label class="text-black control-label" for="restaurant_id" style="margin-bottom: 0; padding-top: 10px;" >Assign to restaurant:</label> 
                    <select name="restaurant_id" id="restaurant_id" class="form-control input-lg dynamic" data-dependent="reservation_id">
                    <option value="">Select Restaurant</option>
                    @foreach($restaurant as $restaurants)
                        <option value="{{ $restaurants->id}}">{{ $restaurants->Name }} ( {{$restaurants->restauranttype->Type_Name}})</option>
                    @endforeach
                    </select>
              </div>


              <div class="col-md-12 ">
                  <label class="text-black control-label" style="margin-bottom: 0; padding-top: 10px;" for="reservation_id">Assign to reservation:</label> 
                    <select name="reservation_id" id="reservation_id" class="form-control input-lg dynamic">
                     <option value="">Select Reservation</option> 
                    </select>
                    <br>
                    <h4 style="margin:15;">Note: if you select reservation the time of order will be the time of reservation</h4>
                    <br>
               
              </div>
              <a href="/reservation/create" target="_blank" class="btn btn-default">New Reservation</a>
{{ csrf_field() }}


              <div class="col-md-12 ">
                  <label class="text-black control-label" style="margin-bottom: 0; padding-top: 10px;"for="address_id">your address:</label> 
                  <p id="text" style="display:none">(Inside the Restaurant)</p>
                  <select name="address_id" id="address_id" class="form-control input-lg dynamic">
                    <option value="" >select address</option>
                    @foreach($youraddress as $youraddresss)
                    <option value="{{ $youraddresss->id}}">{{ $youraddresss->Address}}_{{ $youraddresss->Zone }}_{{ $youraddresss->Street }}</option>
                    @endforeach
                    </select>
              </div>



  <br>
        <a href="/address/create" target="_blank" class="btn btn-default">New Address</a>
        <br>
        <br>

        
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}

    </div>
            </div>
            </section>

    <script>
$(document).ready(function(){

 $('.dynamic').change(function(){
  if($(this).val() != '')
  {
   var select = $(this).attr("id");
   var value = $(this).val();
   var dependent = $(this).data('dependent');
   var _token = $('input[name="_token"]').val();
   debugger;
   $.ajax({
    url:"{{ route('order.fetch') }}",
    method:"POST",
    data:{select:select, value:value, _token:_token, dependent:dependent},
    success:function(result)
    {
     $('#'+dependent).html(result);
    }

   })
  }
 });

 $('#restaurant_id').change(function(){
  $('#reservation_id').val('');
 });

 

});
</script>
@endsection

@push('scripts')

<script type="text/javascript" src="{{ URL::asset('js/ordertype.js') }}"></script>

@endpush

