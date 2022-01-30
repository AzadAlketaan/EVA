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
    <h1>New Order</h1>
    {!! Form::open(['action' => 'App\Http\Controllers\OrderAdminController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    <div class="form-group">
            {{Form::label('Time of order', 'Time of order')}}
            <input type="time" id="Time" name="Time">
        </div>
        <div class="form-group">
            {{Form::label('Your order', 'Your order')}}
            {{Form::text('Order', '', ['class' => 'form-control', 'placeholder' => 'Order'])}}
        </div>
        <div class="form-group">
            {{Form::label('Note', 'Note')}}
            {{Form::text('Note', '', ['class' => 'form-control', 'placeholder' => 'Note'])}}
        </div>

        <div class="container box">
        <div class="form-group">
   <label for="user_id">Assign to User:</label>
    <select name="user_id" id="user_id" class="form-control input-lg dynamic">
     <option value="">Select User</option>
     @foreach($user as $users)
        <option value="{{ $users->id}}">{{ $users->First_Name }} {{$users->Last_Name}}</option>
     @endforeach
    </select>
   </div>
   <br />
   <div class="form-group">
   <label for="restaurant_id">Assign to restaurant:</label>
    <select name="restaurant_id" id="restaurant_id" class="form-control input-lg dynamic" data-dependent="reservation_id">
     <option value="">Select Restaurant</option>
     @foreach($restaurant as $restaurants)
        <option value="{{ $restaurants->id}}">{{ $restaurants->Name }} ( {{$restaurants->restauranttype->Type_Name}})</option>
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

   <div class="form-group">
   <label for="address_id">your address:</label>
    <select name="address_id" id="address_id" class="form-control input-lg dynamic">
     <option value="">Inside the Restaurant</option>
     @foreach($address as $addresss)
     <option value="{{ $addresss->id}}">{{ $addresss->Address}}_{{ $addresss->Zone }}_{{ $addresss->Street }}</option>
     @endforeach
    </select>
   </div>

  </div>
  <br>

        <a href="/address/create" target="_blank" class="btn btn-default">New Address</a>
        <br>
        <br>


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
   var user_id = $('select[id="user_id"]').val();
   if(select != 'user_id'){
   debugger;
   $.ajax({
    url:"{{ route('orderadmin.fetch') }}",
    method:"POST",
    data:{select:select, value:value,user_id:user_id, _token:_token, dependent:dependent},
    success:function(result)
    {
     $('#'+dependent).html(result);
    }

   })
   }
  }
 });

 $('#restaurant_id').change(function(){
  $('#reservation_id').val('');
 });

 

});
</script>

@endsection