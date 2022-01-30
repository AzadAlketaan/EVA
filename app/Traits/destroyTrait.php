<?php

namespace App\Traits;

use App\Traits\destroyTrait;

use App\Models\Restaurant;
use App\Models\Evaluation;
use App\Models\UserRestaurant;
use App\Models\FoodRestaurant;
use App\Models\DrinkRestaurant;
use App\Models\Order;
use App\Models\Reservation;
use App\Models\Address;

 
trait destroyTrait {
 
    public function destroyrestaurant($id)
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
        if (isset($address)) {
            if ($address->address_image != 'noimage.jpg') {
                // Delete Image
                Storage::delete('public/address_image/' . $address->address_image);
            }
        }

        $address = Address::where('restaurant_id' , '=' , $id)->delete();

        $restaurant->delete();

    }
 
}