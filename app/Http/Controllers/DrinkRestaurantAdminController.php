<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

use App\Models\Drink;
use App\Models\DrinkRestaurant;
use Session;

class DrinkRestaurantAdminController extends Controller
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
        $drink = Drink::all();
        
        $restaurant_id = Session::get('restaurant_id');
        $drinkrestaurant = DrinkRestaurant::where('Restaurant_ID' , '=' , $restaurant_id)->get();
        if ($drinkrestaurant != '[]') {
            foreach ($drinkrestaurant as $drinkrestaurants) {
                $assigneddrinks[] = $drinkrestaurants->Drink_ID;
            }
        }
        else{
            $assigneddrinks[] = Null;
        }

        return view('drinkrestaurantadmin.index')->with('drink' , $drink)->with('assigneddrinks' , $assigneddrinks);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $restaurant_id = Session::get('restaurant_id'); 

        $drinkrestaurant = DrinkRestaurant::where('Restaurant_ID' , '=' , $restaurant_id)->where('Drink_ID' , '=' , $id);

        $drinkrestaurant->delete();

        return redirect()->back();
    }
 

    public function assigndrinkrestaurantadmin($drinkid)
    {
        $restaurant_id = Session::get('restaurant_id'); 

        $drinkrestaurant = new DrinkRestaurant;
        $drinkrestaurant->Restaurant_ID = $restaurant_id;
        $drinkrestaurant->Drink_ID = $drinkid;

        $drinkrestaurant->save();

        return redirect()->back();

    }
}
