<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Models\Drink;
use App\Models\DrinkType;
use App\Models\DrinkRestaurant;
use App\Models\Restaurant;

class DrinkController extends Controller
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
        $drink = Drink::orderBy('created_at','desc')->paginate(10);
        $drinktype = DrinkType::all();

        return view('drink.index')->with('drink', $drink)->with('drinktype', $drinktype);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $drinktype = DrinkType::all();

        return view('drink.create')->with('drinktype', $drinktype);
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
            'Price' => 'required',
            'drinktype_id'=> 'required',
            'drink_image' => 'image|nullable|max:1999'
        ]);

        // Handle File Upload
        if($request->hasFile('drink_image')){
            // Get filename with the extension
            $filenameWithExt = $request->file('drink_image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('drink_image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('drink_image')->storeAs('public/drink_image', $fileNameToStore);
		
	    // make thumbnails
	    $thumbStore = 'thumb.'.$filename.'_'.time().'.'.$extension;
            $thumb = Image::make($request->file('drink_image')->getRealPath());
            $thumb->resize(80, 80);
            $thumb->save('storage/drink_image/'.$thumbStore);
		
        } else {
            $fileNameToStore = 'noimage.jpg';
        }

        // Create Drink
        $drink = new Drink;
        $drink->Name = $request->input('Name');
        $drink->Arabic_Name = $request->input('Arabic_Name');
        $drink->Price = $request->input('Price');
        $drink->Description = $request->input('Description');
        $drink->drinktype_id = $request->input('drinktype_id');
        $drink->drink_image = $fileNameToStore;
        
        $drink->save();


        return redirect('/drink')->with('success', 'Drink Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $drink = Drink::find($id);
        $drinktype = DrinkType::where('id' , '=' , $drink->drinktype_id )->first();

        $drinkrestaurant = DrinkRestaurant::where('Drink_ID' , '=' , $id)->get();        
        $restaurant = Restaurant::all();

        return view('drink.show')->with('drinkrestaurant', $drinkrestaurant)->with('restaurant', $restaurant)->with('drink', $drink)->with('drinktype', $drinktype);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $drink = Drink::find($id);
        
        //Check if Drink exists before deleting
        if (!isset($drink)){
            return redirect('/drink')->with('error', 'No Drink Found');
        }

        $drinktype = DrinkType::all();

        return view('drink.edit')->with('drink', $drink)->with('drinktype', $drinktype);
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
            'Price' => 'required',
            'drinktype_id'=> 'required',
            'drink_image' => 'image|nullable|max:1999'
        ]);

        $drink = Drink::find($id);
        
         // Handle File Upload
        if($request->hasFile('drink_image')){
            // Get filename with the extension
            $filenameWithExt = $request->file('drink_image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('drink_image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('drink_image')->storeAs('public/drink_image', $fileNameToStore);
            // Delete file if exists
            Storage::delete('public/drink_image/'.$drink->drink_image);
		
	   //Make thumbnails
	    $thumbStore = 'thumb.'.$filename.'_'.time().'.'.$extension;
            $thumb = Image::make($request->file('drink_image')->getRealPath());
            $thumb->resize(80, 80);
            $thumb->save('storage/drink_image/'.$thumbStore);
		
        }

        // Update Drink
        $drink->Name = $request->input('Name');
        $drink->Arabic_Name = $request->input('Arabic_Name');
        $drink->Price = $request->input('Price');
        $drink->Description = $request->input('Description');
        $drink->drinktype_id = $request->input('drinktype_id');
        if($request->hasFile('drink_image')){
            $drink->drink_image = $fileNameToStore;
        }
        $drink->save();

        return redirect('/drink')->with('success', 'Drink Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $drink = Drink::find($id);
        
        //Check if Drink exists before deleting
        if (!isset($drink)){
            return redirect('/drink')->with('error', 'No Drink Found');
        }

        if($drink->drink_image != 'noimage.jpg'){
            // Delete Image
            Storage::delete('public/drink_image/'.$drink->drink_image);
        }
        
        $drink->delete();
        return redirect('/drink')->with('success', 'Drink Removed');
    }

    public function assigndrinkrestaurant($id)
    {
        $drink_restaurant = new DrinkRestaurant;
        $drink_restaurant->$request->input('restaurant_id');
        $drink_restaurant->$drink->id;

        $drink_restaurant->save();
    }
}
