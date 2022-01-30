<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Models\Evaluation;
use App\Models\Restaurant;
use App\Models\User;

class EvaluationAdminController extends Controller
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
     $evaluation = Evaluation::orderBy('created_at','desc')->paginate(10);
     $restaurant = Restaurant::all();

     return view('evaluationadmin.index')->with('evaluation', $evaluation)->with('restaurant', $restaurant);
 }

 /** 
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
 public function create()
 {
    $user = User::all();
    $restaurant = Restaurant::all();


    return view('evaluationadmin.create')->with('user', $user)->with('restaurant', $restaurant);
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
        'Price' => 'required',
        'Cleanliness' => 'required',
        'Speed_of_Order_Arrival' => 'required',
        'Food_Quality' => 'required',
        'Treatment_of_Employees' => 'required',
    ]);
    
    $user_id = $request->input('user_id');
    $restaurant_id = $request->input('restaurant_id');
    
    $evaluation_check = Evaluation::where('user_id' , '=' , $user_id )->where('restaurant_id' , '=' , $restaurant_id )->first();

    if ($evaluation_check != '') {

        return redirect('/evaluationadmin/create')->with('error', "You cannot evaluate the same restaurant by the same user");
    }

    // Create Evaluation
    $evaluation = new Evaluation;
    $evaluation->Price = $request->input('Price');
    $evaluation->Cleanliness = $request->input('Cleanliness');
    $evaluation->Speed_of_Order_Arrival = $request->input('Speed_of_Order_Arrival');
    $evaluation->Food_Quality = $request->input('Food_Quality');
    $evaluation->Location_of_The_Place = $request->input('Location_of_The_Place');
    $evaluation->Treatment_of_Employees = $request->input('Treatment_of_Employees');
    $evaluation->Positives = $request->input('Positives');
    $evaluation->Negatives = $request->input('Negatives');
    $evaluation->Description = $request->input('Description');
    $evaluation->Note = $request->input('Note');
    $evaluation->user_id = $request->input('user_id');
    $evaluation->restaurant_id = $request->input('restaurant_id');
    
    $evaluation->save();

     return redirect('/evaluationadmin')->with('success', 'Evaluation Created');
 }

 /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
 public function show($id)
 {
    $evaluation = Evaluation::find($id);
    $restaurant = Restaurant::where('id' , '=' , $evaluation->restaurant_id)->first();

    $average = collect([$evaluation->Price, $evaluation->Cleanliness,$evaluation->Speed_of_Order_Arrival,$evaluation->Food_Quality,$evaluation->Location_of_The_Place,$evaluation->Treatment_of_Employees])->avg();
    $average = round($average);

    return view('evaluationadmin.show')->with('average', $average)->with('restaurant', $restaurant)->with('evaluation', $evaluation);
 }

 /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
 public function edit($id)
 {
    $evaluation = Evaluation::find($id);
        
    //Check if Evaluation exists before deleting
    if (!isset($evaluation)){
        return redirect('/evaluation')->with('error', 'No Evaluation Found');
    }
    $restaurant = Restaurant::all();
    $user = User::all();

    return view('evaluationadmin.edit')->with('user', $user)->with('evaluation', $evaluation)->with('restaurant', $restaurant);
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
        'Price' => 'required',
        'Cleanliness' => 'required',
        'Speed_of_Order_Arrival' => 'required',
        'Food_Quality' => 'required',
        'Treatment_of_Employees' => 'required',
    ]);

    $evaluation = Evaluation::find($id);
    
    $user_id = $request->input('user_id');
    $restaurant_id = $request->input('restaurant_id');
    
    $evaluation_check = Evaluation::where('user_id' , '=' , $user_id )->where('restaurant_id' , '=' , $restaurant_id )->first();

    if ($evaluation_check->id  != $id) {

        return redirect("/evaluationadmin/$id/edit")->with('error', "You cannot evaluate the same restaurant by the same user");
    }


    // Update Evaluation
    $evaluation->Price = $request->input('Price');
    $evaluation->Cleanliness = $request->input('Cleanliness');
    $evaluation->Speed_of_Order_Arrival = $request->input('Speed_of_Order_Arrival');
    $evaluation->Food_Quality = $request->input('Food_Quality');
    $evaluation->Location_of_The_Place = $request->input('Location_of_The_Place');
    $evaluation->Treatment_of_Employees = $request->input('Treatment_of_Employees');
    $evaluation->Positives = $request->input('Positives');
    $evaluation->Negatives = $request->input('Negatives');
    $evaluation->Description = $request->input('Description');
    $evaluation->Note = $request->input('Note');
    $evaluation->user_id = $request->input('user_id');
    $evaluation->restaurant_id = $request->input('restaurant_id');
    
    $evaluation->save();

 
     return redirect('/evaluationadmin')->with('success', 'Evaluation Updated');
 }

 /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
 public function destroy($id)
 {
     $evaluation = Evaluation::find($id);
     
     //Check if Evaluation exists before deleting
     if (!isset($evaluation)){
         return redirect('/evaluationadmin')->with('error', 'No Evaluation Found');
     }

     $evaluation->delete();

     return redirect('/evaluationadmin')->with('success', 'Evaluation Removed');
 }
}
