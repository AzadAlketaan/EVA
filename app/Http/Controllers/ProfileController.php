<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Address;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
       // $this->middleware('CheckPermission', ['except' => ['index', 'show']]);
        
    }
    public function profile()
    {
        /*
        $latitude = '33.585545';
        $longitude = '36.375347';

        $radius = 400;
                                                                  //latitude  longitude 
        $address = Address::selectRaw("id, Address, Zone , Street , Location , Note , 
                     ( 6371 * acos( cos( radians(?) ) *
                       cos( radians( Location ) )
                       * cos( radians( Note ) - radians(?)
                       ) + sin( radians(?) ) *
                       sin( radians( Location ) ) )
                     ) AS distance", [$latitude, $longitude, $latitude])
        ->where('Location', '!=', Null)
        ->having("distance", "<", $radius)
        ->orderBy("distance",'asc')
        ->offset(0)
        ->limit(20)
        ->get();*/

        return view('auth.profile');
    }


}
