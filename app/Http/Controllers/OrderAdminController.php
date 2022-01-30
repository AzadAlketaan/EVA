<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Models\Order;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\Reservation;
use App\Models\Address;

class OrderAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('CheckPermission');
    }
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order = Order::orderBy('created_at','desc')->paginate(10);
        
        $user = User::all();
        $restaurant = Restaurant::all();
        $reservation = Reservation::all();
        $address = Address::all();

        return view('orderadmin.index')->with('user', $user)->with('address', $address)->with('order', $order)->with('restaurant', $restaurant)->with('reservation', $reservation);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::all();
        $restaurant = Restaurant::all();
        $address = Address::all();

        return view('orderadmin.create')->with('user', $user)->with('address', $address)->with('restaurant', $restaurant);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'Time' => 'required',
            'Order' => 'required',
            'restaurant_id'=> 'required'
        ]);

        // Create Order
        $order = new Order;
        if($request->input('reservation_id') != null){
            $reservation_id = $request->input('reservation_id');
            $reservation = Reservation::where('id' , '=' , $reservation_id)->first();
            $order->Time = $reservation->Start_Time;
        }else if($request->input('reservation_id') == null){
            $order->Time = $request->input('Time');
        }
        
        $order->Order = $request->input('Order');
        $order->Note = $request->input('Note');
        $order->user_id = $request->input('user_id');
        $order->restaurant_id = $request->input('restaurant_id');
        $order->address_id = $request->input('address_id');
        $order->reservation_id = $request->input('reservation_id');
        
        $order->save();

        return redirect('/orderadmin')->with('success', 'Order Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::find($id);

        $restaurant = Restaurant::where('id' , '=' , $order->restaurant_id)->first();
        $reservation = Reservation::where('id' , '=' , $order->reservation_id)->first();                
        $address = Address::where('id' , '=' , $order->address_id)->first();

        return view('orderadmin.show')->with('order', $order)->with('address', $address)->with('reservation', $reservation)->with('restaurant', $restaurant);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::find($id);
        
        //Check if order exists before deleting
        if (!isset($order)){
            return redirect('/orderadmin')->with('error', 'No Order Found');
        }
        $user_id = $order->user_id;
        $user = user::all();

        $restaurant = Restaurant::all();
        $reservation = Reservation::where('user_id' , '=' , $user_id)->where('restaurant_id' , '=' , $order->restaurant_id)->get();
        $youraddress = Address::where('user_id' , '=' , $user_id)->get();
        $address = Address::where('user_id' , '!=' , $user_id)->get();

        return view('orderadmin.edit')->with('user', $user)->with('youraddress', $youraddress)->with('address', $address)->with('reservation', $reservation)->with('restaurant', $restaurant)->with('order', $order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'Time' => 'required',
            'Order' => 'required',
            'restaurant_id' => 'required'
        ]);

        $order = Order::find($id);

        // Update Order
        if($request->input('reservation_id') != null){
            $reservation_id = $request->input('reservation_id');
            $reservation = Reservation::where('id' , '=' , $reservation_id)->first();
            $order->Time = $reservation->Start_Time;
        }else if($request->input('reservation_id') == null){
            $order->Time = $request->input('Time');
        }
        $order->Order = $request->input('Order');
        $order->Note = $request->input('Note');
        $order->user_id =  $request->input('user_id');
        $order->restaurant_id = $request->input('restaurant_id');
        $order->address_id = $request->input('address_id');
        $order->reservation_id = $request->input('reservation_id');
        $order->save();

        return redirect('/orderadmin')->with('success', 'Order Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id);
        
        //Check if order exists before deleting
        if (!isset($order)){
            return redirect('/orderadmin')->with('error', 'No Order Found');
        }
        
        $order->delete();
        
        return redirect('/orderadmin')->with('success', 'Order Removed');
    }

    function fetch(Request $request)
    {
        $user_id = $request->get('user_id');
   
        $select = $request->get('select');//id of select
        $value = $request->get('value');//id of restaurant
        $dependent = $request->get('dependent');//dependent on this
        $reservation = Reservation::where('restaurant_id' , '=' , $value)->where('user_id' , '=' , $user_id)->get();
        $output = '<option value="">Select '.ucfirst('Reservation').'</option>';
        foreach($reservation as $reservations)
        {
            $output .= '<option value="'.$reservations->id.'">'.date('j F, Y h:m A', strtotime($reservations->Start_Time)).'</option>';
        }
        echo $output;
    }
    
}
