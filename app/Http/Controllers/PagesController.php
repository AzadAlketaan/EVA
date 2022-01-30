<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Notification;

use Redirect;
use App\Models\Restaurant;
use App\Models\RestaurantType;
use App\Models\Evaluation;
use App\Models\Address;
use App\Models\User;
use DB;

class PagesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'services' , 'about' , 'action_search']]);
        $this->middleware('CheckPermission' , ['except' => ['index', 'services' , 'about' , 'action_search' , 'cpanal']]);
    }

    public function index()
    {
        $filterarr[] = null;
        $data = array(
            'title' => 'filters',
            'filters' => ['Price' , 'Cleanliness' , 'Speed_of_Order_Arrival' , 'Food_Quality' ,'Location_of_The_Place' ,'Treatment_of_Employees']
        );
        $address = Address::where('restaurant_id' , '=' , 0)->get();

        $restauranttype = RestaurantType::all();

        $addressrestaurant = '';
        $searchrestaurant = '';
        $search_zone = '';
        $search_restauranttype = '';


        return view('pages.index')->with('search_restauranttype', $search_restauranttype)->with('restauranttype', $restauranttype)->with('search_zone', $search_zone)->with('searchrestaurant', $searchrestaurant)->with('addressrestaurant', $addressrestaurant)->with('address', $address)->with('filterarr', $filterarr)->with($data);
    }

    public function about(){
        $title = 'About Us';

        return view('pages.about')->with('title', $title);
    }

    public function services(){
        $data = array(
            'title' => 'Services',
            'services' => ['Web Design', 'Programming', 'SEO']
        );
        return view('pages.services')->with($data);
    }

    public function cpanal(){

        return view('pages.cpanal');
    }

    public function action_search(Request $request)
    {
        $searchrestaurant = $request->get('search');
        $searchzone = $request->get('zone_id');
        $searchrestauranttype = $request->get('restauranttype_id');

        $locationbtn = $request->get('locationbtn');

        //Al-Mazeh Al-Jalaaa Location 
        $latitude = '33.500828' ;
        
        $longitude = '36.253891';

        $radius = 2;

        $data = array(
            'title' => 'filters',
            'filters' => ['Price' , 'Cleanliness' , 'Speed_of_Order_Arrival' , 'Food_Quality' ,'Location_of_The_Place' ,'Treatment_of_Employees']
        );

        $search_zone = '';

        if(isset($_POST['filterarray']))
        {
            $filterarray[] = $_POST['filterarray'];
            foreach ($filterarray as $filterarrays) 
            {                      
                $filterarr[] = $filterarrays;
            }
        }else {
            $filterarr[] = '';
        }  

        $restauranttype = RestaurantType::all();
        $evaluation = Evaluation::all();        
        //$address = Address::where('restaurant_id' , '=' , 0)->get();

        $address = Address::all();


        if($locationbtn != Null)
        {
            $search_restauranttype = '';

            $addressrestaurant = Address::selectRaw("id, Address, Zone , Street , Location , Note , 
                     ( 6371 * acos( cos( radians(?) ) *
                       cos( radians( Location ) )
                       * cos( radians( Note ) - radians(?)
                       ) + sin( radians(?) ) *
                       sin( radians( Location ) ) )
                     ) AS distance", [$latitude, $longitude, $latitude])
            ->where('restaurant_id', '!=', Null)
            ->where('user_id', '=', Null)
            ->where('restaurant_id', '!=', 0)
            ->having("distance", "<", $radius)
            ->orderBy("distance",'asc')
            ->offset(0)
            ->limit(20)
            ->get();

            //dd($addressrestaurant);

            return view('pages.index')->with($data)->withMessage( 'No Details found. Try to search again !')
                ->with('searchrestaurant' , $searchrestaurant)->with('searchzone' , $searchzone)
                ->with('search_zone' , $search_zone)->with('address' , $address)
                ->with('addressrestaurant' , $addressrestaurant)->with('filterarr' , $filterarr)
                ->with('evaluation' , $evaluation)->with('restauranttype' , $restauranttype)
                ->with('search_restauranttype' , $search_restauranttype)
                ->with('searchrestauranttype' , $searchrestauranttype);

        }


        if($searchrestaurant != "" and $searchzone == "")
        {
            if ($searchrestauranttype != "") {

                $restaurant = Restaurant::where('restaurant_type_id' , '=' , $searchrestauranttype)
                ->where('Name','LIKE','%'.$searchrestaurant.'%')
                ->orWhere('Arabic_Name','LIKE','%'.$searchrestaurant.'%')->get();

                $search_restaurant_type = RestaurantType::where('id' , '=' , $searchrestauranttype )->first();
                $search_restauranttype = "$search_restaurant_type->Type_Name ( $search_restaurant_type->Arabic_Name )";

            }else{
                $search_restauranttype = '';
                $restaurant = Restaurant::where('Name','LIKE','%'.$searchrestaurant.'%')
                ->orWhere('Arabic_Name','LIKE','%'.$searchrestaurant.'%')->get();
            }
            
            $addressrestaurant = '';            
            
            if(count($restaurant) > 0)
            {                                                                   
                return view('pages.index')->with('restaurant' , $restaurant)
                ->with('search_zone' , $search_zone)
                ->with('searchrestaurant' , $searchrestaurant)
                ->with($data)->with('addressrestaurant' , $addressrestaurant)
                ->with('address' , $address)->with('filterarr' , $filterarr)
                ->with('evaluation' , $evaluation)->with('restauranttype' , $restauranttype)
                ->with('search_restauranttype' , $search_restauranttype)
                ->with('searchrestauranttype' , $searchrestauranttype);
            }
            else 
            {
                $addressrestaurant = '';
                return  view('pages.index')->withMessage( 'No Details found. Try to search again !')
                ->with('restaurant' , $restaurant)->with('search_zone' , $search_zone)
                ->with('searchzone' , $searchzone)->with($data)->with('addressrestaurant' , $addressrestaurant)
                ->with('address' , $address)->with('filterarr' , $filterarr)
                ->with('searchrestaurant' , $searchrestaurant)
                ->with('search_restauranttype' , $search_restauranttype)
                ->with('searchrestauranttype' , $searchrestauranttype);
            }               

        }elseif($searchzone != "") {  

            $search_zone = $searchzone;

            $ddress = Address::where('Address' , 'LIKE' , '%'.$address.'%')->get();  
            
            $address_num = strpos($search_zone, '/');
            $Address = substr ($search_zone, 0 , $address_num);
            
            $search_zone = str_replace('/', '', $search_zone);
            
            $zone_num = strpos($search_zone, '|' );
            $zone_num = $zone_num - $address_num;
            $zone = substr ($search_zone, $address_num , $zone_num);

            $search_zone = str_replace('|', '', $search_zone);

            $street_num = strpos($search_zone, '*' );
            $address_zone = $zone_num + $address_num;
            $street_num = $street_num - $address_zone;
            $street = substr ($search_zone, $address_zone , $street_num);

            $search_zone = "$Address $zone $street";

        ///*******************************************************************/
            if ($Address != '' and $zone == '' and $street == '') {
                
            //////

                //search by address and restaurant name  only
                if ($searchrestaurant != '' and $searchrestauranttype == '') {           

                    $addressrestaurant = DB::table('restaurants')
                    ->join('addresses', 'restaurants.id', '=', 'addresses.restaurant_id')
                    ->select('addresses.*')
                    ->where('addresses.Address' , 'LIKE' , '%'.$Address.'%')
                    ->where('restaurants.Name','LIKE','%'.$searchrestaurant.'%')
                    ->orWhere('restaurants.Arabic_Name','LIKE','%'.$searchrestaurant.'%')
                    ->get();

                    $search_restauranttype = '';

                }
                //search by address and restaurant type
                elseif ($searchrestaurant == '' and $searchrestauranttype != '') { 
                    
                        $addressrestaurant = DB::table('restaurants')
                        ->join('addresses', 'restaurants.id', '=', 'addresses.restaurant_id')
                        ->select('addresses.*')
                        ->where('addresses.Address' , 'LIKE' , '%'.$Address.'%')
                        ->where('restaurants.restaurant_type_id' , '=' , $searchrestauranttype)                        
                        ->get();

                        $search_restaurant_type = RestaurantType::where('id' , '=' , $searchrestauranttype )->first();
                        $search_restauranttype = "$search_restaurant_type->Type_Name ( $search_restaurant_type->Arabic_Name )";
                }
                //search by address and restaurant type andrestaurant name
                elseif ($searchrestaurant != '' and $searchrestauranttype != '') { 

                        $addressrestaurant = DB::table('restaurants')
                        ->join('addresses', 'restaurants.id', '=', 'addresses.restaurant_id')
                        ->select('addresses.*')
                        ->where('restaurants.restaurant_type_id' , '=' , $searchrestauranttype)
                        ->where('addresses.Address' , 'LIKE' , '%'.$Address.'%')
                        ->where('restaurants.Name','LIKE','%'.$searchrestaurant.'%')
                        ->orWhere('restaurants.Arabic_Name','LIKE','%'.$searchrestaurant.'%')
                        ->get();

                        $search_restaurant_type = RestaurantType::where('id' , '=' , $searchrestauranttype )->first();
                        $search_restauranttype = "$search_restaurant_type->Type_Name ( $search_restaurant_type->Arabic_Name )";
                }                
                //search by address only
                elseif($searchrestaurant == '' and $searchrestauranttype == '')
                {
                    $search_restauranttype = '';

                    $addressrestaurant = Address::where('Address' , 'LIKE' , '%'.$Address.'%')
                    ->where('restaurant_id' , '!=' , 0)->where('user_id' , '=' , Null)->get();                
                }

                return view('pages.index')->with($data)->withMessage( 'No Details found. Try to search again !')
                ->with('searchrestaurant' , $searchrestaurant)->with('search_zone' , $search_zone)
                ->with('searchzone' , $searchzone)->with('addressrestaurant' , $addressrestaurant)
                ->with('address' , $address)->with('filterarr' , $filterarr)->with('evaluation' , $evaluation)
                ->with('restauranttype' , $restauranttype)
                ->with('search_restauranttype' , $search_restauranttype)
                ->with('searchrestauranttype' , $searchrestauranttype);
            /////////////

        ///*******************************************************************/
            }elseif ($Address != '' and $zone != '' and $street == '') {
                //search by address and restaurant name  only
                if ($searchrestaurant != '' and $searchrestauranttype == '') {        
                    
                    $addressrestaurant = DB::table('restaurants')
                    ->join('addresses', 'restaurants.id', '=', 'addresses.restaurant_id')
                    ->select('addresses.*')
                    ->where('addresses.Address' , 'LIKE' , '%'.$Address.'%')
                    ->where('addresses.Zone' , 'LIKE' , '%'.$zone.'%')
                    ->where('restaurants.Name','LIKE','%'.$searchrestaurant.'%')
                    ->orWhere('restaurants.Arabic_Name','LIKE','%'.$searchrestaurant.'%')
                    ->get();     
                    
                    $search_restauranttype = '';

                }                
                //search by address and restaurant type
                elseif ($searchrestaurant == '' and $searchrestauranttype != '') { 
                    
                        $addressrestaurant = DB::table('restaurants')
                        ->join('addresses', 'restaurants.id', '=', 'addresses.restaurant_id')
                        ->select('addresses.*')
                        ->where('addresses.Address' , 'LIKE' , '%'.$Address.'%')
                        ->where('addresses.Zone' , 'LIKE' , '%'.$zone.'%')
                        ->where('restaurants.restaurant_type_id' , '=' , $searchrestauranttype)                        
                        ->get();

                        $search_restaurant_type = RestaurantType::where('id' , '=' , $searchrestauranttype )->first();
                        $search_restauranttype = "$search_restaurant_type->Type_Name ( $search_restaurant_type->Arabic_Name )";
                }
                //search by address and restaurant type andrestaurant name
                elseif ($searchrestaurant != '' and $searchrestauranttype != '') { 

                        $addressrestaurant = DB::table('restaurants')
                        ->join('addresses', 'restaurants.id', '=', 'addresses.restaurant_id')
                        ->select('addresses.*')
                        ->where('restaurants.restaurant_type_id' , '=' , $searchrestauranttype)
                        ->where('addresses.Address' , 'LIKE' , '%'.$Address.'%')
                        ->where('addresses.Zone' , 'LIKE' , '%'.$zone.'%')
                        ->where('restaurants.Name','LIKE','%'.$searchrestaurant.'%')
                        ->orWhere('restaurants.Arabic_Name','LIKE','%'.$searchrestaurant.'%')
                        ->get();
                        
                        $search_restaurant_type = RestaurantType::where('id' , '=' , $searchrestauranttype )->first();
                        $search_restauranttype = "$search_restaurant_type->Type_Name ( $search_restaurant_type->Arabic_Name )";

                }                
                //search by address only
                elseif($searchrestaurant == '' and $searchrestauranttype == '')
                {
                    $search_restauranttype = '';

                    $addressrestaurant = Address::where('Address' , 'LIKE' , '%'.$Address.'%')
                    ->where('Zone' , 'LIKE' , '%'.$zone.'%')->where('restaurant_id' , '!=' , 0)
                    ->where('user_id' , '=' , Null)->get();
                }     

                return view('pages.index')->with($data)->withMessage( 'No Details found. Try to search again !')
                ->with('searchrestaurant' , $searchrestaurant)->with('searchzone' , $searchzone)
                ->with('search_zone' , $search_zone)->with('address' , $address)
                ->with('addressrestaurant' , $addressrestaurant)->with('filterarr' , $filterarr)
                ->with('evaluation' , $evaluation)->with('restauranttype' , $restauranttype)
                ->with('search_restauranttype' , $search_restauranttype)
                ->with('searchrestauranttype' , $searchrestauranttype);


    ///*******************************************************************/
            }elseif($Address != '' and $zone != '' and $street != '') {
                
                if ($searchrestaurant != '' and $searchrestauranttype == '') {         

                    $addressrestaurant = DB::table('restaurants')
                    ->join('addresses', 'restaurants.id', '=', 'addresses.restaurant_id')
                    ->select('addresses.*')
                    ->where('addresses.Address' , 'LIKE' , '%'.$Address.'%')
                    ->where('addresses.Zone' , 'LIKE' , '%'.$zone.'%')
                    ->where('addresses.Street' , 'LIKE' , '%'.$street.'%')
                    ->where('restaurants.Name','LIKE','%'.$searchrestaurant.'%')
                    ->orWhere('restaurants.Arabic_Name','LIKE','%'.$searchrestaurant.'%')
                    ->get();  

                    $search_restauranttype = '';

                }
                //search by address and restaurant type
                elseif ($searchrestaurant == '' and $searchrestauranttype != '') { 
                    
                        $addressrestaurant = DB::table('restaurants')
                        ->join('addresses', 'restaurants.id', '=', 'addresses.restaurant_id')
                        ->select('addresses.*')
                        ->where('addresses.Address' , 'LIKE' , '%'.$Address.'%')
                        ->where('addresses.Zone' , 'LIKE' , '%'.$zone.'%')
                        ->where('addresses.Street' , 'LIKE' , '%'.$street.'%')
                        ->where('restaurants.restaurant_type_id' , '=' , $searchrestauranttype)                        
                        ->get();

                        $search_restaurant_type = RestaurantType::where('id' , '=' , $searchrestauranttype )->first();
                        $search_restauranttype = "$search_restaurant_type->Type_Name ( $search_restaurant_type->Arabic_Name )";

                }
                //search by address and restaurant type andrestaurant name
                elseif ($searchrestaurant != '' and $searchrestauranttype != '') { 

                        $addressrestaurant = DB::table('restaurants')
                        ->join('addresses', 'restaurants.id', '=', 'addresses.restaurant_id')
                        ->select('addresses.*')
                        ->where('restaurants.restaurant_type_id' , '=' , $searchrestauranttype)
                        ->where('addresses.Address' , 'LIKE' , '%'.$Address.'%')
                        ->where('addresses.Zone' , 'LIKE' , '%'.$zone.'%')
                        ->where('addresses.Street' , 'LIKE' , '%'.$street.'%')
                        ->where('restaurants.Name','LIKE','%'.$searchrestaurant.'%')
                        ->orWhere('restaurants.Arabic_Name','LIKE','%'.$searchrestaurant.'%')
                        ->get();

                        $search_restaurant_type = RestaurantType::where('id' , '=' , $searchrestauranttype )->first();
                        $search_restauranttype = "$search_restaurant_type->Type_Name ( $search_restaurant_type->Arabic_Name )";

                }                
                //search by address only
                elseif($searchrestaurant == '' and $searchrestauranttype == '')
                {
                    $search_restauranttype = '';

                    $addressrestaurant = Address::where('Address' , 'LIKE' , '%'.$Address.'%')
                    ->where('Zone' , 'LIKE' , '%'.$zone.'%')->where('Street' , 'LIKE' , '%'.$street.'%')
                    ->where('restaurant_id' , '!=' , 0)->where('user_id' , '=' , Null)->get();
                }
                return view('pages.index')->with($data)->withMessage( 'No Details found. Try to search again !')
                ->with('searchrestaurant' , $searchrestaurant)->with('search_zone' , $search_zone)
                ->with('searchzone' , $searchzone)->with('address' , $address)
                ->with('addressrestaurant' , $addressrestaurant)->with('filterarr' , $filterarr)
                ->with('evaluation' , $evaluation)->with('restauranttype' , $restauranttype)
                ->with('search_restauranttype' , $search_restauranttype)
                ->with('searchrestauranttype' , $searchrestauranttype);

            }
            
        }
        elseif ($searchrestaurant == "" and $searchzone == "" and $searchrestauranttype != '') {
            
            $restaurant = Restaurant::where('restaurant_type_id' , '=' , $searchrestauranttype)->get();

            $search_restaurant_type = RestaurantType::where('id' , '=' , $searchrestauranttype )->first();
            $search_restauranttype = "$search_restaurant_type->Type_Name ( $search_restaurant_type->Arabic_Name )";

            $addressrestaurant = '';
            
            if(count($restaurant) > 0)
            {                                                                   
                return view('pages.index')->with('restaurant' , $restaurant)->with('search_zone' , $search_zone)
                ->with('search_zone' , $search_zone)->with('searchrestaurant' , $searchrestaurant)->with($data)
                ->with('addressrestaurant' , $addressrestaurant)->with('address' , $address)
                ->with('filterarr' , $filterarr)->with('evaluation' , $evaluation)
                ->with('restauranttype' , $restauranttype)
                ->with('search_restauranttype' , $search_restauranttype)
                ->with('searchrestauranttype' , $searchrestauranttype);
            }
            else 
            {
                $addressrestaurant = '';
                return  view('pages.index')->withMessage( 'No Details found. Try to search again !')
                ->with('restaurant' , $restaurant)->with('search_zone' , $search_zone)
                ->with('searchzone' , $searchzone)->with($data)->with('addressrestaurant' , $addressrestaurant)
                ->with('address' , $address)->with('filterarr' , $filterarr)
                ->with('searchrestaurant' , $searchrestaurant)
                ->with('restauranttype' , $restauranttype)
                ->with('search_restauranttype' , $search_restauranttype)
                ->with('searchrestauranttype' , $searchrestauranttype);
            }              
        }
        else 
        {
            $addressrestaurant = '';
            $search_restauranttype = '';

            return view('pages.index')->withMessage( 'No Details found. Try to search again !')->with($data)
            ->with('address' , $address)->with('filterarr' , $filterarr)
            ->with('searchrestaurant' , $searchrestaurant)->with('search_zone' , $search_zone)
            ->with('addressrestaurant' , $addressrestaurant)->with('searchzone' , $searchzone)
            ->with('search_restauranttype' , $search_restauranttype)
            ->with('restauranttype' , $restauranttype)
            ->with('searchrestauranttype' , $searchrestauranttype);
        }    
    }


    
/*
 // @param1 : pass current latitude of the driver
 // @param2 : pass current longitude of the driver
 // @param3: pass the radius in meter within how much distance you wanted to fiter

private function findNearestRestaurants($latitude, $longitude, $radius = 400)
{
    
     // using eloquent approach, make sure to replace the "Restaurant" with your actual model name
     // replace 6371000 with 6371 for kilometer and 3956 for miles
     

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
        ->get();

    return $address;
}*/

    

}
