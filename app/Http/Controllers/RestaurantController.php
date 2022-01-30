<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Models\Restaurant;
use App\Models\Evaluation;
use App\Models\User;
use App\Models\RestaurantType;
use App\Models\UserRestaurant;
use App\Models\FoodRestaurant;
use App\Models\DrinkRestaurant;
use App\Models\Food;
use App\Models\Drink;
use App\Models\Order;
use App\Models\Reservation;
use Auth;
use Session;
use App\Models\Address;


class RestaurantController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
        $this->middleware('CheckPermission', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $restaurant = Restaurant::orderBy('created_at', 'desc')->paginate(10);
        $restauranttype = RestaurantType::all();
        $evaluation = Evaluation::all();
        $address = Address::all();

        if (!Auth::guest()) {
            $user_id = auth()->user()->id;

            $userrestaurant = UserRestaurant::where('user_id', '=', $user_id)->get();
            if ($userrestaurant != '[]') {
                foreach ($userrestaurant as $userrestaurants) {
                    $myrestaurants[] = $userrestaurants->restaurant->id;
                }
            } else {
                $myrestaurants[] = Null;
            }

            return view('restaurant.index')->with('address', $address)->with('myrestaurants', $myrestaurants)->with('userrestaurant', $userrestaurant)->with('restaurant', $restaurant)->with('restauranttype', $restauranttype);
        }

        return view('restaurant.index')->with('address', $address)->with('evaluation', $evaluation)->with('restaurant', $restaurant)->with('restauranttype', $restauranttype);
    }

    /** 
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $restauranttype = RestaurantType::all();

        return view('restaurant.create')->with('restauranttype', $restauranttype);
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
            'Name' => 'required',
            'Arabic_Name' => 'required',
            'Phone_Number1' => 'required',
            'Status' => 'required',
            'Time_Open' => 'required',
            'Time_Close' => 'required',
            'Delivery_Service' => 'required',
            'Reservation_Service' => 'required',
            'restaurant_type_id' => 'required',
            'restaurant_image' => 'image|nullable|max:1999',
            'address' => 'required',
            'zone' => 'required',
            'street' => 'required',
        ]);

        // Handle Restaurant File Upload
        if ($request->hasFile('restaurant_image')) {
            // Get filename with the extension
            $filenameWithExt = $request->file('restaurant_image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('restaurant_image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $path = $request->file('restaurant_image')->storeAs('public/restaurant_image', $fileNameToStore);

            // make thumbnails
            $thumbStore = 'thumb.' . $filename . '_' . time() . '.' . $extension;
            $thumb = Image::make($request->file('restaurant_image')->getRealPath());
            $thumb->resize(80, 80);
            $thumb->save('storage/restaurant_image/' . $thumbStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }

        // Handle Address File Upload
        if($request->hasFile('address_image')){
            // Get filename with the extension
            $filenameWithExt = $request->file('address_image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('address_image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('address_image')->storeAs('public/address_image', $fileNameToStore);
		
	    // make thumbnails
	    $thumbStore = 'thumb.'.$filename.'_'.time().'.'.$extension;
            $thumb = Image::make($request->file('address_image')->getRealPath());
            $thumb->resize(80, 80);
            $thumb->save('storage/address_image/'.$thumbStore);
		
        } else {
            $fileNameToStore = 'noimage.jpg';
        }


        // Create Restaurant
        $restaurant = new Restaurant;
        $restaurant->Name = $request->input('Name');
        $restaurant->Arabic_Name = $request->input('Arabic_Name');
        $restaurant->Phone_Number1 = $request->input('Phone_Number1');
        $restaurant->Phone_Number2 = $request->input('Phone_Number2');
        $restaurant->Phone_Number3 = $request->input('Phone_Number3');
        $restaurant->Recommended_Evaluation = $request->input('Recommended_Evaluation');
        $restaurant->Status = $request->input('Status');
        $restaurant->Time_Open = $request->input('Time_Open');
        $restaurant->Time_Close = $request->input('Time_Close');
        $restaurant->Delivery_Service = $request->input('Delivery_Service');
        $restaurant->Reservation_Service = $request->input('Reservation_Service');
        $restaurant->Description = $request->input('description');
        $restaurant->Note = $request->input('note');
        $restaurant->restaurant_type_id = $request->input('restaurant_type_id');
        $restaurant->restaurant_image = $fileNameToStore;
        $restaurant->save();
        
        // Create UserRestaurant
        $userrestaurant = new UserRestaurant;
        $userrestaurant->user_id = auth()->user()->id;
        $userrestaurant->restaurant_id = $restaurant->id;
        $userrestaurant->save();

        // Create Address
        $address = new Address;
        $address->Address = $request->input('address');
        $address->Zone = $request->input('zone');
        $address->Street = $request->input('street');
        $address->address_image = $fileNameToStore;
        $address->restaurant_id = $restaurant->id;
        $address->user_id = auth()->user()->id;
        $address->save();
 

        return redirect('/restaurant')->with('success', 'Restaurant Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $restaurant = Restaurant::find($id);

        $restauranttype = RestaurantType::where('id', '=', $restaurant->restaurant_type_id)->first();

        Session::put('restaurant_id', $id);

        $foodrestaurant = FoodRestaurant::where('Restaurant_ID' , '=' , $id)->get();        
        $drinkrestaurant = DrinkRestaurant::where('Restaurant_ID' , '=' , $id)->get();
        $food = Food::all();
        $drink = Drink::all();

        $userrestaurant = UserRestaurant::where('restaurant_id' , '=' , $id)->get();
        $user = User::all();

        $address = Address::all();

        return view('restaurant.show')->with('address', $address)->with('user', $user)->with('userrestaurant', $userrestaurant)->with('drink', $drink)->with('food', $food)->with('foodrestaurant', $foodrestaurant)->with('drinkrestaurant', $drinkrestaurant)->with('restaurant', $restaurant)->with('restauranttype', $restauranttype);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $restaurant = Restaurant::find($id);

        //Check if restaurant exists before deleting
        if (!isset($restaurant)) {
            return redirect('/restaurant')->with('error', 'No Restaurant Found');
        }

        $restauranttype = RestaurantType::all();
        $address = Address::where('restaurant_id' , '=' , $id)->first();

        return view('restaurant.edit')->with('address', $address)->with('restaurant', $restaurant)->with('restauranttype', $restauranttype);
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
            'Name' => 'required',
            'Arabic_Name' => 'required',
            'Phone_Number1' => 'required',
            'Status' => 'required',
            'Time_Open' => 'required',
            'Time_Close' => 'required',
            'Delivery_Service' => 'required',
            'Reservation_Service' => 'required',
            'restaurant_type_id' => 'required',
            'restaurant_image' => 'image|nullable|max:1999',
            'address' => 'required',
            'zone' => 'required',
            'street' => 'required'
        ]);

        $restaurant = Restaurant::find($id);

        // Handle Restaurant File Upload
        if ($request->hasFile('restaurant_image')) {
            // Get filename with the extension
            $filenameWithExt = $request->file('restaurant_image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('restaurant_image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $path = $request->file('restaurant_image')->storeAs('public/restaurant_image', $fileNameToStore);
            // Delete file if exists
            Storage::delete('public/restaurant_image/' . $restaurant->restaurant_image);

            //Make thumbnails
            $thumbStore = 'thumb.' . $filename . '_' . time() . '.' . $extension;
            $thumb = Image::make($request->file('restaurant_image')->getRealPath());
            $thumb->resize(80, 80);
            $thumb->save('storage/restaurant_image/' . $thumbStore);
        }

        // Update Restaurant
        $restaurant->Name = $request->input('Name');
        $restaurant->Arabic_Name = $request->input('Arabic_Name');
        $restaurant->Phone_Number1 = $request->input('Phone_Number1');
        $restaurant->Phone_Number2 = $request->input('Phone_Number2');
        $restaurant->Phone_Number3 = $request->input('Phone_Number3');
        $restaurant->Recommended_Evaluation = $request->input('Recommended_Evaluation');
        $restaurant->Status = $request->input('Status');
        $restaurant->Time_Open = $request->input('Time_Open');
        $restaurant->Time_Close = $request->input('Time_Close');
        $restaurant->Delivery_Service = $request->input('Delivery_Service');
        $restaurant->Reservation_Service = $request->input('Reservation_Service');
        $restaurant->Description = $request->input('description');
        $restaurant->Note = $request->input('note');
        $restaurant->restaurant_type_id = $request->input('restaurant_type_id');

        if ($request->hasFile('restaurant_image')) {
            $restaurant->restaurant_image = $fileNameToStore;
        }
        $restaurant->save();
        
        // Update Address
        $address_id = Address::where('restaurant_id' , '=' , $id)->first();
        $address = Address::find($address_id->id);       
        $address->Address = $request->input('address');
        $address->Zone = $request->input('zone');
        $address->Street = $request->input('street');
        $address->restaurant_id = $id;
        $address->user_id = auth()->user()->id;
        $address->save();

        return redirect('/restaurant')->with('success', 'Restaurant Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    { 
        $restaurant = Restaurant::find($id);
        $address = Address::where('restaurant_id' , '=' , $id)->first();
        $userrestaurant = UserRestaurant::where('restaurant_id' , '=' , $id)->delete();
        $foodrestaurant = FoodRestaurant::where('restaurant_id' , '=' , $id)->delete();
        $drinkrestaurant = DrinkRestaurant::where('restaurant_id' , '=' , $id)->delete();
        $evaluation = Evaluation::where('restaurant_id' , '=' , $id)->delete();
        $order = Order::where('restaurant_id' , '=' , $id)->delete();
        $reservation = Reservation::where('restaurant_id' , '=' , $id)->delete();

        //Check if restaurant exists before deleting
        if (!isset($restaurant)) {
            return redirect('/restaurant')->with('error', 'No Restaurant Found');
        } 

        if ($restaurant->restaurant_image != 'noimage.jpg') {
            // Delete Image
            Storage::delete('public/restaurant_image/' . $restaurant->restaurant_image);
        }
        //Check if address exists before deleting
        if (!isset($address)) {
            return redirect('/address')->with('error', 'No Address Found');
        }

        if ($address->address_image != 'noimage.jpg') {
            // Delete Image
            Storage::delete('public/address_image/' . $address->address_image);
        }

        $restaurant->delete();
        $address->delete();
        

        return redirect('/restaurant')->with('success', 'Restaurant Removed');
    }
}
