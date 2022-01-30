@extends('layouts.app')
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

@section('content')
    <h1>Edit Order</h1>
    {!! Form::open(['action' => ['App\Http\Controllers\OrderController@update', $order->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    <br/>
    <h4>Select type of order:
    @if($order->ordertype == 1)
        <input type="checkbox" name="internalorder" id="internalorder[]" value="$order->ordertype" checked > Internal orders
        <input type="checkbox" name="externalorder" id="externalorder[]" value="$order->ordertype" > External order (Delivery)<br/><br/></h4>
    @elseif($order->ordertype == 0)
        <input type="checkbox" name="internalorder" id="internalorder[]" value="$order->ordertype" > Internal orders
        <input type="checkbox" name="externalorder" id="externalorder[]" value="$order->ordertype" checked> External order (Delivery)<br/><br/></h4>
    @endif   

        <div class="form-group">
            {{Form::label('Time of order', 'Time of order')}}
            <input type="time" id="Time" name="Time" value = '{{$order->Time}}'>
        </div>
        <div class="form-group">
            {{Form::label('your Order', 'your Order')}}
            {{Form::text('Order', $order->Order, ['class' => 'form-control', 'placeholder' => 'Order'])}}
        </div>
        <div class="form-group">
            {{Form::label('Note', 'Note')}}
            {{Form::text('Note', $order->Note, ['class' => 'form-control', 'placeholder' => 'Note'])}}
        </div>


  <div class="container box">
   <div class="form-group">
   <label for="restaurant_id">Assign to restaurant:</label>
    <select name="restaurant_id" id="restaurant_id" class="form-control input-lg dynamic" data-dependent="reservation_id">
    <option value="">Select Restaurant</option>
        @foreach($restaurant as $restaurants)
            @if($restaurants->id ==$order->restaurant_id)  
                <option value='{{ $restaurants->id }}' >{{ $restaurants->Name }} ( {{$restaurants->restauranttype->Type_Name}})</option>
            @endif
        @endforeach
        @foreach($restaurant as $restaurants)
            @if($restaurants->id != $order->restaurant_id)  
                <option value='{{ $restaurants->id }}' >{{ $restaurants->Name }} ( {{$restaurants->restauranttype->Type_Name}})</option>
            @endif
        @endforeach
    </select>
   </div>
   <br />
   <div class="form-group">
   <label for="reservation_id">Assign to reservation:</label>
    <select name="reservation_id" id="reservation_id" class="form-control input-lg dynamic">
    <option value="">Select Reservation</option>
    </select>
    <h4>Note: if you select reservation the time of order will be the time of reservation time</h4>
   </div>
   
   {{ csrf_field() }}
   <br />

  </div>
  <br />

  <br>

  <div class="form-group">
   <label for="address_id">your address:<h3><p id="text" style="display:none">(Inside the Restaurant)</p></h3></label> 
    <select name="address_id" id="address_id" class="form-control input-lg dynamic">
     @if($order->ordertype == 1)
        <option value="" >select address</option>
    @else
        @foreach($youraddress as $youraddresss)
            @if($youraddresss->id == $order->address_id)
                <option value="{{ $youraddresss->id}}">{{ $youraddresss->Address}}_{{ $youraddresss->Zone }}_{{ $youraddresss->Street }}</option>
            @endif
        @endforeach
        @foreach($youraddress as $youraddresss)
            @if($youraddresss->id != $order->address_id)
                <option value="{{ $youraddresss->id}}">{{ $youraddresss->Address}}_{{ $youraddresss->Zone }}_{{ $youraddresss->Street }}</option>
            @endif
        @endforeach
    @endif
    </select>
   </div>

  <br /> 

        <a href="/address/create" target="_blank" class="btn btn-default">New Address</a>
        <br>
        <br>


        {{Form::hidden('_method','PUT')}}
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}

    
    <script>
$(document).ready(function(){

 $('.dynamic').change(function(){
  if($(this).val() != '')
  {
   var select = $(this).attr("id");
   var value = $(this).val();
   var dependent = $(this).data('dependent');
   var _token = $('input[name="_token"]').val();
   //debugger;
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