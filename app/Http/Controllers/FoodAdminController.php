<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Models\Food;
use App\Models\FoodType;

class FoodAdminController extends Controller
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
       $food = Food::orderBy('created_at','desc')->paginate(10);

       return view('foodadmin.index')->with('food', $food);
   }
   
   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
        $foodtype = FoodType::all();

       return view('foodadmin.create')->with('foodtype', $foodtype);
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
           'foodtype_id' => 'required',
           'food_image' => 'image|nullable|max:1999'          
       ]);
 
       // Handle File Upload
       if($request->hasFile('food_image')){
           // Get filename with the extension
           $filenameWithExt = $request->file('food_image')->getClientOriginalName();
           // Get just filename
           $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
           // Get just ext
           $extension = $request->file('food_image')->getClientOriginalExtension();
           // Filename to store
           $fileNameToStore= $filename.'_'.time().'.'.$extension;
           // Upload Image
           $path = $request->file('food_image')->storeAs('public/food_image', $fileNameToStore);
       
       // make thumbnails
       $thumbStore = 'thumb.'.$filename.'_'.time().'.'.$extension;
           $thumb = Image::make($request->file('food_image')->getRealPath());
           $thumb->resize(80, 80);
           $thumb->save('storage/food_image/'.$thumbStore);
       
       } else {
           $fileNameToStore = 'noimage.jpg';
       }
 
       // Create food
       $food = new Food;
       $food->Name = $request->input('Name');
       $food->Arabic_Name = $request->input('Arabic_Name');
       $food->Price = $request->input('Price');
       $food->Description = $request->input('Description');
       $food->foodtype_id = $request->input('foodtype_id');
       $food->food_image = $fileNameToStore;
       
       $food->save();


       return redirect('/foodadmin')->with('success', 'Food Created');
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function show($id)
   {
       $food = Food::find($id);

       return view('foodadmin.show')->with('food', $food);
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit($id)
   {
       $food = Food::find($id);

       $foodtype = FoodType::all();
       
       //Check if Food exists before deleting
       if (!isset($food)){
           return redirect('/food')->with('error', 'No Food Found');
       }

       return view('foodadmin.edit')->with('food', $food)->with('foodtype', $foodtype);
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
           'foodtype_id' => 'required',
           'food_image' => 'image|nullable|max:1999'
       ]);

       $food = Food::find($id);
       
        // Handle File Upload
       if($request->hasFile('food_image')){
           // Get filename with the extension
           $filenameWithExt = $request->file('food_image')->getClientOriginalName();
           // Get just filename
           $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
           // Get just ext
           $extension = $request->file('food_image')->getClientOriginalExtension();
           // Filename to store
           $fileNameToStore= $filename.'_'.time().'.'.$extension;
           // Upload Image
           $path = $request->file('food_image')->storeAs('public/food_image', $fileNameToStore);
           // Delete file if exists
           Storage::delete('public/food_image/'.$food->food_image);
       
      //Make thumbnails
       $thumbStore = 'thumb.'.$filename.'_'.time().'.'.$extension;
           $thumb = Image::make($request->file('food_image')->getRealPath());
           $thumb->resize(80, 80);
           $thumb->save('storage/food_image/'.$thumbStore);
       
       }

       // Update Food
       $food->Name = $request->input('Name');
       $food->Arabic_Name = $request->input('Arabic_Name');
       $food->Price = $request->input('Price');
       $food->Description = $request->input('Description');
       if($request->hasFile('food_image')){
           $food->food_image = $fileNameToStore;
       }
       $food->foodtype_id = $request->input('foodtype_id');
       $food->save();

       return redirect('/foodadmin')->with('success', 'Food Updated');
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
       $food = Food::find($id);
       
       //Check if Food exists before deleting
       if (!isset($food)){
           return redirect('/foodadmin')->with('error', 'No Food Found');
       }

       if($food->food_image != 'noimage.jpg'){
           // Delete Image
           Storage::delete('public/food_image/'.$food->food_image);
       }
       
       $food->delete();
       return redirect('/foodadmin')->with('success', 'Food Removed');
   }
}
