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
use App\Models\FoodRestaurant;
use App\Models\DrinkRestaurant;

class OrderController extends Controller
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
        $user_id = auth()->user()->id;

        $order = Order::where('user_id' , '=' , $user_id)->orderBy('created_at','desc')->paginate(10);
        $restaurant = Restaurant::all();
        $reservation = Reservation::where('user_id' , '=' , $user_id)->get();
        $address = Address::where('user_id' , '=' , $user_id)->get();
        

        return view('order.index')->with('order', $order)->with('address', $address)->with('reservation', $reservation)->with('restaurant', $restaurant);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        $user_id = auth()->user()->id;
        
        $restaurant = Restaurant::where('Reservation_Service' , '=' , 1)->get();
        $youraddress = Address::where('user_id' , '=' , $user_id)->get();

        return view('order.create')->with('youraddress', $youraddress)->with('restaurant', $restaurant);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if( $request->internalorder  != null )
        {
            $this->validate($request, [                
                'internalorder' => 'required',
                'Order' => 'required',
                'restaurant_id' => 'required',
                'reservation_id' => 'required'
            ]);

            // Create Order
            $order = new Order;
            $order->ordertype = 1;//1:internalorder
            $order->Order = $request->input('Order');
            $order->Note = $request->input('Note');
            $order->user_id =  auth()->user()->id;
            $order->restaurant_id = $request->input('restaurant_id');
            $reservation_id = $request->input('reservation_id');
            $reservation = Reservation::where('id' , '=' , $reservation_id)->first();
            $order->Time = $reservation->Start_Time;
            $address = Address::where('restaurant_id' , '=' , $order->restaurant_id )->first();
            $order->address_id = $address->id;

            $order->save();

            return redirect('/order')->with('success', 'Order Created');

        }


        if( $request->externalorder != null )
        {
            $this->validate($request, [                
                'externalorder' => 'required',
                'Time' => 'required',
                'Order' => 'required',
                'restaurant_id' => 'required',
                'address_id' => 'required'
            ]);

            // Create Order
            $order = new Order;
            $order->ordertype = 0;//0:external order
            $order->Time = $request->input('Time');
            $order->Order = $request->input('Order');
            $order->Note = $request->input('Note');
            $order->user_id =  auth()->user()->id;
            $order->restaurant_id = $request->input('restaurant_id');
            $order->address_id = $request->input('address_id');

            $order->save();

            return redirect('/order')->with('success', 'Order Created');

        }

        return redirect('/order/create')->with('error', 'Empty Order ( Be sure that you have chosen the type of order )');
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

        return view('order.show')->with('order', $order)->with('address', $address)->with('reservation', $reservation)->with('restaurant', $restaurant);
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
            return redirect('/order')->with('error', 'No Order Found');
        }

        $user_id = $order->user_id;
        
        $restaurant = Restaurant::where('Reservation_Service' , '=' , 1)->get();
        $reservation = Reservation::where('user_id' , '=' , $user_id)->where('restaurant_id' , '=' , $order->restaurant_id)->get();
        $youraddress = Address::where('user_id' , '=' , $user_id)->get();
        $address = Address::where('user_id' , '!=' , $user_id)->get();

        return view('order.edit')->with('youraddress', $youraddress)->with('address', $address)->with('reservation', $reservation)->with('restaurant', $restaurant)->with('order', $order);
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
        if( $request->internalorder  != null )
        {
                $this->validate($request, [                
                    'internalorder' => 'required',
                    'Order' => 'required',
                    'restaurant_id' => 'required',
                    'reservation_id' => 'required'
                ]);

                // Update Order
                $order = Order::find($id);

                $order->ordertype = 1;//1:internalorder
                $order->Order = $request->input('Order');
                $order->Note = $request->input('Note');
                $order->user_id =  auth()->user()->id;
                $order->restaurant_id = $request->input('restaurant_id');
                $reservation_id = $request->input('reservation_id');
                $reservation = Reservation::where('id' , '=' , $reservation_id)->first();
                $order->Time = $reservation->Start_Time;
                $address = Address::where('restaurant_id' , '=' , $order->restaurant_id )->first();
                $order->address_id = $address->id;

                $order->save();

                return redirect('/order')->with('success', 'Order Updated');

        }


            if( $request->externalorder != null )
            {
                $this->validate($request, [                
                    'externalorder' => 'required',
                    'Time' => 'required',
                    'Order' => 'required',
                    'restaurant_id' => 'required',
                    'address_id' => 'required'
                ]);

                // Update Order
                $order = Order::find($id);

                $order->ordertype = 0;//0:external order
                $order->Time = $request->input('Time');
                $order->Order = $request->input('Order');
                $order->Note = $request->input('Note');
                $order->user_id =  auth()->user()->id;
                $order->restaurant_id = $request->input('restaurant_id');
                $order->address_id = $request->input('address_id');

                $order->save();

                return redirect('/order')->with('success', 'Order Updated');

            }

            return redirect('/order/'.$id.'/edit')->with('error', 'Empty Order ( Be sure that you have chosen the type of order )');
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
            return redirect('/order')->with('error', 'No Order Found');
        }
        
        $order->delete();
        return redirect('/order')->with('success', 'Order Removed');
    }
 
    function fetch(Request $request)
    {
        date_default_timezone_set('Asia/Damascus');
        $date = date('yy-m-d h:m:s');      

        $user_id = auth()->user()->id;
   
        $select = $request->get('select');//id of select
        $value = $request->get('value');//id of restaurant
        $dependent = $request->get('dependent');//dependent on this

        $reservation = Reservation::where('Start_Time' , '>' , $date)->where('restaurant_id' , '=' , $value)->where('user_id' , '=' , $user_id)->get();
        $output = '<option value="">Select '.ucfirst('Reservation').'</option>';
        foreach($reservation as $reservations)
        {
            $output .= '<option value="'.$reservations->id.'">'.date('j F, Y h:m A', strtotime($reservations->Start_Time)).'</option>';
        }
        
    }
/*
    function fetchfood(Request $request)
    {
        $select = $request->get('select');//id of select
        $value = $request->get('value');//id of restaurant
        $dependent = $request->get('dependent');//dependent on this

        $foodrestaurant = FoodRestaurant::where('Restaurant_ID' , '=' , $value )->get();
        $output = '<option value="">Select '.ucfirst('Food').'</option>';
        foreach($foodrestaurant as $foodrestaurants)
        {
            $output .= '<option value="'.$foodrestaurants->food->Name. $foodrestaurants->food->Arabic_Name . '">'. $foodrestaurants->food->Name .$foodrestaurants->food->Arabic_Name.'</option>';
        }

    }

    function fetchdrink(Request $request)
    {
        $select = $request->get('select');//id of select
        $value = $request->get('value');//id of restaurant
        $dependent = $request->get('dependent');//dependent on this

        $drinkrestaurant = DrinkRestaurant::where('Restaurant_ID' , '=' , $value )->get();
        $output = '<option value="">Select '.ucfirst('Drink').'</option>';
        foreach($drinkrestaurant as $drinkrestaurants)
        {
            $output .= '<option value="'.$drinkrestaurants->drink->Name. $drinkrestaurants->drink->Arabic_Name .'">'. $drinkrestaurants->drink->Name .$drinkrestaurants->drink->Arabic_Name.'</option>';
        }

    }
    */
}
