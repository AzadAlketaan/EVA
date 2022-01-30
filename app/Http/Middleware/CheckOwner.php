<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use App\Models\UserRestaurant;
use Session;

class CheckOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next )
    {
        $User_ID =  auth()->user()->id;
        $restaurant_id = Session::get('restaurant_id');

        //print_r($restaurant_id);
        //dd($restaurant_id);
        $userrestaurant = UserRestaurant::where('User_ID' , '=' , $User_ID)->where('Restaurant_ID' , '=' , $restaurant_id)->get();
        //print_r($userrestaurant);

        if ($userrestaurant != '[]')
        {
            //dd('azad');
            
            return $next($request);
        } 
        
        return response('You not owner of the restaurant'); 
    }
}
