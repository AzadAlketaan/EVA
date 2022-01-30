<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Models\FoodType;
use App\Models\Food;

class FoodTypeAdminController extends Controller
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
        $foodtype = FoodType::orderBy('created_at','desc')->paginate(10);
        return view('foodtypeadmin.index')->with('foodtype', $foodtype);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('foodtypeadmin.create');
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

        // Create FoodType
        $foodtype = new FoodType;
        $foodtype->Type_Name = $request->input('Type_Name');
        $foodtype->Arabic_Name = $request->input('Arabic_Name');
        $foodtype->Description = $request->input('Description');
        $foodtype->type_image = $fileNameToStore;
        
        $foodtype->save();


        return redirect('/foodtypeadmin')->with('success', 'FoodType Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $foodtype = FoodType::find($id);
        return view('foodtypeadmin.show')->with('foodtype', $foodtype);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $foodtype = FoodType::find($id);
        
        //Check if FoodType exists before deleting
        if (!isset($foodtype)){
            return redirect('/foodtypeadmin')->with('error', 'No FoodType Found');
        }

        return view('foodtypeadmin.edit')->with('foodtype', $foodtype);
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

        $foodtype = FoodType::find($id);
        
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
            Storage::delete('public/type_image/'.$foodtype->type_image);
		
	   //Make thumbnails
	    $thumbStore = 'thumb.'.$filename.'_'.time().'.'.$extension;
            $thumb = Image::make($request->file('type_image')->getRealPath());
            $thumb->resize(80, 80);
            $thumb->save('storage/type_image/'.$thumbStore);
		
        }

        // Update foodtype
        $foodtype->Type_Name = $request->input('Type_Name');
        $foodtype->Arabic_Name = $request->input('Arabic_Name');
        $foodtype->Description = $request->input('Description');
        if($request->hasFile('type_image')){
            $foodtype->type_image = $fileNameToStore;
        }
        $foodtype->save();

        return redirect('/foodtypeadmin')->with('success', 'FoodType Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $foodtype = FoodType::find($id);
        $food = Food::where('foodtype_id' , '=' , $id)->delete();
        
        //Check if foodtype exists before deleting
        if (!isset($foodtype)){
            return redirect('/foodtypeadmin')->with('error', 'No FoodType Found');
        }

        if($foodtype->type_image != 'noimage.jpg'){
            // Delete Image
            Storage::delete('public/type_image/'.$foodtype->type_image);
        }
        
        $foodtype->delete();
        return redirect('/foodtypeadmin')->with('success', 'FoodType Removed');
    }
}
