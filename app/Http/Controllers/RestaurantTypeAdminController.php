<?php

namespace App\Http\Controllers;

use App\Traits\destroyTrait;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Models\RestaurantType;
use App\Models\Restaurant;
use App\Models\User;

class RestaurantTypeAdminController extends Controller
{
    use destroyTrait;

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
        $restauranttype = RestaurantType::orderBy('created_at','desc')->paginate(10);
        return view('restauranttypeadmin.index')->with('restauranttype', $restauranttype);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('restauranttypeadmin.create');
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
            'Type_Name' => 'required',
            'Arabic_Name' => 'required',
            'type_image' => 'image|nullable|max:1999'
        ]);

        // Handle File Upload
        if($request->hasFile('type_image')){
            // Get filename with the extension
            $filenameWithExt = $request->file('type_image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('type_image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('type_image')->storeAs('public/type_image', $fileNameToStore);
		
	    // make thumbnails
	    $thumbStore = 'thumb.'.$filename.'_'.time().'.'.$extension;
            $thumb = Image::make($request->file('type_image')->getRealPath());
            $thumb->resize(80, 80);
            $thumb->save('storage/type_image/'.$thumbStore);
		
        } else {
            $fileNameToStore = 'noimage.jpg';
        }

        // Create RestaurantType
        $restauranttype = new RestaurantType;
        $restauranttype->Type_Name = $request->input('Type_Name');
        $restauranttype->Arabic_Name = $request->input('Arabic_Name');
        $restauranttype->Description = $request->input('Description');
        $restauranttype->type_image = $fileNameToStore;
        
        $restauranttype->save();


        return redirect('/restauranttypeadmin')->with('success', 'RestaurantType Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $restauranttype = RestaurantType::find($id);
        return view('restauranttypeadmin.show')->with('restauranttype', $restauranttype);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $restauranttype = RestaurantType::find($id);
        
        //Check if RestaurantType exists before deleting
        if (!isset($restauranttype)){
            return redirect('/restauranttypeadmin')->with('error', 'No RestaurantType Found');
        }

        return view('restauranttypeadmin.edit')->with('restauranttype', $restauranttype);
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
            'Type_Name' => 'required',
            'Arabic_Name' => 'required',
            'type_image' => 'image|nullable|max:1999'
        ]);

        $restauranttype = RestaurantType::find($id);
        
         // Handle File Upload
        if($request->hasFile('type_image')){
            // Get filename with the extension
            $filenameWithExt = $request->file('type_image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('type_image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('type_image')->storeAs('public/type_image', $fileNameToStore);
            // Delete file if exists
            Storage::delete('public/type_image/'.$restauranttype->type_image);
		
	   //Make thumbnails
	    $thumbStore = 'thumb.'.$filename.'_'.time().'.'.$extension;
            $thumb = Image::make($request->file('type_image')->getRealPath());
            $thumb->resize(80, 80);
            $thumb->save('storage/type_image/'.$thumbStore);
		
        }

        // Update restauranttype
        $restauranttype->Type_Name = $request->input('Type_Name');
        $restauranttype->Arabic_Name = $request->input('Arabic_Name');
        $restauranttype->Description = $request->input('Description');
        if($request->hasFile('type_image')){
            $restauranttype->type_image = $fileNameToStore;
        }
        $restauranttype->save();

        return redirect('/restauranttypeadmin')->with('success', 'RestaurantType Updated');
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $restauranttype = RestaurantType::find($id);

        $restaurant = Restaurant::where('restaurant_type_id' , '=' , $id )->get();

        //dd($restaurant);
        foreach ($restaurant as $restaurants) {
            $this->destroyrestaurant($restaurants->id);
        }
        
        //Check if restauranttype exists before deleting
        if (!isset($restauranttype)){
            return redirect('/restauranttypeadmin')->with('error', 'No RestaurantType Found');
        }

        if($restauranttype->type_image != 'noimage.jpg'){
            // Delete Image
            Storage::delete('public/type_image/'.$restauranttype->type_image);
        }
        
        $restauranttype->delete();

        return redirect('/restauranttypeadmin')->with('success', 'RestaurantType Removed');
    }
}
