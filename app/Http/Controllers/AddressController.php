<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Models\Address;
use App\Models\User;

class AddressController extends Controller
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

        $myaddress = Address::where('user_id' , '=' , $user_id )->orderBy('created_at','desc')->paginate(10);
        $public_address = Address::where( 'restaurant_id' , '=' , 0)->where( 'user_id' , '=' , Null)->get();
        $restaurant_address = Address::where( 'restaurant_id' , '!=' , 0)->where( 'restaurant_id' , '!=' , Null)->get();

        return view('address.index')->with('public_address', $public_address)->with('restaurant_address', $restaurant_address)->with('myaddress', $myaddress);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('address.create');
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
            'address' => 'required',
            'zone' => 'required',
            'street' => 'required',
            'address_image' => 'image|nullable|max:1999'
        ]);

        // Handle File Upload
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

        // Create Address
        $address = new Address;
        $address->Address = $request->input('address');
        $address->Zone = $request->input('zone');
        $address->Street = $request->input('street');
        $address->Description = $request->input('description');
        $address->Note = $request->input('note');
        $address->Location = $request->input('location');
        $address->address_image = $fileNameToStore;
        $address->user_id = auth()->user()->id;
        $address->save();

        return redirect('/address')->with('success', 'Address Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $address = Address::find($id);

        return view('address.show')->with('address', $address);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $address = Address::find($id);
        
        //Check if address exists before deleting
        if (!isset($address)){
            return redirect('/address')->with('error', 'No Address Found');
        }

        return view('address.edit')->with('address', $address);
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
            'address' => 'required',
            'zone' => 'required',
            'street' => 'required',
            'address_image' => 'image|nullable|max:1999'
        ]);

        $address = Address::find($id);
        
         // Handle File Upload
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
            // Delete file if exists
            Storage::delete('public/address_image/'.$address->address_image);
		
	   //Make thumbnails
	    $thumbStore = 'thumb.'.$filename.'_'.time().'.'.$extension;
            $thumb = Image::make($request->file('address_image')->getRealPath());
            $thumb->resize(80, 80);
            $thumb->save('storage/address_image/'.$thumbStore);
		
        }
 
        // Update Address
        $address->Address = $request->input('address');
        $address->Zone = $request->input('zone');
        $address->Street = $request->input('street');
        $address->Description = $request->input('description');
        $address->Note = $request->input('note');
        $address->Location = $request->input('location');
        if($request->hasFile('address_image')){
            $address->address_image = $fileNameToStore;
        }
        $address->user_id = auth()->user()->id;;
        $address->save();

        return redirect('/address')->with('success', 'Address Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $address = Address::find($id);
        
        //Check if address exists before deleting
        if (!isset($address)){
            return redirect('/address')->with('error', 'No Address Found');
        }

        if($address->address_image != 'noimage.jpg'){
            // Delete Image
            Storage::delete('public/address_image/'.$address->address_image);
        }
        
        $address->delete();
        return redirect('/address')->with('success', 'Address Removed');
    }
}
