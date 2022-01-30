<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

use App\Models\Food;
use App\Models\FoodRestaurant;
use Session;

class FoodRestaurantController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('CheckPermission');
        $this->middleware('CheckOwner',['only' => ['index', 'destroy' , 'assignfoodrestaurant']] );
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $food = Food::all();
        
        $restaurant_id = Session::get('restaurant_id');
        $foodrestaurant = FoodRestaurant::where('Restaurant_ID' , '=' , $restaurant_id)->get();
        if ($foodrestaurant != '[]') {
            foreach ($foodrestaurant as $foodrestaurants) {
                $assignedfoods[] = $foodrestaurants->Food_ID;
            }
        }
        else{
            $assignedfoods[] = Null;
        }

        return view('foodrestaurant.index')->with('food' , $food)->with('assignedfoods' , $assignedfoods);
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

        $foodrestaurant = FoodRestaurant::where('Restaurant_ID' , '=' , $restaurant_id)->where('Food_ID' , '=' , $id);

        $foodrestaurant->delete();

        return redirect()->back();
    }


    public function assignfoodrestaurant($foodid)
    {
        $restaurant_id = Session::get('restaurant_id'); 

        $foodrestaurant = new FoodRestaurant;
        $foodrestaurant->Restaurant_ID = $restaurant_id;
        $foodrestaurant->Food_ID = $foodid;

        $foodrestaurant->save();

        return redirect()->back();

    }
}
