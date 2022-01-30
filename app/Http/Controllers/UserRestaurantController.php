<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\UserRestaurant;
use Session;
 
class UserRestaurantController extends Controller
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
        $user = User::all();
        
        $restaurant_id = Session::get('restaurant_id');
        
        $userrestaurant = UserRestaurant::where('Restaurant_ID' , '=' , $restaurant_id)->get();
        if ($userrestaurant != '[]') {
            foreach ($userrestaurant as $userrestaurants) {
                $assignedusers[] = $userrestaurants->user_id;
            }
        }
        else{
            $assignedusers[] = Null;
        }

        return view('userrestaurant.index')->with('user' , $user)->with('assignedusers' , $assignedusers);;
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

        $userrestaurant = UserRestaurant::where('restaurant_id' , '=' , $restaurant_id)->where('user_id' , '=' , $id)->delete();

        return redirect()->back();
    }

    public function assignuserrestaurant($userid)
    {
        $restaurant_id = Session::get('restaurant_id'); 

        $userrestaurant = new UserRestaurant;
        $userrestaurant->restaurant_id = $restaurant_id;
        $userrestaurant->user_id = $userid;

        $userrestaurant->save();

        return redirect()->back();

    }
}
