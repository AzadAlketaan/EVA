<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Models\DrinkType;
use App\Models\Drink;

class DrinkTypeController extends Controller
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
        $drinktype = DrinkType::orderBy('created_at','desc')->paginate(10);
         
        return view('drinktype.index')->with('drinktype', $drinktype);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('drinktype.create');
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

        // Create DrinkType
        $drinktype = new DrinkType;
        $drinktype->Type_Name = $request->input('Type_Name');
        $drinktype->Arabic_Name = $request->input('Arabic_Name');
        $drinktype->Description = $request->input('Description');
        $drinktype->type_image = $fileNameToStore;
        
        $drinktype->save();


        return redirect('/drinktype')->with('success', 'DrinkType Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $drinktype = DrinkType::find($id);
        $drink = Drink::where('drinktype_id' , '=' , $id)->get();

        return view('drinktype.show')->with('drinktype', $drinktype)->with('drink', $drink);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $drinktype = DrinkType::find($id);
        
        //Check if DrinkType exists before deleting
        if (!isset($drinktype)){
            return redirect('/drinktype')->with('error', 'No DrinkType Found');
        }

        return view('drinktype.edit')->with('drinktype', $drinktype);
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

        $drinktype = DrinkType::find($id);
        
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
            Storage::delete('public/type_image/'.$drinktype->type_image);
		
	   //Make thumbnails
	    $thumbStore = 'thumb.'.$filename.'_'.time().'.'.$extension;
            $thumb = Image::make($request->file('type_image')->getRealPath());
            $thumb->resize(80, 80);
            $thumb->save('storage/type_image/'.$thumbStore);
		
        }

        // Update Drink
        $drinktype->Type_Name = $request->input('Type_Name');
        $drinktype->Arabic_Name = $request->input('Arabic_Name');
        $drinktype->Description = $request->input('Description');
        if($request->hasFile('type_image')){
            $drinktype->type_image = $fileNameToStore;
        }
        $drinktype->save();

        return redirect('/drinktype')->with('success', 'DrinkType Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $drinktype = DrinkType::find($id);
        
        //Check if Drink exists before deleting
        if (!isset($drinktype)){
            return redirect('/drinktype')->with('error', 'No DrinkType Found');
        }

        if($drinktype->type_image != 'noimage.jpg'){
            // Delete Image
            Storage::delete('public/type_image/'.$drinktype->type_image);
        }
        
        $drinktype->delete();
        return redirect('/drinktype')->with('success', 'DrinkType Removed');
    }
}
