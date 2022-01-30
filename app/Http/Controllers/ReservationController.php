<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Restaurant;


class ReservationController extends Controller
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

        $reservation = Reservation::where('user_id' , '=' , $user_id)->orderBy('created_at','desc')->paginate(10);
        $restaurant = Restaurant::all(); 

        return view('reservation.index')->with('reservation', $reservation)->with('restaurant', $restaurant);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $restaurant = Restaurant::where('Reservation_Service' , '=' , 1)->get();

        return view('reservation.create')->with('restaurant', $restaurant);
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
            'Start_Time' => 'required',
            'Number_of_People' => 'required',
            'restaurant_id' => 'required',
        ]);

        // Create Reservation
        $reservation = new Reservation;
        $reservation->Start_Time = $request->input('Start_Time');
        $reservation->End_Time = $request->input('End_Time');
        $reservation->Number_of_People = $request->input('Number_of_People');
        $reservation->Table_Number = $request->input('Table_Number');
        $reservation->restaurant_id = $request->input('restaurant_id');
        $reservation->user_id = auth()->user()->id;
        $reservation->order_id = $request->input('order_id');
        
        $reservation->save();

        return redirect('/reservation')->with('success', 'Reservation Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { 
        $reservation = Reservation::find($id);
        $restaurant = Restaurant::where('id' , '=' , $reservation->restaurant_id)->first();

        return view('reservation.show')->with('reservation', $reservation)->with('restaurant', $restaurant);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $reservation = Reservation::find($id);
        
        //Check if reservation exists before deleting
        if (!isset($reservation)){
            return redirect('/reservation')->with('error', 'No Reservation Found');
        }
        $restaurant = Restaurant::where('Reservation_Service' , '=' , 1)->get();

        return view('reservation.edit')->with('reservation', $reservation)->with('restaurant', $restaurant);
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
            'Start_Time' => 'required',
            'Number_of_People' => 'required',
            'restaurant_id' => 'required',
        ]);

        $reservation = Reservation::find($id);

        // Update Reservation
        $reservation->Start_Time = $request->input('Start_Time');
        $reservation->End_Time = $request->input('End_Time');
        $reservation->Number_of_People = $request->input('Number_of_People');
        $reservation->Table_Number = $request->input('Table_Number');
        $reservation->restaurant_id = $request->input('restaurant_id');
        $reservation->user_id = auth()->user()->id;
        $reservation->order_id = $request->input('order_id');
        
        $reservation->save();

        return redirect('/reservation')->with('success', 'Reservation Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reservation = Reservation::find($id);
        
        //Check if reservation exists before deleting
        if (!isset($reservation)){
            return redirect('/reservation')->with('error', 'No Reservation Found');
        }

        $reservation->delete();
        return redirect('/reservation')->with('success', 'Reservation Removed');
    }
}
